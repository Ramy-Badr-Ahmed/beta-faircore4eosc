<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: LZI -- MetaData Conversions
 * @Repo: https://github.com/dagstuhl-publishing/beta-faircore4eosc
 */

namespace App\Modules\MetaData;

use App\Http\Livewire\MetaData\Constants;
use App\Modules\SwhApi\SyncHTTP;
use Composer\Spdx\SpdxLicenses;
use ErrorException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use ReflectionException;
use Throwable;

class Conversion
{
    public const DATACITE = "dataCite";
    public const BIBTEX = "bibTex";
    public const BIBLATEX = "bibLaTex";
    public const SUPPORTED_FORMATS = [self::DATACITE, self::BIBLATEX, self::BIBTEX];
    private const TEX_SEPARATOR = ",\n";
    private const BIBTEX_HEADING = "@misc{";
    private const BIBLATEX_HEADING = "@software{";
    private const BIBLATEX_VERSION_HEADING = "@softwareversion{";
    private const LATEX_OPENING = "{";
    private const LATEX_CLOSING = "}";
    private static array $readConversions;
    private static array $rules;
    private static array $messages;
    private static array $attributes;
    private array $targetConversion;


    /**
     * @throws ErrorException|Throwable
     * @throws ReflectionException
     * @throws FileNotFoundException
     * @throws ValidationException
     */
    public function __construct(public ?array $codeMetaData = null, public ?string $format = null)
    {
        self::$readConversions = json_decode(File::get(base_path('resources/CodeMeta/Conversions.json')), true, 10, JSON_OBJECT_AS_ARRAY | JSON_INVALID_UTF8_SUBSTITUTE);
        self::$rules = config('conversionsValidations.rules') ?? [];
        self::$messages = config('conversionsValidations.messages') ?? [];
        self::$attributes = config('conversionsValidations.attributes') ?? [];

        throw_if(empty(self::$rules) || empty(self::$messages) || empty(self::$attributes), new ErrorException('Missing validation parameters'));

        $this->ensureValidProperties();
    }

    /**
     * @throws ReflectionException
     * @throws ValidationException
     */
    private function ensureValidProperties(): void
    {
        if(isset($this->format)){
            if(!in_array($this->format, self::SUPPORTED_FORMATS)){
                throw new ReflectionException("Unsupported conversion format");
            }
        }
        if(isset($this->codeMetaData)) $this->validate();
    }

    /**
     * @throws ErrorException
     * @throws ValidationException
     */
    public function getTargetConversion(): array|string
    {
        if($this->codeMetaData === null || $this->format === null){
            throw new ErrorException('Essential data missing. CodeMeta Data or Target Format.');
        }

        $this->validate(scheme: $this->format);

        $this->targetConversion = self::$readConversions[$this->format];

        $instanceMethod = match ($this->format){
            self::BIBTEX   => 'generateBibTex',
            self::BIBLATEX => 'generateBibLaTex',
            self::DATACITE => 'generateDataCite',
        };

        return [$this, $instanceMethod]();
    }

    /**
     * @throws ReflectionException
     * @throws FileNotFoundException
     * @throws ErrorException|Throwable
     */
    public static function To(array $codeMetaData, string $format): array|string
    {
        $converter = new static($codeMetaData, $format);

        return $converter->getTargetConversion();
    }

    /**
     * @throws ValidationException
     */
    public function validate(&$errors = null, string $scheme = 'codeMeta'): void
    {
        $codeMetaData = $this->initialiseArrayValidation($scheme);

        $validator = Validator::make($codeMetaData, self::$rules[$scheme], self::$messages[$scheme], self::$attributes[$scheme]);

        if($validator->fails()){
            $errors = $validator->errors();
            throw new ValidationException($validator);
        }
    }

    private function initialiseArrayValidation(string $scheme): array
    {
        return array_merge($this->codeMetaData, ['author' => $this->codeMetaData['author'] ?? array([])],
            match($scheme){
                self::BIBLATEX, self::DATACITE => ['publisher' => $this->codeMetaData['publisher'] ?? [] ],
                default => []
        });
    }

    private function mapDirectMeta(...$meta): array
    {
        extract($meta);

        $codeMetaKeys = array_keys($convertedCodeMeta);

        $codeMetaDirectUsed = Arr::map($codeMetaDirect, function ($codeMetaKey) use($codeMetaKeys){
            return Arr::has(array_flip($codeMetaKeys), $codeMetaKey)
                ? $codeMetaKey
                : null;
        });

        return Arr::map(Arr::whereNotNull(array_combine($imageKeys, $codeMetaDirectUsed)),
            function ($codeMetaKey) use($convertedCodeMeta) {
                return $convertedCodeMeta[$codeMetaKey];
            });
    }

