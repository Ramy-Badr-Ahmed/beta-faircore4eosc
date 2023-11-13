<?php

namespace App\Http\Livewire\MetaData;

trait Properties
{
    public array $formData = [];

    protected array $rules;

    protected array $messages;
    protected array $validationAttributes;
    public array $panelNames = [
        1 => 'SW Preliminary MetaData',
        2 => 'Codebase & SW Discoverability',
        3 => 'Personage MetaData',
    ];
    public array $vocabularyRead = [];
    public array $formTerms = [];

    public int $viewPanel = 1;

    public int $authorNumber = 1;

    public int $funderNumber = 1;
    public int $contributorNumber = 0;
    public int $maintainerNumber = 0;

    public array $viewFlags = [
        'readOnceError' => false,
        'tripMode' => 'defer',
        'swRelease' => false,
        'swPublished' => false, // true
        'swFileSystem' => false,
        'swFunders' => false,
        'jsonPanel' => true,
        'jsonActive' => true,
        'jsonReadOnly' => true,
        'swhXMLActive' => false,
        'bibLaTexActive' => false,
        'bibTexActive' => false,
        'dataCiteActive' => false,
        'githubActive' => false,
        'zenodoActive' => false,
    ];
    protected bool $shouldSkipGenerate = false;

    public array $licenses = [];
    public array $devStatuses = [
        'concept',
        'wip',
        'suspended',
        'abandoned',
        'active',
        'inactive',
        'unsupported',
        'moved'
    ];
    public ?string $codeMetaJSON = Null;
    public bool $getJSONValidation = false;

    public ?string $codeMetaImport = Null;
    public bool $codeMetaImportLines = false;

    public ?string $swhXML = Null;

    public ?string $bibTex = Null;

    public ?string $bibLaTex = Null;

    public ?string $dataCite = Null;

    public ?string $github = Null;
    public ?string $zenodo = Null;
    public ?array $sessionValidationErrors = Null;
}
