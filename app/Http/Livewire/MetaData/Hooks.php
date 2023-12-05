<?php

namespace App\Http\Livewire\MetaData;

use App\Modules\MetaData\Conversion;
use Composer\Spdx\SpdxLicenses;
use DOMException;
use ErrorException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use JsonException;
use Livewire\Livewire;
use RuntimeException;
use Throwable;

trait Hooks
{

    public function boot(): void
    {
        self::$spdx = new SpdxLicenses();

        $this->rules = config('metaForm.rules') ?? [];
        $this->messages = config('metaForm.messages') ?? [];
        $this->validationAttributes = config('metaForm.validationAttributes') ?? [];

        try {
            if (empty($this->rules) || empty($this->messages) || empty($this->validationAttributes)) {
                throw new RuntimeException();
            }
            self::$conversion = new Conversion();

        } catch (FileNotFoundException | ErrorException | RuntimeException $e) {
            $this->viewFlags['readOnceError'] = true;
        }
    }

    public function mount(SessionManager $session): void
    {
        try {
            $this->vocabularyRead = json_decode(File::get(base_path('resources/CodeMeta/Vocabulary-V2.json')), true,
                flags: JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE);

            $this->formTerms = json_decode(File::get(base_path('resources/CodeMeta/formTerms.json')), true,
                flags: JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE);

            $session->put("lwInstance", uuid_create());

            $this->licenses = Arr::map(self::$spdx->getLicenses(), function ($val) {
                return $val[1];
            });
            $this->formData['author'] = array([]);

        } catch (FileNotFoundException | JsonException $e) {
            $this->viewFlags['readOnceError'] = true;
        }
    }

    public function render(): Factory|View|Application
    {
        if ($this->viewFlags['readOnceError']) {
            return view('livewire.meta-data.meta-panels')->with('time', now('Europe/Berlin'))->with('readOnceError', "Out of Service");
        }
        if (session()->has('tripMode')) {
            [$this->formData, $sessionViewFlags, $this->viewPanel, $this->codeMetaJSON] = session('filledData');

            session()->remove('filledData');
            $sessionViewFlags['tripMode'] = Str::lower(session('tripMode'));

            $this->viewFlags = array_merge($this->viewFlags, $sessionViewFlags);
            if (session()->has('validationErrors')) {
                $this->sessionValidationErrors = session('validationErrors');
            }
        }

        return view('livewire.meta-data.meta-panels')
            ->with('time', now('Europe/Berlin'));
    }

    public function dehydrate(): void
    {
        $this->dispatchBrowserEvent('onDehydrate');
    }