    private function getAuthorData4Latex(): array
    {
        return [
            'bibTexAuthors' => implode(' and ', Arr::map($this->codeMetaData['author'], function ($authorArray){
                return $authorArray['familyName'].", ".$authorArray['givenName'];
            })),
            'emails' => implode(' and ', Arr::pluck($this->codeMetaData['author'], 'email')),
            'affiliations' => implode(' and ', Arr::pluck($this->codeMetaData['author'], 'affiliation.name'))
        ];
    }

    private static function formatLatexContents(array $latexArray) : string
    {
        return implode('', array_values(Arr::map($latexArray, function ($item, $key){
            return "\t".$key . str_repeat(' ', 3)."=".str_repeat(' ', 3). self::LATEX_OPENING.$item.self::LATEX_CLOSING.self::TEX_SEPARATOR;
        })));
    }

    private function getLatexContents(array $computedOnCodeMeta, ...$mapMeta) : string
    {
        $latexConverted = self::mapDirectMeta(...$mapMeta);

        $latexArray = array_merge($latexConverted, $computedOnCodeMeta);
        array_pop($latexArray);

        return self::formatLatexContents($latexArray);
    }

    private function generateBibTex(): string
    {
        extract($this->targetConversion);

        [$convertedCodeMeta,
            $compositionOnCodeMeta] = self::convert2BibTex($codeMetaDirect, $codeMetaComposition, $bibTexIndirect);

        $bibtex = self::getLatexContents($compositionOnCodeMeta, imageKeys: $bibTexDirect, codeMetaDirect: $codeMetaDirect, convertedCodeMeta: $convertedCodeMeta);

        return self::BIBTEX_HEADING.$compositionOnCodeMeta["bibtexKey"].self::TEX_SEPARATOR.$bibtex.self::LATEX_CLOSING;

    }

    private function convert2BibTex(...$metaKeys) : array
    {
        list($codeMetaDirect, $codeMetaComposition, $bibTexIndirect) = $metaKeys;

        $codeMetaFilter = Arr::where($this->codeMetaData, function ($codeMetaValue, $codeMetaKey) use($codeMetaDirect, $codeMetaComposition){
            return Arr::has(array_flip(array_merge($codeMetaDirect, $codeMetaComposition)), $codeMetaKey);
        });

        $convertedCodeMeta = Arr::map($codeMetaFilter, callback: function($codeMetaValue, $codeMetaKey){
            return match ($codeMetaKey) {
                'author' => implode(' and ', Arr::map($codeMetaValue, function ($authorArray){
                    return $authorArray['familyName'].", ".$authorArray['givenName'];
                })),
                'name', 'description', 'releaseNotes', 'readme', 'buildInstructions', 'identifier' => $codeMetaValue,
                'downloadUrl'   => "\url{{$codeMetaValue}}",
                'dateCreated', 'datePublished' => date_parse($codeMetaValue),
            };
        });

        return [
            $convertedCodeMeta,
            Arr::whereNotNull(array_combine($bibTexIndirect,
                [
                    "title" => $convertedCodeMeta['name'],

                    "year"  => isset($convertedCodeMeta['datePublished'])
                        ? $convertedCodeMeta['datePublished']["year"]
                        : (isset($convertedCodeMeta['dateCreated']) ? $convertedCodeMeta['dateCreated']["year"] : null),

                    "month" => isset($convertedCodeMeta['datePublished'])
                        ? $convertedCodeMeta['datePublished']["month"]
                        : (isset($convertedCodeMeta['dateCreated']) ? $convertedCodeMeta['dateCreated']["month"] : null),

                    "note" => collect([ $convertedCodeMeta['description'] ?? null, $convertedCodeMeta['releaseNotes'] ?? null,
                                        $convertedCodeMeta['readme'] ?? null, $convertedCodeMeta['buildInstructions'] ?? null ])
                             ->whereNotNull()
                             ->pipe(fn($c) => $c->isEmpty() ? null : $c->implode("\n\t")),

                    "bibtexKey" => Str::slug($convertedCodeMeta['name'], "-").  "__".$convertedCodeMeta['identifier']
                ]
            ))
        ];
    }

