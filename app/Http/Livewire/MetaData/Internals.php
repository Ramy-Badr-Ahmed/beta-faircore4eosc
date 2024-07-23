<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/beta-faircore4eosc
 */

namespace App\Http\Livewire\MetaData;

use App\Modules\SwhApi\HTTPConnector\SyncHTTP;
use App\Modules\SwhApi\OriginVisits\SwhOrigins;
use App\Modules\SwhApi\OriginVisits\SwhVisits;
use DOMException;
use ErrorException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Throwable;

trait Internals
{

    /**
     * @throws DOMException
     * @throws ValidationException|Throwable
     * @throws ErrorException
     */
    private function proceedValidations(string $tab): void
    {
        $validationMode = Str::of($tab)->match('/.*(?=Active)/')->value();

        $validationMode === 'json'
            ? $this->validate4JsonTab(proceedFlash:  true)
            : $this->validate4Tabs($validationMode);
    }

    /**
     * @throws DOMException
     * @throws ValidationException|Throwable
     * @throws ErrorException
     */
    private function validate4Tabs(string $validationMode): void
    {
        $instanceMethod = match ($validationMode){
            'swhXML'   => 'generateSwhXML',
            default => 'convertTo',
        };
        [$this, $instanceMethod]($validationMode);
    }

    private function approveCurrentStep() : void
    {
        $this->viewFlags['panel'.$this->viewPanel.'Success'] = true;

        $this->resetCurrentStep();

        if(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, limit:3)[2]["function"]!=='generateCodeMeta'){
            $this->allowNextStep();
        }
    }

    private function allowNextStep() : void
    {
        $this->viewFlags['panel'.($this->viewPanel+1).'Allowed'] = true;
    }

    private function allowAllSteps(): void
    {
        foreach (range(1, 3) as $view){
            unset($this->viewFlags['panel'.$view.'Failed'], $this->viewFlags['panel'.$view.'Success']);
        }
    }

    private function resetTrailingStep() : void
    {
        $this->resetValidation();
        session()->remove('validationErrors');

        $this->viewFlags['jsonPanel'] = true;

        foreach (range($this->viewPanel, 3, 1) as $view){
            unset($this->viewFlags['panel'.$view.'Failed'], $this->viewFlags['panel'.$view.'Success']);
        }

        $this->dispatchBrowserEvent('triggerCSS');
    }

    private function resetCurrentStep() : void
    {
        if($this->getErrorBag()->toArray()) {
            $this->resetValidation();
        }
        session()->remove('validationErrors');

        $this->viewFlags['jsonPanel'] = true;
        unset($this->viewFlags['panel'.($this->viewPanel).'Failed']);
    }

    private function approveAllSteps(): void
    {
        foreach (range($this->viewPanel, 3, 1) as $view){
            $this->viewFlags['panel'.$view.'Success']
                = $this->viewFlags['panel'.$view.'Allowed'] = true;
        }
        $this->resetAllSteps();
    }

    private function resetAllSteps() : void
    {
        if($this->getErrorBag()->toArray()) {
            $this->resetValidation();
        }
        session()->remove('schemeValidationErrors');

        $this->viewFlags['jsonPanel'] = true;
        foreach (range($this->viewPanel, 3, 1) as $step){
            unset(/*$this->viewFlags['panel'.$step.'Success'],*/ $this->viewFlags['panel'.$step.'Failed']);
        }
    }

    private function resetRightPanel(): void
    {
        if($this->getErrorBag()->toArray()) {
            $this->resetValidation($this->getActiveMeta());
        }
        $this->viewFlags['jsonPanel'] = true;
    }

    private function denyCurrentStep(): void
    {
        $this->viewFlags['jsonPanel'] = false;
        $this->viewFlags['panel'.$this->viewPanel.'Failed'] = true;
    }

    private function getActiveTab() : array
    {
        return Arr::where($this->viewFlags, function ($bool, $flag){
            if(Str::of($flag)->match('/active/i')->value() === 'Active'){
                return $bool === true;
            }
            return false;
        });
    }

    private function getActiveMeta(): string
    {
        $activeTab = $this->getActiveTab();

        $instanceMeta = current(array_intersect_key(Constants::TABS_MAPPING, $activeTab));

        if(key($activeTab) === 'jsonActive'){
            $instanceMeta = $this->viewFlags['jsonReadOnly']
                ? $instanceMeta[0]
                : $instanceMeta[1];
        }
        return $instanceMeta;
    }

    private function emitBounceOnce() : void
    {
        $this->activatePill('jsonActive');

        $instanceMeta = $this->getActiveMeta();

        if(!isset($this->{$instanceMeta})){
            $this->emit('bounceTextArea', $instanceMeta);
        }

    }

    private function eraseDataOnViewFlags(array $flaggedArray) : void
    {
        Arr::map(Arr::only($this->formData, $flaggedArray), function($val, $key){
            if(isset($val)){
                unset($this->formData[$key]);
            }
        });
        for($i=0; $i < count($flaggedArray); $i++){
            $this->resetValidation("formData".".$flaggedArray[$i]");
        }
    }

    private static function checkIfFrontEnd(): void
    {
        $backTrace = Arr::pluck(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), 'function');
        if(in_array('callMethod', $backTrace)){
            self::delayABit();
        }
    }

    private static function delayABit(): void
    {
        if(!session()->has('visited')){
            session()->put("visited", [uuid_create(), now()]);
        }else{
            usleep(1000000);
        }
    }

    private static function checkClearedFields(array &$formData) : void
    {
        foreach ($formData as $key => $data){
            if(is_array($data)){
                self::checkClearedFields($data);
                $formData[$key] = $data;
                if(empty($data)) return;
            }
            if(empty($data)){
                unset($formData[$key]);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    private function validate4JsonTab(bool $dynamicRules = false, bool $filteredRules = false, bool $proceedFlash = false): void
    {
        try{
            if($dynamicRules){
                $this->getJSONValidation = true;
                $this->validate($this->computeDynamicRules());
            }
            elseif ($filteredRules){
                $this->validate($this->rules['filtered']['step'.$this->viewPanel], $this->messages['filtered']);
            }
            else{
                $this->validate($this->rules['step'.$this->viewPanel]);
            }

            $this->approveCurrentStep();

        }catch (ValidationException  $e){
            $this->denyCurrentStep();

            if($this->viewFlags['tripMode'] === 'defer' || $proceedFlash){
                session()->flash('stepErrors', "Step <b>$this->viewPanel</b> yielded errors. Please correct them before proceeding.");
                $this->dispatchBrowserEvent('triggerCSS', ['ScrollOnly'=> true]);
            }

            $e->validator->errors()
                ->merge(new MessageBag(['fetchError'=> ' ', 'codeMetaJSON' => ' ']));

            $this->setErrorBag(new MessageBag($e->validator->getMessageBag()->toArray()));

            session()->put('validationErrors', $e->errors());
            throw $e;
        }
    }

    private function computeDynamicRules(): array
    {
        $formKeys = Arr::map(array_keys($this->formData), function($val){
            return is_array($this->formData[$val])
                ?  'formData.'.$val.'.*.'
                :'formData.'.$val;
        });
        return Arr::where($this->rules['step'.$this->viewPanel], function($rule, $key) use($formKeys){
            return in_array($key, $formKeys) || Str::contains($key, ".*.") || is_string($rule) && Str::contains($rule, "required_with");
        });
    }

    private function generateData(array &$data): void
    {
        self::avoidKeysRepetition($data, $this->codeMetaJSON, $previousCodeMetaJSON);

        self::explodeCodeMetaValues($data);

        self::generateCodeMetaObjects($data);

        self::onAllClearedCodeMeta($data);

        unset($data['licenseInput']);

        $data = array_merge(Constants::CONTEXT, Constants::TYPE['SoftwareSourceCode'], $previousCodeMetaJSON ?? [], $data);
    }

    private static function avoidKeysRepetition(array &$data, ?string $codeMetaJSON, ?array &$previousCodeMetaJSON): void
    {
        if(!isset($codeMetaJSON)) return;

        $previousCodeMetaJSON = Arr::except(json_decode($codeMetaJSON, true, flags: JSON_OBJECT_AS_ARRAY), ['@context', '@type']);

        $intersection = array_uintersect_assoc($data, $previousCodeMetaJSON, fn() => 0);

        if($intersection !== $previousCodeMetaJSON){
            $previousCodeMetaJSON = Arr::only($previousCodeMetaJSON, array_keys($intersection));
        }

        $data = array_udiff_assoc($data, $previousCodeMetaJSON, fn($arrayVal1, $arrayVal2) => $arrayVal1 === $arrayVal2 ? 0 : 1);

        $previousCodeMetaJSON = array_udiff_assoc($previousCodeMetaJSON, $data, fn() => 0);
    }

    private  function explodeCodeMetaValues(array &$data): void
    {
        $keys = array_keys(Arr::only($data, Constants::CODEMETA_ARRAYS));

        if(empty($keys)) return;

        array_walk($keys, function($key) use(&$data){
            if(in_array($key, Constants::TEXTAREA_ARRAYS_CODEMETA_KEYS)){
                $data[$key] = str_replace("\n", "," , $data[$key]);
            }

            $data[$key] = Collect(explode(',', $data[$key]))
                ->map(fn($val) => trim($val))
                ->reject(fn($val) => empty($val))
                ->values();

            if(count($data[$key])===1) $data[$key] = $data[$key][0];
        });
    }

    private static function generateCodeMetaObjects(array &$data): void
    {
        if(!Arr::hasAny($data, Constants::CODEMETA_OBJECTS)){
            return;
        }
        if(isset($data['publisher'])){

            $publisher = Str::of($data['publisher'])->trim()->value();
            $url = Str::of($data['url'] ?? null)->trim()->value();

            $data['publisher'] = self::appendCodeMetaKeys(
                Arr::whereNotNull([
                    'name' => $publisher ?: null,
                    'url' => $url ?: null ] )
            );
            unset($data['url']);
        }

        if(isset($data['author'])){
            $data['author'] = self::appendCodeMetaKeys($data['author']);
        }

        $optionalArrays = Arr::only($data, ['funder', 'contributor', 'maintainer']);

        if(empty($optionalArrays)) return;

        Arr::map($optionalArrays, function ($codeMetaValue, $codeMetaKey) use (&$data) {

            $data[$codeMetaKey] = self::appendCodeMetaKeys(
                array_values(Arr::whereNotNull(Arr::map($codeMetaValue, function ($singleArray) use($codeMetaKey){
                    if(empty($singleArray)){
                        return null;
                    }
                    return $codeMetaKey === 'funder'

                        ? collect($singleArray)
                            ->map(function ($val){return trim($val);})
                            ->merge(Arr::whereNotNull(['name' => $singleArray['funder'] ?? null ]))
                            ->reject(function ($val, $key){return $key === 'funder';})
                            ->all()

                        : collect($singleArray)
                            ->map(function ($val){return trim($val);})
                            ->all();
                })))
            );
            if(count($data[$codeMetaKey])===1){
                $data[$codeMetaKey] = $data[$codeMetaKey][0];
            }

        });
    }

    private static function appendCodeMetaKeys(array $formArray) : array
    {
        return Arr::isList($formArray)
            ? Arr::map($formArray, function ($arr){
                if(isset($arr['name'])){
                    return array_merge(Constants::TYPE['organization'], $arr);
                }
                if(isset($arr['affiliation'])){
                    $arr['affiliation'] = array_merge(Constants::TYPE['organization'], ['name' => trim($arr['affiliation'])]);
                }
                return array_merge(Constants::TYPE['person'], collect($arr)->map(function ($val){return is_array($val) ? $val : trim($val);})->reverse()->all() );
            })
            : array_merge(Constants::TYPE['organization'], $formArray);
    }

    private static function onAllClearedCodeMeta(array &$data): void
    {
        $compositeCodeMeta = Arr::only($data, ['funder', 'contributor', 'maintainer']);

        if(empty($compositeCodeMeta)) return;

        Arr::map($compositeCodeMeta, function ($codeMetaValue, $codeMetaKey) use (&$data) {
            if(empty($codeMetaValue)) {
                unset($data[$codeMetaKey]);
            }
        });
    }

    private static function getLicenseByURL($url) : string
    {
        $license = Arr::flatten(Arr::where(self::$spdx->getLicenses(), function($licenseArray) use($url) {
            return Str::of($url)->match('/(\/'.$licenseArray[0].'(.html)?)/i')->value();
        }));
        return empty($license) ? 'NULL' : $license[0].": ".$license[1];
    }

    private static function filterLicensesList(?string $licenseInput): array
    {
        return Arr::map(Arr::where(self::$spdx->getLicenses(), function($val) use($licenseInput){
            return Str::contains($val[0].": ".$val[1], $licenseInput ?? '', true);
        }),
            fn ($val) => $val[1]);
    }

    private function isKnown2SWH(?string $data = null): bool
    {
        $swhOrigin = new SwhOrigins($data ?? $this->formData['codeRepository']);

        return is_bool($swhOrigin->originExists());
    }

    private function getLatestVisitInfo(?string $data = null): array
    {
        $swhVisit = new SwhVisits($data ?? $this->formData['codeRepository']);

        $visitInfo = $swhVisit->getVisit('latest', requireSnapshot: true);

        /** @var array|throwable $visitInfo */

        return $visitInfo instanceof Throwable
            ? collect($swhVisit->getVisit('latest'))->only(Constants::SWH_VISIT_INFO_KEYS)->map(fn($val) => $val ?? 'NULL')->toArray()
            : Arr::only($visitInfo, Constants::SWH_VISIT_INFO_KEYS);
    }

    private function connectIdentifier2SWH(?string $identifier = null): array
    {
        preg_match('/(?<=https:\/\/archive\.softwareheritage\.org\/).*$/', $identifier ?? $this->formData['identifier'], $match);

        $swh = new SyncHTTP();

        try{
            if(Str::contains($match[0], 'swh:1:')){
                return [
                    $identifier ?? $this->formData['identifier'],
                    $swh->invokeHTTP('HEAD', Constants::SWH_HOST_RESOLVE.$match[0], timeout: 10, connectTimeout: 5, sleepMS: 1000)->status()
                ];
            }

            $callNonSwhResolver = $swh->invokeHTTP('GET', $identifier ?? $this->formData['identifier'], timeout: 10, connectTimeout: 5, sleepMS: 1000);

            return [
                Constants::SWH_FULL_HOST.Str::of($callNonSwhResolver->body())->match('/data-swhid-with-context="(.*?)"/')->value(),
                $callNonSwhResolver->status()
            ];

        }catch (ClientException $e){
            return [$identifier ?? $this->formData['identifier'], $e->getCode()];
        }
    }

    /**
     * @throws ErrorException
     */
    private function scatter2FormData(array $codeMetaImport) : void
    {
        try{
            Arr::map($codeMetaImport, function ($codeMetaValue, $codeMetaKey){
                if($codeMetaKey === 'license'){
                    $this->formData['licenseInput'] = self::getLicenseByURL($codeMetaValue);

                    $this->licenses = self::filterLicensesList($this->formData['licenseInput'] ?? null);

                    $spdxLicense = self::$spdx->getLicenseByIdentifier(substr($this->formData['licenseInput'], 0, strpos($this->formData['licenseInput'], ':')));

                    $this->formData['license'] = count($this->licenses) === 1
                        ? substr($spdxLicense[2], 0, strpos($spdxLicense[2], "#" ))
                        : null;
                    return;
                }
                if(Arr::has(array_flip(Constants::CODEMETA_OBJECTS), $codeMetaKey)){
                    switch ($codeMetaKey){
                        case 'author':
                        case 'contributor':
                        case 'maintainer':
                        case 'funder':

                            if(is_string($codeMetaValue) || $codeMetaKey === 'author' && Arr::isAssoc($codeMetaValue)){
                                return;  // fails silently
                            }
                            $newCodeMetaValue = Arr::map(Arr::isAssoc($codeMetaValue) ? [$codeMetaValue] : $codeMetaValue, function ($singleArray) use($codeMetaKey){
                                return $codeMetaKey === 'funder'

                                    ? collect($singleArray)
                                        ->map(function ($val){return trim($val);})
                                        ->merge(Arr::whereNotNull(['funder' => $singleArray['name'] ?? null ]))
                                        ->reject(function ($val, $key){return $key === 'name'|| $key === '@type';})
                                        ->all()

                                    : collect($singleArray)
                                        ->map(function ($val, $key){
                                            if($key ==='affiliation' ){
                                                return trim($val['name']);
                                            }
                                            return trim($val);
                                        })
                                        ->reject(function ($val, $key){return $key === '@type';})
                                        ->all();
                            });
                            foreach ($newCodeMetaValue as $index => $singleArray) {
                                $this->formData[$codeMetaKey][$index] = $singleArray;
                            }
                            $this->{$codeMetaKey."Number"} = count($newCodeMetaValue);

                            if($codeMetaKey === 'funder' && count($newCodeMetaValue)>1){
                                $this->viewFlags['swFunders'] = true;
                            }
                            break;

                        case 'publisher':
                            unset($codeMetaValue["@type"]);
                            $this->formData[$codeMetaKey] = $codeMetaValue['name'];

                            $this->formData['url'] = $codeMetaValue['url'] ?? null;
                            $this->viewFlags['swPublished'] = true;

                            break;
                    }
                    return;
                }
                if($codeMetaKey === Constants::RELEASE_CODEMETA_KEY){
                    $this->viewFlags['swRelease'] = true;
                }
                if(in_array($codeMetaKey, Constants::SWH_REPOSITORY_CODEMETA_KEY)){
                    $this->isKnown = $this->isKnown2SWH($codeMetaValue);
                    if($this->isKnown){
                        $this->visitData = $this->getLatestVisitInfo($codeMetaValue);
                    }
                }
                if(in_array($codeMetaKey, Constants::SWH_IDENTIFIER_CODEMETA_KEY)){
                    if(Str::contains( $codeMetaValue, Constants::SWH_HOST)){
                        $this->idType = 'SWHID';
                        [$this->formData['identifier'], $this->idStatusCode ] = $this->connectIdentifier2SWH($codeMetaValue);
                        return;
                    }
                    else $this->idType = 'DOI';
                }
                if(in_array($codeMetaKey, Constants::BUNDLE_CODEMETA_KEYS)){
                    $this->viewFlags['swBundle'] = true;
                }
                if(in_array($codeMetaKey, Constants::FILESYSTEM_CODEMETA_KEYS)){
                    $this->viewFlags['swFileSystem'] = true;
                }
                if(in_array($codeMetaKey, Constants::REPOSITORY_CODEMETA_KEYS)){
                    $this->viewFlags['swRepository'] = true;
                }
                if(in_array($codeMetaKey, Constants::CODE_CODEMETA_KEYS)){
                    $this->viewFlags['swCode'] = true;
                }
                if(in_array($codeMetaKey, Constants::PERFORMANCE_CODEMETA_KEYS)){
                    $this->viewFlags['swRequirements'] = true;
                }
                $this->formData[$codeMetaKey] = is_array($codeMetaValue)
                    ? implode(", ", $codeMetaValue)
                    : $codeMetaValue;
            });

        }catch (Throwable $e){
            throw new ErrorException();
        }
    }

    /**
     * @throws ValidationException
     */
    private function checkCodeMetaKeys(array $codeMetaImport): void
    {
        $codeMetaKeys = array_keys(Arr::except(array_flip(array_keys($this->vocabularyRead['@context'])),
            ['type', 'id', 'schema', 'codemeta'])
        );

        unset($codeMetaImport['@context'], $codeMetaImport['@type'], $codeMetaImport['schema'], $codeMetaImport['codemeta']);

        $codeMetaImportKeys = array_keys($codeMetaImport);

        if(isset($codeMetaImport['author']) && is_array($codeMetaImport['author'])){
            $codeMetaImportKeys = array_merge($codeMetaImportKeys, array_unique(Arr::collapse(Arr::map($codeMetaImport['author'], function($authorArray){
                if(is_array($authorArray)){
                    unset($authorArray['@type']);
                    return array_keys($authorArray);
                }
                else return [];
            }))));
        }
        if(isset($codeMetaImport['contributor']) && is_array($codeMetaImport['contributor'])){
            $codeMetaImportKeys = array_merge($codeMetaImportKeys, array_unique(Arr::collapse(Arr::map($codeMetaImport['contributor'], function($contributorArray){
                if(is_array($contributorArray)){
                    unset($contributorArray['@type']);
                    return array_keys($contributorArray);
                }
                else return [];
            }))));
        }
        if(isset($codeMetaImport['maintainer']) && is_array($codeMetaImport['maintainer'])){
            $codeMetaImportKeys = array_merge($codeMetaImportKeys, array_unique(Arr::collapse(Arr::map($codeMetaImport['maintainer'], function($maintainerArray){
                if(is_array($maintainerArray)){
                    unset($maintainerArray['@type']);
                    return array_keys($maintainerArray);
                }
                else return [];
            }))));
        }
        if(!Arr::has(array_flip($codeMetaKeys), $codeMetaImportKeys)){
            $badKeys =  array_diff($codeMetaImportKeys, $codeMetaKeys);
            throw ValidationException::withMessages(['codeMetaImport' => "\nCodeMeta.json contains non-compliant CodeMeta Key(s): \n".implode("\n", $badKeys)]);
        }
    }

    /**
     * @throws ValidationException
     */
    private function parseJSON(?string $codeMetaImport): array
    {
        try{
            $this->resetValidation(['codeMetaImport', 'scatterError']);

            if($this->codeMetaImportLines === true){
                $erroredImport = Arr::map(explode("\n", $codeMetaImport), function ($val){
                    return substr($val, strpos($val, ":")+1);
                });
                $codeMetaImport = implode("\n", $erroredImport);
            }

            $parser = new JsonParser();
            $codeMetaImport =  $parser->parse($codeMetaImport, JsonParser::PARSE_TO_ASSOC);

            $this->codeMetaImport = json_encode($codeMetaImport, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $this->viewFlags['jsonPanel'] = true;
            $this->codeMetaImportLines = false;

            return $codeMetaImport;

        }catch (ParsingException $e){
            $this->activatePill('jsonActive');
            $this->viewFlags['jsonPanel'] = false;
            self::approximateJsonError($e, $codeMetaImport);
        }

    }

    /**
     * @throws ValidationException
     */
    private function approximateJsonError(ParsingException $e, ?string $codeMetaImport) : void
    {
        $details = $e->getDetails();

        $errorLine = count($details['expected']) === 1
            ? $details["loc"]["last_line"] +1
            : $details["loc"]["last_line"];

        $correctedLine = $errorLine === $details['line']
            ? $details['line'] - 1
            : $details['line'];

        $falseCodeMeta = explode("\n", $codeMetaImport);
        $currentLine = $falseCodeMeta[$correctedLine];
        $currentLinePos = strpos($codeMetaImport, $currentLine);

        if(isset($falseCodeMeta[$correctedLine+1])){
            $nextLine= $falseCodeMeta[$correctedLine + 1];
            $nextLinePos = strpos($codeMetaImport, $nextLine);
        }
        else{
            $nextLinePos = $currentLinePos + 1;
        }

        if($this->codeMetaImportLines === false){
            $this->codeMetaImportLines = true;
            $i=0;
            $this->codeMetaImport  = implode("\n", Arr::map(explode("\n", $codeMetaImport), function($val) use(&$i){
                $i++;
                return $i.": ".$val;
            }));
        }

        throw ValidationException::withMessages(['codeMetaImport' => "\nInvalid JSON format imported to CodeMeta.json\nExpected: "
            . implode(" or  ", $details['expected'] ) ."\n @ Line: " .    $errorLine]);
    }
}
