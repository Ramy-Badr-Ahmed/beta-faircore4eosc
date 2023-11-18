<?php

namespace App\Http\Livewire\MetaData;

use App\Modules\MetaData\Conversion;
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
    private static Conversion $conversion;

    /**
     * @throws Throwable
     * @throws DOMException
     * @throws ValidationException
     * @throws ErrorException
     */
    public function convertTo(string $format): void
    {
        if(!in_array($format, Conversion::SUPPORTED_FORMATS)){
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

        if($format !== 'swhXML'){
            [self::$conversion->codeMetaData , self::$conversion->format] = [$this->findCodeMetaData(), $format];
        }

        $formatConverted = $this->validate4Schemes($format);

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
    private function validate4Schemes(string $format): array|string|Null
    {
        try{
            return $format === 'swhXML'
                ? SWHDeposit::on($this->findCodeMetaData(), $this->formData['codeRepository'] ?? "https://github.com/RamyTestAccount/D2")
                : self::$conversion->getTargetConversion();

        }catch (ValidationException $e){

            $this->denyCurrentStep();

            $translatedErrors = self::translateValidations($e->errors())->toArray();
            session()->put('schemeValidationErrors', $translatedErrors);

            if(!self::hasStepError($e->validator->errors()->keys(), $format)){
                $this->approveCurrentStep();
                return Null;
            }
            $this->viewFlags['panel'.$this->viewPanel.'Failed'] = true;   // todo: deny respectively

            session()->flash('schemeErrors', "For <b>$format</b>. Please correct them before proceeding.");

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