    private function generateBibLaTex(): string
    {
        extract($this->targetConversion);

        extract(self::convert2BibLaTex($codeMetaDirect, $codeMetaComposition, $bibLaTexIndirect, $bibLaTexIndirectVersion));

        $bibLaTex = self::getLatexContents($compositionOnCodeMeta, imageKeys: $bibLaTexDirect, codeMetaDirect: $codeMetaDirect, convertedCodeMeta: $convertedCodeMeta);

        $bibLaTex = self::BIBLATEX_HEADING.$compositionOnCodeMeta["bibLaTexKey"].self::TEX_SEPARATOR.$bibLaTex.self::LATEX_CLOSING;

        if(isset($compositionOnCodeMetaVersion)){
            $bibLaTexVersionArray = $compositionOnCodeMetaVersion;

            array_pop($bibLaTexVersionArray);

            $bibLaTexVersion = self::formatLatexContents($bibLaTexVersionArray);

            $bibLaTex .= "\n".self::BIBLATEX_VERSION_HEADING.$compositionOnCodeMetaVersion["bibLaTexSubKey"].self::TEX_SEPARATOR.$bibLaTexVersion.self::LATEX_CLOSING;
        }
        return $bibLaTex;
    }

    private function convert2BibLaTex(...$metaKeys) : array
    {
        list($codeMetaDirect, $codeMetaComposition, $bibLaTexIndirect, $bibLaTexIndirectVersion) = $metaKeys;

        $codeMetaFilter = Arr::where($this->codeMetaData, function ($codeMetaValue, $codeMetaKey) use($codeMetaDirect, $codeMetaComposition){
            return Arr::has(array_flip(array_merge($codeMetaDirect, $codeMetaComposition)), $codeMetaKey);
        });

        $convertedCodeMeta = Arr::map($codeMetaFilter, callback: function($codeMetaValue, $codeMetaKey){
            return match ($codeMetaKey) {
                'author' => [
                    'names' => implode(' and ', Arr::map($codeMetaValue, function ($authorArray){
                        return $authorArray['familyName'].", ".$authorArray['givenName']; })),
                    'affiliations' => Arr::pluck($codeMetaValue, 'affiliation.name')
                ],
                'name', 'description', 'softwareVersion',
                'version', 'releaseNotes', 'isPartOf'  => $codeMetaValue,

                'identifier' => Arr::mapWithKeys([$codeMetaValue], function ($val){
                    $isDoi = self::isDOI($val);
                    return [
                        'idType' => $isDoi ? 'doi' : (self::isSwhResolver($val) ? 'swhid' : Null),
                        'identifier' => $isDoi
                            ? preg_replace('/^\/|\/$/', '', parse_url($val)['path'])
                            : Str::of($val)->match('/(?<=https:\/\/archive\.softwareheritage\.org\/).*$/i')->value()
                    ];
                }),

                'downloadUrl', 'url', 'codeRepository', 'readme', 'buildInstructions', 'license' => "\url{{$codeMetaValue}}",
                'publisher' => Arr::except($codeMetaValue, ["@type"]),
                'dateCreated', 'datePublished', 'dateModified' => array_merge(date_parse($codeMetaValue), ["full" => $codeMetaValue]),
                'funder' => implode(', ', Arr::pluck(Arr::isAssoc($codeMetaValue) ? [$codeMetaValue] : $codeMetaValue, 'name')),
            };
        });

        $compositionOnCodeMeta = Arr::whereNotNull(array_combine($bibLaTexIndirect, [
            "author" => $convertedCodeMeta['author']['names'],

            "year"  => $convertedCodeMeta['dateCreated']["year"],

            "month" => isset($convertedCodeMeta['dateCreated']) ? $convertedCodeMeta['dateCreated']["month"] : null,

            "url" => $convertedCodeMeta['publisher']['url'],

            "publisher" => $convertedCodeMeta['publisher']['name'] ?? null,

            "doi" => $convertedCodeMeta['identifier']['idType'] === 'doi' ? "\url{{$convertedCodeMeta['identifier']['identifier']}}" : Null,

            "swhid" => $convertedCodeMeta['identifier']['idType'] === 'swhid' ? $convertedCodeMeta['identifier']['identifier'] : Null,

            "institution" => call_user_func(function ($affiliations){

                /** @var Collection $affiliations */
                return $affiliations->whereNotNull()->isEmpty()
                    ? null
                    : $affiliations->map(fn($val) => $val ?? 'Unknown')->implode(' and ');

            }, collect($convertedCodeMeta['author']['affiliations'])),

            "note" => call_user_func(function(...$codeMetaEquivalent){
                                            $note = implode("\n\t", Arr::whereNotNull($codeMetaEquivalent));
                                            return Str::of($note)->isNotEmpty() ? $note : null;
                                            },
                    $convertedCodeMeta['readme'] ?? null, $convertedCodeMeta['releaseNotes'] ?? null, $convertedCodeMeta['buildInstructions'] ?? null),

            "date" => isset($convertedCodeMeta['dateCreated']) ? $convertedCodeMeta['dateCreated']["full"] : null,

            "urldate" => isset($convertedCodeMeta['datePublished']) ? $convertedCodeMeta['datePublished']["full"] : null,

            "bibLaTexKey" => Str::slug($this->codeMetaData['name'], "-").  "__".$convertedCodeMeta['identifier']['identifier']
        ]));

        return array_merge([
            "convertedCodeMeta"     =>  $convertedCodeMeta,
            "compositionOnCodeMeta" =>  $compositionOnCodeMeta
        ],
            isset($convertedCodeMeta['version'])
                ? [
                "compositionOnCodeMetaVersion" => Arr::whereNotNull(array_combine($bibLaTexIndirectVersion, [
                    "version" => $convertedCodeMeta['version'],
                    "year"    => $convertedCodeMeta['dateModified']["year"],
                    "month"   => $convertedCodeMeta['dateModified']["month"],
                    "date"    => $convertedCodeMeta['dateModified']["full"],
                    "file"    => $convertedCodeMeta['downloadUrl'] ?? null,
                    "note"    => $convertedCodeMeta['releaseNotes'] ?? null,
                    "introducedin"   => $convertedCodeMeta['isPartOf'] ?? null,
                    "crossref"       => $compositionOnCodeMeta['bibLaTexKey'],
                    "bibLaTexSubKey" => $compositionOnCodeMeta['bibLaTexKey']."_version_".$convertedCodeMeta['version']
                ]))
            ]
                : []
        );
    }

