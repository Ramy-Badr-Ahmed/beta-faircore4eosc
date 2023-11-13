<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: LZI -- SWH Deposit
 * @Repo: https://github.com/dagstuhl-publishing/beta-faircore4eosc
 */

namespace App\Modules\MetaData;

use DOMException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\ArrayToXml\ArrayToXml;
use Throwable;

class SWHDeposit
{
    public const ON_URL = "url";
    public const ON_SWHID = "swhid";
    public const SUPPORTED_FORMATS = [self::ON_URL, self::ON_SWHID];
    private const XML_ENTRY_META = [
        "xmlns"          => "http://www.w3.org/2005/Atom",
        "xmlns:swh"      => "https://www.softwareheritage.org/schema/2018/deposit",
        "xmlns:schema"   => "http://schema.org/",
        "xmlns:codemeta" => "https://doi.org/10.5063/SCHEMA/CODEMETA-2.0"
    ];

    private const SWH_BASED_XML = [
        '_attributes' => self::XML_ENTRY_META,
        "id" => "LZI-",
    ];
    private const DEPOSIT_ON = [
        "swh:deposit.swh:reference.swh:origin._attributes.?" => "",
    ];
    private const SWH_XML_AUTHOR = [
        "name" => "LZI-Dagstuhl",
        "email" => "dagpub-swh@dagstuhl.de"
    ];

    private const PROVIDER = [
        "swh:deposit.swh:metadata-provenance.schema:url" => "https://submission.dagstuhl.de/",
        "author" => self::SWH_XML_AUTHOR
    ];
    private Collection $codeMetaPrefix;
    private Collection $swhBasedXML;
    protected static string $depositType;

    /**
     * @throws ValidationException|Throwable
     */
    public function __construct(public array $codeMetaData, public string $depositOn)
    {
        $this->ensureValidProperties();

        $this->codeMetaPrefix = self::generatePrefixes($this->codeMetaData);

        $this->swhBasedXML = self::generateSwhBasedXML($this->depositOn);
    }

    /**
     * @throws ValidationException|Throwable
     */
    private function ensureValidProperties(): void
    {
        $isValidType = validator(['depositType' => $this->depositOn], ['depositType' => 'url']);     // todo add contextual SWHID (currently, irrelevant to codeMeta form v2)

        throw_if($isValidType->fails(), new ValidationException($isValidType));

        self::$depositType = Str::contains(Str::Lower($isValidType->errors()->first()), self::ON_SWHID)
            ? self::ON_SWHID
            : self::ON_URL;

        if(self::$depositType === self::ON_URL) $this->validate();
    }

    /**
     * @throws ValidationException|Throwable
     */
    public function validate(): void
    {
        $validator = Validator::make($this->codeMetaData, ['codeRepository' => 'required|url'],
            ['codeRepository.required'=>'swhXML: :attribute is required.', 'codeRepository.url' => 'codeMeta: :attribute is invalid.'], ['codeRepository'=>'codeRepository']);

        throw_if($validator->fails(), new ValidationException($validator));
    }

    /**
     * @return string
     * @throws DOMException
     */
    public function getSwhXML(): string
    {
        $xmlInstance = new ArrayToXml($this->combineData()->all(), 'entry', xmlEncoding:'UTF-8');

        return $xmlInstance->prettify()->toXml();
    }

    /**
     * @throws DOMException
     * @throws ValidationException|Throwable
     */
    public static function on(array $codeMetaData, string $depositOn): string
    {
        $SWHDeposit = new self($codeMetaData, $depositOn);

        return $SWHDeposit->getSwhXML();
    }

    private function combineData(): Collection
    {
        return $this->swhBasedXML->merge($this->codeMetaPrefix);
    }

    private static function generatePrefixes(array $codeMetaData): Collection
    {
        return Collect($codeMetaData)
            ->keys()

            ->map(function ($key) use(&$codeMetaData){
                if(is_array($codeMetaData[$key])){
                    $codeMetaData[$key] = self::generatePrefixes($codeMetaData[$key])->all();
                }
                return is_int($key)
                    ? $key
                    : "codeMeta:".$key;
            })
            ->combine($codeMetaData)

            ->reject(function ($value, $key){
                return Str::contains($key, ["@context", "@type", "@id"]);
            });
    }

    private static function whichDeposit() : array
    {
        $replacedKey = preg_replace('/\?/', self::$depositType, key(self::DEPOSIT_ON));

        return array_merge(self::SWH_BASED_XML, [$replacedKey=>""], self::PROVIDER);
    }

    private static function generateSwhBasedXML(string $depositOn): Collection
    {
        return Collect(self::whichDeposit())

            ->map(function ($val, $key) use($depositOn){
                if(Str::contains($key, 'swh:reference')){
                    $swhDepositKey = $key;
                }
                return match($key){
                    'id' => $val.bin2hex(random_bytes(4)),
                    $swhDepositKey ?? null => $depositOn,
                    default => $val
                };
            })
            ->pipe(function ($prepends){
                return $prepends
                    ->map(function ($val, $key) use($prepends){
                        if(Str::contains($key, 'swh:metadata')){
                            return $val.$prepends['id'];
                        }
                        return $val;
                    });
            })
            ->undot();
    }

}
