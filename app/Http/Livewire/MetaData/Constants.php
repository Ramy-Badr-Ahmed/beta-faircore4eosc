<?php

namespace App\Http\Livewire\MetaData;

abstract class Constants
{
    public const CONTEXT = ["@context" => "https://doi.org/10.5063/schema/codemeta-2.0"];
    public const TYPE = [
        'SoftwareSourceCode' => ["@type" => "SoftwareSourceCode"],
        'person' => ["@type" => "Person"],
        'organization' => ["@type" => "Organization"],
    ];
    public const CODEMETA_OBJECTS = [
        'publisher',
        'funder',
        'author',
        'contributor',
        'maintainer'
    ];
    public const CODEMETA_ARRAYS = [
        'fileSize',
        'fileFormat',
        'encoding',
        'programmingLanguage',
        'runtimePlatform',
        'operatingSystem',
        'softwareRequirements',
        'relatedLink',
        'keywords',
        'applicationCategory'
    ];
    public const TABS_MAPPING = [
        'jsonActive' => ['codeMetaJSON', 'codeMetaImport'],
        'swhXMLActive'   => 'swhXML',
        'bibTexActive'   => 'bibTex',
        'bibLaTexActive' => 'bibLaTex',
        'dataCiteActive' => 'dataCite',
        'githubActive'   => 'github',
        'zenodoActive'   => 'zenodo'
    ];

    public const CONVERSIONS_MAPPING = [
        "bibTex" => [
            "step1" => [ 'name' ],
            "step2" => [ 'identifier' ],
            "step3" => [ 'author.*.givenName',  'author.*.familyName' ]
        ],
        "bibLaTex" => [
            "step1" => [ 'name', 'dateCreated', 'publisher.url' ],
            "step2" => [ 'identifier' ],
            "step3" => [ 'author.*.givenName', 'author.*.familyName' ]
        ],
        "dataCite" => [
            "step1" => [ 'name', 'datePublished', 'publisher.name' ],
            "step2" => [
                'identifier',
                'funder.*.name',
                'funder.name',
                'funder.*.@id',
                'funder.@id'
            ],
            "step3" => [
                'author.*.givenName',
                'author.*.familyName',
                'contributor.*.givenName',
                'contributor.*.familyName',
                'contributor.givenName',
                'contributor.familyName'
            ]
        ],
        "swhXML" => [
            "step1" => [],
            "step2" => [ 'codeRepository' ],
            "step3" => []
        ]
    ];
}