    private function generateDataCite(): array
    {
        extract($this->targetConversion);

        [$convertedCodeMeta,
            $compositionOnCodeMeta] = self::convert2DataCite($codeMetaDirect, $codeMetaComposition, $dataCiteIndirect);

        $dataCiteConverted = self::mapDirectMeta(imageKeys: $dataCiteDirect, codeMetaDirect: $codeMetaDirect, convertedCodeMeta:  $convertedCodeMeta);

        return array_merge([
            "types"=> [
                "resourceTypeGeneral"=> "Software",
                "resourceType" => "Source Code",
                "schemaOrg" => "SoftwareSourceCode",
                "bibtex" => "misc"
            ],
            "schemaVersion" => "http://datacite.org/schema/kernel-4" ], $dataCiteConverted, $compositionOnCodeMeta);
    }

    private function convert2DataCite(...$metaKeys) : array
    {
        list($codeMetaDirect, $codeMetaComposition, $dataCiteIndirect) = $metaKeys;

        $codeMetaFilter = Arr::where($this->codeMetaData, function ($codeMetaValue, $codeMetaKey) use($codeMetaDirect, $codeMetaComposition){
            return Arr::has(array_flip(array_merge($codeMetaDirect, $codeMetaComposition)), $codeMetaKey);
        });

        $convertedCodeMeta = Arr::map($codeMetaFilter, callback: function($codeMetaValue, $codeMetaKey){
            return match ($codeMetaKey) {

                'name' => Array(["title" => $codeMetaValue]),

                'keywords' => collect($codeMetaValue)
                    ->map(function ($keyword) {
                        return ["subject" => $keyword];
                    })
                    ->all(),

                'relatedLink' => collect($codeMetaValue)
                    ->map(function ($link) {
                        return [
                            "relatedIdentifier" => $link,
                            "relatedIdentifierType" => "URL",
                            "relationType" => "IsSupplementTo"
                        ];
                    })
                    ->all(),

                'identifier' => Array(array_merge([
                    'identifier' => $codeMetaValue,
                    'identifierType' => 'URL'
                ],
                    Arr::whereNotNull(['identifierType' =>
                        Str::of(parse_url($codeMetaValue)['host'])->match('/doi/')->isEmpty()
                            ? null
                            : Str::of(parse_url($codeMetaValue)['host'])->match('/doi/')->value()])
                )),

                'author', 'contributor' => Arr::map(Arr::isAssoc($codeMetaValue) ? [$codeMetaValue] : $codeMetaValue , function ($personArray) use ($codeMetaKey) {

                    $names = Arr::where($personArray, function ($value, $key){
                        return in_array($key, ['familyName', 'givenName']);
                    });

                    return array_merge([
                        "nameType" => "Personal",
                        "name" => $personArray["familyName"] . ", " . $personArray["givenName"]
                    ],
                        $names,
                        isset($personArray["@id"])
                            ? [
                                "nameIdentifiers" => Array([
                                    "nameIdentifier" => $personArray["@id"],
                                    "nameIdentifierScheme" => Str::of(parse_url($personArray["@id"])['host'])->match('/ORCID|ISNI|ROR|GRID/i')->value() ])
                            ]
                            : [],
                        $codeMetaKey === 'contributor'
                            ? ["contributorType" => "Researcher"]
                            : [],
                        isset($personArray["affiliation"])
                            ? ["affiliation" => Array(Arr::except($personArray["affiliation"], ["@type"]))]
                            : []
                    );
                }),

                'funder' => Arr::map(Arr::isAssoc($codeMetaValue) ? [$codeMetaValue] : $codeMetaValue, function ($funderArray) {

                    return Arr::whereNotNull(
                        [
                            'funderName' => $funderArray['name'],
                            "funderIdentifier" => $funderArray['@id'],
                            'funderIdentifierType' => 'Crossref Funder ID',
                            'awardNumber' => $funderArray['funding'] ?? null
                        ]);
                }),

                'license' => Array([
                    "rightsUri" => $codeMetaValue,
                    'rightsIdentifier' => self::getLicenseByURL($codeMetaValue),
                    "rightsIdentifierScheme" => "SPDX"
                ]),

                'description', 'readme', 'releaseNotes' => Array(["description" => $codeMetaValue, "descriptionType" => "TechnicalInfo"]),

                'dateCreated', 'datePublished', 'dateModified' => Array(array_merge(["date" => $codeMetaValue], match ($codeMetaKey) {
                    "dateCreated"   => ["dateType" => "Created"],
                    "datePublished" => ["dateType" => "Issued"],
                    "dateModified"  => ["dateType" => "Updated"]
                })),

                'softwareVersion' => $codeMetaValue.(isset($this->codeMetaData['version'])? "/".$this->codeMetaData['version']:""),     // todo: move to compositeKeys
                'publisher' => $codeMetaValue['name'],
                'fileSize', 'fileFormat' =>  collect($codeMetaValue)->all(),
            };
        });


        return [
            $convertedCodeMeta,
            Arr::whereNotNull(array_combine($dataCiteIndirect,
                [
                    "publicationYear" => (string)date_parse($convertedCodeMeta['datePublished'][0]["date"])["year"],

                    "dates"  => collect([$convertedCodeMeta['dateCreated'] ?? null, $convertedCodeMeta['datePublished'] ?? null, $convertedCodeMeta['dateModified'] ?? null ])
                                ->whereNotNull()
                                ->reduce(function ($carry, $arr){
                                    return array_merge($carry ?? [], $arr);
                                }),

                    "descriptions" => collect([$convertedCodeMeta['description'] ?? null, $convertedCodeMeta['readme'] ?? null, $convertedCodeMeta['releaseNotes'] ?? null ])
                                      ->whereNotNull()
                                      ->reduce(function ($carry, $arr){
                                          return array_merge($carry ?? [], $arr);
                                      }),
                ]
            ))
        ];
    }

    private static function getLicenseByURL($url) : string
    {
        $license = Arr::flatten(Arr::where((new SpdxLicenses())->getLicenses(), function($licenseArray) use($url) {
            return Str::of($url)->match('/\/'.$licenseArray[0].'.html/i')->value();
        }));
        return empty($license) ? 'NULL' : $license[0].": ".$license[1];
    }

    private function isDOI(string $url): bool
    {
        return preg_match('/https?:\/\/(dx\.)?doi\.org\/[a-zA-Z0-9.\/-]+/i', $url);
    }

    private function isSwhResolver(string $url): bool
    {
        $isMatching = preg_match('/(?<=https:\/\/archive\.softwareheritage\.org\/).*$/', $url, $m);
        if($isMatching){
            return Str::contains($m[0], 'swh:1:');
        }
        return false;
    }

}
