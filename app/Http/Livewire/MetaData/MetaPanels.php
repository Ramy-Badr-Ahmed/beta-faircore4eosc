<?php

namespace App\Http\Livewire\MetaData;

use App\Models\SoftwareHeritageRequest;
use App\Models\SwMetaForm;
use App\Modules\SwhApi\Archive;
use DOMException;
use ErrorException;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Livewire\Component;
use Throwable;
use UnhandledMatchError;

class MetaPanels extends Component
{
    use Properties, Hooks, Internals, Conversions;

    protected $listeners = [
        'listEvent' => 'fillList',
        'fromJS' => 'activateImport',
        'decreasePerson',
        'tripMode' => 'setTripModeFromJS',
    ];

    /**
     * @throws ValidationException
     */
    public function throwAnySessionErrors(): void
    {
        $sessionErrors = $this->sessionValidationErrors;

        $this->reset('sessionValidationErrors');

        throw ValidationException::withMessages($sessionErrors);
    }

    public function fillList(): void
    {
        if(!isset($this->formData['licenseInput'])){
            $this->licenses = Arr::map(self::$spdx->getLicenses(), function($val){
                return $val[1];
            });
        }
        $this->dispatchBrowserEvent('showDropdown');
    }

    public function activateImport(bool $value): void
    {
        $this->viewFlags['jsonReadOnly'] = $value;
    }

    public function setTripModeFromJS(string $mode): void
    {
        $this->viewFlags['tripMode'] = $mode;
    }

    public function activatePill(string $navPill): void
    {
        $this->viewFlags = Arr::map($this->viewFlags, function ($bool, $flag) use($navPill){
            if(Str::of($flag)->match('/active/i')->value() === 'Active'){
                return $navPill === $flag;
            }
            return $bool;
        });

        if(!in_array(Str::of($navPill)->match('/.*(?=Active)/')->value(), ['json', 'swhXML'])){
            $this->viewFlags['swPublished'] = true;
        }
        $this->resetAllSteps();
    }

    public function activateJSONMode(bool $readOnly): void
    {
        $this->viewFlags['jsonReadOnly'] = $readOnly;

        if($this->getErrorBag()->has($readOnly ? 'codeMetaImport' : 'codeMetaJSON')){
            $this->viewFlags['jsonPanel'] = true;
        }
    }


    /**
     * @throws DOMException
     * @throws ValidationException|Throwable
     * @throws ErrorException
     */
    public function proceedTo(int $nextStep): void
    {
        $this->proceedValidations(key($this->getActiveTab()));

        session()->flash('stepPass', "Step <b>".$this->viewPanel."/3</b> completed. Please proceed with "
            . ($nextStep === 3 ? "this <b>final Step</b>." : "<b>Step ".$nextStep."</b>.") );

        $this->viewPanel++;

        $this->dispatchBrowserEvent('triggerCSS');

        if(session()->has('schemeValidationErrors')){
            $this->denyCurrentStep();
            throw ValidationException::withMessages(session('schemeValidationErrors'));
        }
    }

    public function getLicenseByIdentifier(string $selectedLicense): void
    {
        $spdxLicense = self::$spdx->getLicenseByIdentifier($selectedLicense);
        [ $this->formData['license'], $this->formData['licenseInput'] ] = [ substr($spdxLicense[2], 0, strpos($spdxLicense[2], "#" )),  $spdxLicense[0] ];
    }

    /**
     * @throws ValidationException
     */
    public function save(): Redirector|Application|RedirectResponse
    {
        $this->generateCodeMeta();

        Storage::put('codeMeta.json', $this->codeMetaJSON);

        $this->viewPanel = 1;

        $codeMeta = new SwMetaForm();
        $codeMeta->add2DB($this->codeMetaJSON);

        return redirect(route('lw-meta-form'))
            ->with('success-animation-codeMeta', 'CodeMeta.json has been saved!');
    }


    /**
     * @throws ValidationException
     */
    public function download(string $metaType): StreamedResponse
    {
        if($metaType !== 'id_codeMetaImport'){
            $this->generateCodeMeta();
        }

        $path = match($metaType){
            'id_codeMetaImport' => 'codeMetaImport.json',
            'id_codeMetaJSON'   => 'codeMeta.json',
            'id_swhXML'   => 'swhXML.xml',
            'id_bibTex'   => 'bibTex.bib',
            'id_bibLaTex' => 'bibLaTex.bib',
            'id_dataCite' => 'dataCite.json',
            default       => 'emptyFile'
        };

        Storage::put($path, match ($metaType){
            'id_codeMetaImport' => $this->codeMetaImport ?? '',
            'id_codeMetaJSON'   => $this->codeMetaJSON ?? '',
            'id_swhXML'   => $this->swhXML ?? '',
            'id_bibTex'   => $this->bibTex ?? '',
            'id_bibLaTex' => $this->bibLaTex ?? '',
            'id_dataCite' => $this->dataCite ?? '',
            default => ''
        });

        return Storage::disk()->download($path);
    }

    public function copy(string $target) : void
    {
        $this->dispatchBrowserEvent('copy2ClipBoard', ['textArea' => $target]);
    }

    public function erase(): void
    {
        $this->reset('formData', 'codeMetaJSON', 'codeMetaImport', 'bibTex', 'bibLaTex', 'dataCite', 'viewFlags');

        $this->viewPanel = 1;
        $this->formData['author'] = $this->formData['funder']
            = $this->formData['contributor'] = $this->formData['maintainer'] = array([]);
        for($i=1; $i<=3; $i++){
            unset($this->viewFlags['panel'.$i.'Success'], $this->viewFlags['panel'.$i.'Failed']);
        }
        session()->forget(['validationErrors', 'schemeValidationErrors']);

        session()->flash('erased-success', "Panels have been erased! You can start anew.");

        $this->dispatchBrowserEvent('triggerCSS', ['ScrollOnly'=> true]);
    }

