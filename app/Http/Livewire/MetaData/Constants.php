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
        'memoryRequirements',
        'processorRequirements',
        'storageRequirements',
        'relatedLink',
        'referencePublication',
        'keywords',
        'applicationCategory'
    ];

    public const REPOSITORY_CODEMETA_KEYS = [
        'contIntegration',
        'issueTracker',
        'readme',
        'relatedLink',
        'developmentStatus'
    ];

    public const CODE_CODEMETA_KEYS = [
        'runtimePlatform',
        'operatingSystem',
        'softwareRequirements'
    ];

    public const PERFORMANCE_CODEMETA_KEYS = [
        'memoryRequirements',
        'processorRequirements',
        'storageRequirements',
    ];

    public const BUNDLE_CODEMETA_KEYS = [
        'downloadUrl',
        'installUrl',
        'buildInstructions',
        'softwareHelp'
    ];

    public const FILESYSTEM_CODEMETA_KEYS = [
        'fileSize',
        'fileFormat',
        'encoding'
    ];

    public const SWH_CODEMETA_KEYS = [
        'codeRepository'
    ];

    public const RELEASE_CODEMETA_KEY = 'version';

    public const TEXTAREA_ARRAYS_CODEMETA_KEYS = [
        'relatedLink',
        'referencePublication',
    ];

    public const SW_PUBLISHED_CODEMETA_KEYS = [
        'publisher',
        'url'
    ];

    public const SW_RELEASE_CODEMETA_KEYS = [
        'version',
        'isPartOf',
        'releaseNotes'
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
            "step2" => ['identifier'],
            "step3" => [ 'author.*.givenName',  'author.*.familyName' ]
        ],
        "bibLaTex" => [
            "step1" => [ 'name', 'dateCreated', 'publisher.url', 'dateModified' ],
            "step2" => ['identifier'],
            "step3" => [ 'author.*.givenName', 'author.*.familyName' ]
        ],
        "dataCite" => [
            "step1" => [ 'name', 'datePublished', 'publisher.name'],
            "step2" => ['identifier'],
            "step3" => [
                'author.*.givenName',
                'author.*.familyName',
                'contributor.*.givenName',
                'contributor.*.familyName',
                'contributor.givenName',
                'contributor.familyName',
                'funder.*.name',
                'funder.name',
                'funder.*.@id',
                'funder.@id'
            ]
        ],
        "swhXML" => [
            "step1" => [],
            "step2" => [ 'codeRepository' ],
            "step3" => []
        ]
    ];
}