    public function updating($property): void
    {
        if($this->viewFlags['tripMode'] !== 'defer'){
            if(Str::contains($property, ['license', 'codeMetaImport'])){
                $this->shouldSkipGenerate = true;
            }
            if(preg_match('/.*(?<!funder)(?=Number)/', $property, $match)){
                $this->emit('scrollTo', $match[0], $this->{$property}+1);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    public function updated($property): void
    {
        switch (true){
            case $this->shouldSkipGenerate;
            case Str::contains($property, 'tripMode'): return;

            case $this->viewFlags['tripMode'] !== "defer" && !Str::contains($property, "viewFlags"):

                self::checkClearedFields($this->formData);

                if(key($this->getActiveTab()) !== 'jsonActive'){
                    $this->generateCodeMeta(filteredRules: true);
                    return;
                }

                $this->emitBounceOnce();
                $this->generateCodeMeta(true);
                return;

            case preg_match('/.*(?<!funder)(?=Number)/', $property, $match):

                $this->emit('scrollTo', $match[0], $this->{$property});
                break;
        }
        self::checkClearedFields($this->formData);
    }

    public function updatingViewFlagsTripMode(): void
    {
        session()->put('filledData',
            [
                $this->formData,
                Arr::except($this->viewFlags, 'tripMode'),
                $this->viewPanel,
                $this->codeMetaJSON ?? null
            ]
        );
    }

    public function updatedViewFlagsTripMode(): Redirector|Application|RedirectResponse
    {
        return redirect(route('lw-meta-form'), 302, [], true)
            ->with('tripMode', Str::ucfirst($this->viewFlags['tripMode']));
    }

    public function updatedViewFlagsSwPublished(): void
    {
        $this->eraseDataOnViewFlags(Constants::SW_PUBLISHED_CODEMETA_KEYS);
    }

    public function updatedViewFlagsSwRelease(): void
    {
        $this->eraseDataOnViewFlags(Constants::SW_RELEASE_CODEMETA_KEYS);

        if(Str::contains($this->getErrorBag()->first('formData.dateModified'), 'SW Release instance')){
            $this->resetErrorBag('formData.dateModified');
        }
    }

    public function updatedViewFlagsSwRepository(): void
    {
        $this->eraseDataOnViewFlags(Constants::REPOSITORY_CODEMETA_KEYS);
    }
    public function updatedViewFlagsSwBundle(): void
    {
        $this->eraseDataOnViewFlags(array_merge(Constants::BUNDLE_CODEMETA_KEYS, Constants::FILESYSTEM_CODEMETA_KEYS));
    }

    public function updatedViewFlagsSwFileSystem(): void
    {
        $this->eraseDataOnViewFlags(Constants::FILESYSTEM_CODEMETA_KEYS);
    }

    public function updatedViewFlagsSwCode(): void
    {
        $this->eraseDataOnViewFlags(array_merge(Constants::CODE_CODEMETA_KEYS, Constants::PERFORMANCE_CODEMETA_KEYS));
    }
    public function updatedViewFlagsSwRequirements(): void
    {
        $this->eraseDataOnViewFlags(Constants::PERFORMANCE_CODEMETA_KEYS);
    }

    public function updatedViewFlagsSwFunders(): void
    {
        Arr::map(Arr::only($this->formData, ['funder']), function($fundersArray, $key){
            foreach ($fundersArray as $idx => $funderArray){
                if($idx === 0)
                    continue;

                foreach ($funderArray as $funderKey=>$funderValue){
                    if(isset($funderValue)){
                        unset($this->formData[$key][$idx][$funderKey]);
                    }
                }
            }
        });
    }

    public function updatedFormDataLicenseInput(): void
    {
        $this->licenses = self::filterLicensesList($this->formData['licenseInput'] ?? null);

        if(empty($this->licenses)){
            unset($this->formData['licenseInput'], $this->formData['license']);
        }
        $this->dispatchBrowserEvent('showDropdown');
    }

    /**
     * @param string $selectedLicense
     * @throws ValidationException
     */
    public function updatedFormDataLicense(string $selectedLicense): void
    {
        if($this->viewFlags['tripMode'] !== 'defer'){
            $this->getLicenseByIdentifier($selectedLicense);
            $this->emitBounceOnce();
            $this->generateCodeMeta();
        }
    }

    /**
     * @throws DOMException
     * @throws ValidationException|Throwable
     * @throws ErrorException
     */
    public function updatingViewPanel($to): void
    {
        if($this->viewPanel > (int)$to) $this->resetTrailingStep();

        else $this->proceedTo($to);
    }

    public function updatingCodeMetaImport(): void
    {
        if(!isset($this->codeMetaImport)){
            $this->emit('bounceTextArea', 'codeMetaImport');
        }
    }

    public function updatedCodeMetaImport(): void
    {
        if(empty($this->codeMetaImport)){
            $this->reset('codeMetaImport');
        }
        $this->reset('codeMetaJSON');
        $this->emit('equateHeights', 'codeMetaImport');
    }

    /**
     * @throws ValidationException
     */
    public function updatedFormDataCodeRepository(): void
    {

        $this->reset('isKnown', 'archivalRunning');

        $this->validateOnly('formData.codeRepository', $this->rules['step2']);

        $this->checkRepoWithSwh();

    }

}
