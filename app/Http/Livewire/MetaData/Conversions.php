<?php

namespace App\Http\Livewire\MetaData;

use App\Modules\MetaData\Conversions\BibLatex;
use App\Modules\MetaData\Conversions\BibTex;
use App\Modules\MetaData\Conversions\DataCite;
use App\Modules\MetaData\Conversions\CodemetaConversion;
use App\Modules\MetaData\SWHDeposit;
use Composer\Spdx\SpdxLicenses;
use DOMException;
use ErrorException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

trait Conversions
{
    private static SpdxLicenses $spdx;

    /**
     * @throws Throwable
     * @throws DOMException
     * @throws ValidationException
     * @throws ErrorException
     */
    public function convertTo(string $format): void
    {
        if(!in_array($format, CodemetaConversion::SUPPORTED_FORMATS)){
            return;
        }
        $this->convertAndValidate($format);
    }

    /**
     * @throws DOMException
     * @throws ValidationException|Throwable
     * @throws ErrorException
     */
    public function generateSwhXML(string $format = null) : void
    {
        $this->convertAndValidate($format ?? 'swhXML');
    }

    /**
     * @throws Throwable
     * @throws DOMException
     * @throws ValidationException
     * @throws ErrorException
     */
    private function convertAndValidate(string $format): void
    {
        $this->generateCodeMeta(filteredRules: true);

        if(session()->has('stepEmpty')) throw ValidationException::withMessages([]);

        $schemeClass = match ($format){
            BibTex::SCHEME   => BibTex::class,
            BibLatex::SCHEME => BibLatex::class,
            DataCite::SCHEME => DataCite::class,
            SWHDeposit::SCHEME => SWHDeposit::class
        };

        $formatConverted = $this->validate4Schemes($schemeClass);

        if($formatConverted === Null) return;

        $this->{$format} = match (gettype($formatConverted)){
            'array'  => json_encode($formatConverted, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'string' => $formatConverted
        };

        $this->approveAllSteps();

        $this->emit('equateHeights', $this->getActiveMeta());

        $this->emit('bounceTextArea', $format);
    }

    public function depositMetaData2Swh()
    {
        //todo
    }

    /**
     * @throws ValidationException
     */
    private function findCodeMetaData(): ?array
    {
        $codeMetaData = $this->codeMetaJSON ?? $this->codeMetaImport;

        if(isset($this->codeMetaImport) && $this->codeMetaJSON === null){
            $codeMetaData = $this->parseJSON($this->codeMetaImport);
        }

        return is_array($codeMetaData)
            ? $codeMetaData
            : json_decode($codeMetaData, true);
    }


    /**
     * @throws DOMException
     * @throws ValidationException|Throwable
     * @throws ErrorException
     */
    private function validate4Schemes(string $schemeClass): array|string|Null
    {
        try{
            return $schemeClass === SWHDeposit::class
                ? SWHDeposit::on($this->findCodeMetaData(), $this->formData['codeRepository'] ?? "https://github.com/RamyTestAccount/D2")
                : CodemetaConversion::To($schemeClass, $this->findCodeMetaData());

        }catch (ValidationException $e){

            $this->denyCurrentStep();

            $translatedErrors = self::translateValidations($e->errors())->toArray();
            session()->put('schemeValidationErrors', $translatedErrors);

            if(!self::hasStepError($e->validator->errors()->keys(), $schemeClass::SCHEME)){
                $this->allowAllSteps();
                $this->approveCurrentStep();
                session()->flash('incompleteConversion', "Please navigate to other steps.");
                return Null;
            }
            $this->viewFlags['panel'.$this->viewPanel.'Failed'] = true;   // todo: deny respectively

            session()->flash('schemeErrors', "For <b>".$schemeClass::SCHEME."</b>. Please correct them before proceeding.");

            $this->dispatchBrowserEvent('triggerCSS', ['ScrollOnly'=> true]);

            throw ValidationException::withMessages(array_merge($translatedErrors, [ $this->getActiveMeta() => ' ' ]));
        }
    }

    private static function translateValidations(array $previousErrors): Collection
    {
        return Collect($previousErrors)
            ->keys()
            ->map(function ($key){
                return match(Str::of($key)->match('/^[^.]+/')->value()){
                    'publisher' => preg_replace_callback_array(['/publisher/' => fn()=> 'formData', '/name/' => fn() => 'publisher'], $key),
                    'funder',
                        'contributor'
                            => 'formData.' . preg_replace_callback('/^[^.]*\.[^.]*$/' , fn($m) => preg_replace('/\./', '.0.', $m[0]), $key),
                    default     => 'formData.' . $key
                };
            })
            ->combine($previousErrors);
    }

    private function hasStepError(array $errorKeys, string $format): bool
    {
        foreach ($errorKeys as $key){
            if(in_array(preg_replace('/\d/', '*' , $key), Constants::CONVERSIONS_MAPPING[$format]['step'.$this->viewPanel])){
                return true;
            }
        }
        return false;
    }

}