    /**
     * @throws ValidationException
     */
    public function generateCodeMeta(bool $dynamicRules = false, bool $filteredRules = false): void
    {
        //if(!$filteredRules) self::checkIfFrontEnd();      // no delay

        $this->reset('codeMetaImport');

        $data = $this->formData;

        if(empty(array_values($data['author'])[0])){
            unset($data['author']);
            if(empty($data)){
                $this->resetCurrentStep();
                session()->flash('stepEmpty', "Please provide your form inputs.");
                $this->dispatchBrowserEvent('triggerCSS', ['ScrollOnly'=> true]);
                return;
            }
        }

        $this->validate4JsonTab($dynamicRules, $filteredRules);

        $this->generateData($data);

        $this->codeMetaJSON = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $this->emit('equateHeights', 'codeMetaJSON');

        if($this->viewFlags['tripMode'] === 'defer' ){
            $this->emit('bounceTextArea', 'codeMetaJSON');
        }
    }

    /**
     * @throws ValidationException
     * @throws ErrorException
     */
    public function extractCodeMeta() : void
    {
        try{
            if($this->codeMetaImport === null){
                $this->resetRightPanel();
                session()->flash('stepEmpty', "Please provide your valid JSON.");
                return;
            }

            $codeMetaImport = $this->parseJSON($this->codeMetaImport);

            if(isset($codeMetaImport['@context']) && $codeMetaImport['@context'] !== Constants::CONTEXT['@context']) {
                throw ValidationException::withMessages(['codeMetaImport' => "\n @context must be: ". Constants::CONTEXT['@context'] ]) ;
            }

            self::checkCodeMetaKeys($codeMetaImport);
            $this->scatter2FormData($codeMetaImport);

            $this->emit('playCheck');

        }catch (ValidationException | ErrorException $e){
            if($e instanceof ErrorException){
                session()->flash('Unsupported', "Sorry, unsupported format yet!");
                return;
            }
            $this->viewFlags['jsonPanel'] = false;
            $e->validator->errors()->add('scatterError', ' ');
            throw $e;
        }
    }

    public function removePerson(string $property, int $idx): void
    {
        match ($property){
            'author' => $this->removeAuthor($property, $idx),
            'contributor', 'maintainer' => $this->removeNonAuthor($property, $idx),
        };
    }

    public function removeAuthor(string $property, int $idx): void
    {
        if($this->authorNumber === 1){
            return;
        }
        unset($this->formData[$property][$idx]);
        $this->formData[$property] = array_merge([], $this->formData[$property]);
        if(empty($this->formData['author'])){
            $this->formData['author'] = Array([]);
        }
        $this->emit('removePerson', $property, $idx + 1, $this->authorNumber);
    }

    public function decreasePerson(string $person): void
    {
        $person = $person.'Number';
        $this->{$person}--;
    }

    public function removeNonAuthor(string $property, int $idx): void
    {
        $thisProperty = $property.'Number';

        if(!isset($this->formData[$property])){
            $this->emit('removePerson', $property, $idx + 1, $this->{$thisProperty});
            return;
        }
        unset($this->formData[$property][$idx]);
        $this->formData[$property] = array_values($this->formData[$property]);

        $this->emit('removePerson', $property, $idx + 1, $this->{$thisProperty});
    }

    public function removeFunder(int $funder): void
    {
        if($this->funderNumber === 2){
            $this->viewFlags['swFunders'] = false;
        }
        unset($this->formData['funder'][$funder]);
        $this->formData['funder'] = array_merge([], $this->formData['funder'] ?? []);
        if(empty($this->formData['funder'])){
            unset($this->formData['funder']);
        }
        $this->funderNumber--;
    }

    /**
     * @throws ValidationException
     */
    public function resetIndex(string $property, int $idx): void
    {
        $this->formData[$property][$idx] = [];

        if(preg_match('/.*(?<!funder)/', $property, $match)){
            $this->emit('scrollTo', $match[0], $idx  + 1);
        }
        if($this->viewFlags['tripMode']!=='defer'){
            $this->generateCodeMeta(true);
        }
    }

    /**
     * @throws Exception
     */
    public function archiveNow(): void
    {
        try{
            $depositArchival = new Archive($this->formData['codeRepository']);
            $saveResponse = $depositArchival->save2Swh();

            if($saveResponse instanceof Throwable){
                throw new Exception();
            }

            $saveResponse["origin_url"] = $this->formData['codeRepository'];

            $newUrl = new SoftwareHeritageRequest();
            $newUrl->populateFromPostForm($saveResponse);

            $this->archivalRunning = true;

        }catch(UnhandledMatchError | Exception $e){
            throw ValidationException::withMessages(['formData.codeRepository' => 'Archival Error. Please try it in an archival page for more details.']);
        }
    }

    #[NoReturn] public static function dumpDie(): void
    {
        echo '<pre>'.print_r("<b>Security Warning</b>: Tampering detected.\n
                  One of the following [name, id, data] has been tampered with (or corrupted) between requests.\n
                  Our LiveWire App has Exited! <b>Please reload the page and start afresh.</b>\n\n
                  Nothing to worry about!\n
                  Greetings from LZI-Dagstuhl.",true).'</pre>';
        exit;
    }

}
