<?php

use App\Rules\URLsArray;

return [
    "rules" => [
        "step1"=>
            [
                'formData.name' => 'string|required',
                'formData.description' => 'string|nullable',
                'formData.dateCreated' => 'date|nullable',
                'formData.datePublished' => 'date|after_or_equal:formData.dateCreated|nullable',
                'formData.dateModified' => 'date|after_or_equal:formData.datePublished|required_if:viewFlags.swRelease,true',
                'viewFlags.swPublished' => 'boolean',
                'viewFlags.swRelease' => 'boolean',
                'formData.publisher' => 'string|required_with:formData.url|required_if:viewFlags.swPublished,true',
                'formData.url' => 'url|required_with:formData.publisher',
                'formData.license' => 'required_with:formData.licenseInput',
                'formData.referencePublication' => new URLsArray(),
                'formData.isPartOf' => 'url|required_if:viewFlags.swRelease,true',
                'formData.hasPart'  => 'url|nullable',
                'formData.version' => 'string|required_if:viewFlags.swRelease,true',
                'formData.releaseNotes' => 'string|required_if:viewFlags.swRelease,true',
            ],
        "step2" =>
            [
                'formData.codeRepository' => 'url|required',
                'formData.identifier' => 'url',
                'viewFlags.swRepository' => 'boolean',
                'viewFlags.swCode' => 'boolean',
                'viewFlags.swBundle' => 'boolean',
                'viewFlags.swRequirements' => 'boolean',
                'viewFlags.swFileSystem' => 'boolean',
                'formData.contIntegration' => 'url|nullable',
                'formData.issueTracker' => 'url|nullable',
                'formData.readme' => 'url|required_if:viewFlags.swRepository,true',
                'formData.relatedLink' => new URLsArray(),
                'formData.developmentStatus' => 'required_if:viewFlags.swRepository,true',
                'formData.programmingLanguage' => 'min:1|required',
                'formData.operatingSystem' => 'exclude_if:getJSONValidation,true|required_with:formData.runtimePlatform',
                'formData.runtimePlatform' => 'required_if:viewFlags.swCode,true',
                'formData.processorRequirements' => 'required_if:viewFlags.swRequirements,true',
                'formData.memoryRequirements' => 'required_if:viewFlags.swRequirements,true',
                'formData.storageRequirements' => 'required_if:viewFlags.swRequirements,true',
                'formData.encoding' => 'string|required_if:viewFlags.swFileSystem,true',
                'formData.fileSize' => 'string|required_if:viewFlags.swFileSystem,true',
                'formData.fileFormat' => 'string|required_if:viewFlags.swFileSystem,true',
                'formData.downloadUrl' => 'url|required_if:viewFlags.swBundle,true',
                'formData.installUrl' => 'url|required_with:formData.buildInstructions',
                'formData.buildInstructions' => 'url|nullable',
                'formData.softwareHelp' => 'url|nullable',
            ],
        "step3" =>
            [
                'formData.author.*.givenName' => 'string|required',
                'formData.author.*.familyName' => 'string|nullable',
                'formData.author.*.email' => 'email|nullable|required_with:formData.author.*.affiliation',
                'formData.author.*.@id' => 'url|nullable',
                'formData.author.*.affiliation' => 'string|nullable',

                'formData.contributor.*.givenName' => 'string|nullable',
                'formData.contributor.*.familyName' => 'string|nullable',
                'formData.contributor.*.email' => 'email|nullable|required_with:formData.contributor.*.affiliation',
                'formData.contributor.*.@id' => 'url|nullable',
                'formData.contributor.*.affiliation' => 'string|nullable',

                'formData.maintainer.*.givenName' => 'string|nullable',
                'formData.maintainer.*.familyName' => 'string|nullable',
                'formData.maintainer.*.email' => 'email|nullable|required_with:formData.maintainer.*.affiliation',
                'formData.maintainer.*.@id' => 'url|nullable',
                'formData.maintainer.*.affiliation' => 'string|nullable',

                'viewFlags.swFunder' => 'boolean',
                'formData.funder.*.funding' => 'string|nullable',
                'formData.funder.*.funder' => 'string|required_with:formData.funder.*.@id,formData.funder.*.funding',
                'formData.funder.*.@id' => 'url|required_with:formData.funder.*.funder,formData.funder.*.funding',
            ],
        "right-panel" =>
            [
                'codeMetaImport' => 'json|nullable',
            ],
        "filtered" => [
            "step1" => [
                'formData.publisher' => 'string|required_with:formData.url',
                'formData.url' => 'url|nullable',
                'formData.referencePublication' => new URLsArray(),
                'formData.isPartOf' => 'url|nullable',
                'formData.hasPart'  => 'url|nullable',
            ],
            "step2" => [
                'formData.codeRepository' => 'url|nullable',
                'formData.readme' => 'url|nullable',
                'formData.contIntegration' => 'url|nullable',
                'formData.issueTracker' => 'url|nullable',
                'formData.identifier' => 'url|nullable',
                'formData.downloadUrl' => 'url|nullable',
                'formData.installUrl' => 'url|nullable',
                'formData.buildInstructions' => 'url|nullable',
            ],
            "step3" => [
                'formData.author.*.givenName' => 'string|required',
                'formData.author.*.email' => 'email|nullable',
                'formData.author.*.@id' => 'url|nullable',
                'formData.contributor.*.email' => 'email|nullable',
                'formData.contributor.*.@id' => 'url|nullable',
                'formData.maintainer.*.email' => 'email|nullable',
                'formData.maintainer.*.@id' => 'url|nullable',
                'formData.funder.*.funder' => 'string|required_with:formData.funder.*.@id,formData.funder.*.funding',
                'formData.funder.*.@id' => 'url|nullable',
            ],
        ]
    ],
    "messages" => [
        'formData.name.required' => 'The :attribute cannot be empty',
        'formData.datePublished.after_or_equal'=> ':attribute must not be in the past to Creation Date',
        'formData.dateModified.after_or_equal'=> ':attribute must not be in the past to Publication Date',
        'formData.dateModified'=> ':attribute must be provided for a SW Release instance',
        'formData.publisher.required_if' => ':attribute must be provided for a published SW instance',
        'formData.publisher.required_with' => ':attribute must be provided if its URL is',
        'formData.url.url' => 'Please provide a valid URL',
        'formData.url' => ':attribute must be provided if Publisher is',
        'formData.license' => ':attribute must be selected if License field is populated',
        'formData.encoding.required_if' => 'Missing :attribute with chosen FileSystem-related metaData',
        'formData.fileSize.required_if' => 'Missing :attribute with chosen FileSystem-related metaData',
        'formData.fileFormat.required_if' => 'Missing :attribute with chosen FileSystem-related metaData',
        'formData.processorRequirements.required_if' => 'Missing :attribute with chosen Performance-related metaData',
        'formData.memoryRequirements.required_if' => 'Missing :attribute with chosen Performance-related metaData',
        'formData.storageRequirements.required_if' => 'Missing :attribute with chosen Performance-related metaData',
        'formData.installUrl.url' => 'Please provide a valid URL',
        'formData.installUrl' => ':attribute must be provided if Build instructions URL is',
        'formData.downloadUrl.url' => 'Please provide a valid URL',
        'formData.downloadUrl.required_if' => 'Missing :attribute with chosen SW-Bundle-related metaData',
        'formData.buildInstructions.url' => 'Please provide a valid URL',
        'formData.softwareHelp.url' => 'Please provide a valid URL',
        'formData.version' => ':attribute must be populated for a SW Release instance',
        'formData.isPartOf.url' => 'Please provide a valid URL',
        'formData.hasPart.url' => 'Please provide a valid URL',
        'formData.isPartOf' => ':attribute must be provided for a SW Release instance',
        'formData.releaseNotes' => ':attribute must be provided for a SW Release instance',
        'formData.readme.url' => 'Please provide a valid URL',
        'formData.readme.required_if' => 'Missing :attribute with chosen Repository-related metaData',
        'formData.developmentStatus.required_if' => 'Missing :attribute with chosen Repository-related metaData',
        'formData.codeRepository.required' => 'This field cannot be empty',
        'formData.codeRepository.url' => 'Please provide a valid URL',
        'formData.contIntegration.url' => 'Please provide a valid URL',
        'formData.issueTracker.url' => 'Please provide a valid URL',
        'formData.programmingLanguage' => 'At least one language must be provided',
        'formData.operatingSystem' => ':attribute must be provided if Runtime Platform is',
        'formData.runtimePlatform.required_if' => 'Missing :attribute with chosen Code-related metaData',
        'formData.identifier.url' => 'Please provide a valid URL',
        'formData.referencePublication.url' => 'Please provide a valid URL',
        'formData.funder.*.funder.required_with' => ":attribute cannot be empty with non-empty URI/Funding",
        'formData.funder.*.@id.required_with' => ":attribute cannot be empty with non-empty Funder/Funding",
        'formData.funder.*.@id.url' => "Funder :position URL is invalid",
        'formData.author.*.givenName.required' => "Author :position name cannot be empty",
        'formData.author.*.email.email' => "Author :position email is invalid",
        'formData.author.*.email.required_with' => "Author :position email cannot be empty with non-empty affiliation",
        'formData.author.*.@id.url' => "Author :position URL is invalid",
        'formData.contributor.*.givenName.required' => "Contributor :position name cannot be empty",
        'formData.contributor.*.email.email' => "Contributor :position email is invalid",
        'formData.contributor.*.email.required_with' => "Contributor :position email cannot be empty with non-empty affiliation",
        'formData.contributor.*.@id.url' => "Contributor :position URL is invalid",
        'formData.maintainer.*.givenName.required' => "Maintainer :position name cannot be empty",
        'formData.maintainer.*.email.email' => "Maintainer :position email is invalid",
        'formData.maintainer.*.email.required_with' => "Maintainer :position email cannot be empty with non-empty affiliation",
        'formData.maintainer.*.@id.url' => "Maintainer :position URL is invalid",

        'codeMetaImport' => 'Invalid JSON format imported to :attribute',

        "filtered" => [
            'formData.publisher.required_with' => 'codeMeta: :attribute must be provided if its URL is',
            'formData.url.url' => 'codeMeta: Please provide a valid URL',
            'formData.installUrl.url' => 'codeMeta: Please provide a valid URL',
            'formData.downloadUrl.url' => 'codeMeta: Please provide a valid URL',
            'formData.buildInstructions.url' => 'codeMeta: Please provide a valid URL',
            'formData.isPartOf.url' => 'codeMeta: Please provide a valid URL',
            'formData.hasPart.url' => 'codeMeta: Please provide a valid URL',
            'formData.readme.url' => 'codeMeta: Please provide a valid URL',
            'formData.codeRepository.url' => 'codeMeta: Please provide a valid URL',
            'formData.contIntegration.url' => 'codeMeta: Please provide a valid URL',
            'formData.issueTracker.url' => 'codeMeta: Please provide a valid URL',
            'formData.identifier.url' => 'codeMeta: Please provide a valid URL',
            'formData.referencePublication.url' => 'codeMeta: Please provide a valid URL',
            'formData.funder.*.funder.required_with' => "codeMeta: :attribute cannot be empty with non-empty URI/Funding",
            'formData.funder.*.@id.url' => "codeMeta: Funder :position URL is invalid",
            'formData.author.*.givenName.required' => "codeMeta: Author :position name cannot be empty",
            'formData.author.*.email.email' => "codeMeta: Author :position email is invalid",
            'formData.author.*.@id.url' => "codeMeta: Author :position URL is invalid",
            'formData.contributor.*.email.email' => "codeMeta: Contributor :position email is invalid",
            'formData.contributor.*.@id.url' => "codeMeta: Contributor :position URL is invalid",
            'formData.maintainer.*.email.email' => "codeMeta: Maintainer :position email is invalid",
            'formData.maintainer.*.@id.url' => "codeMeta: Maintainer :position URL is invalid",
        ]
    ],
    "validationAttributes" => [
        'formData.name'=> 'SW Name',
        'formData.publisher'=> 'Publisher name',
        'formData.encoding'=> 'Encoding(s)',
        'formData.fileSize'=> 'File size(s)',
        'formData.fileFormat'=> 'File Format(s)',
        'formData.processorRequirements' => 'Processor Requirement(s)',
        'formData.memoryRequirements' => 'Memory Requirement(s)',
        'formData.storageRequirements' => 'Storage Requirement(s)',
        'formData.version'=> 'Sub/Release-version',
        'formData.datePublished'=> 'Publication Date',
        'formData.dateModified' => 'Release Date',
        'formData.url' => 'Publication URI',
        'formData.operatingSystem' => 'OS',
        'formData.funder.*.@id' => 'Funder :position URI',
        'formData.funder.*.funder' => 'Funder :position',
        'formData.installUrl' => 'Install Link',
        'formData.readme' => 'ReadMe Link',
        'formData.downloadUrl' => 'Download Link',
        'formData.developmentStatus' => 'Development Status',
        'formData.runtimePlatform' => 'Runtime Platform',
        'formData.isPartOf' => 'Parent CreativeWork',
        'formData.releaseNotes' => 'Release Notes',
        'formData.license' => 'SPDX',
        'codeMetaImport' => 'CodeMeta.json',
    ]
];
