<div class="panel-footer footerCard">

    @php
        $textAreaID = json_encode(match (true){
                        $jsonActive  && $jsonReadOnly  => "id_codeMetaJSON",
                        $jsonActive === true && $jsonReadOnly === false =>'id_codeMetaImport',
                        $swhXMLActive  =>'id_swhXML',
                        $bibTexActive  =>'id_bibTex',
                        $bibLaTexActive =>'id_bibLaTex',
                        $dataCiteActive  =>'id_dataCite',
                        $githubActive  => 'id_github',
                        $zenodoActive  => 'id_zenodo',
            });
        $textArea = match(json_decode($textAreaID)){
            "id_codeMetaJSON" => $codeMetaJSON ?? null,
            "id_codeMetaImport" => $codeMetaImport ?? null,
            "id_swhXML" => $swhXML ?? null,
            "id_bibTex" => $bibTex ?? null,
            "id_bibLaTex" => $bibLaTex ?? null,
            "id_dataCite" => $dataCite ?? null,
            "id_github" => $github ?? null,
            "id_zenodo" => $zenodo ?? null,
            default => null
        };
    @endphp

    <div class="pull-right">

        <button class="btn btn-xs btn-info -btn -btn-effect" id="copy-btn" wire:click.prefetch = "copy({{ $textAreaID }})" @disabled(!isset($textArea))
        wire:target="copy" wire:loading.attr="disabled">
            <span class="glyphicon glyphicon-camera" aria-hidden="true" style="padding-right: 5px"></span>Copy</button>
    </div>

    <div class="row">
        <div class="col-md-5">

            <button class="btn btn-xs btn-info -btn -btn-effect" id="download-btn" wire:click.prefetch = "download( {{$textAreaID}})" @disabled(!isset($textArea))
            wire:target="download" wire:loading.class="hidden">
                <span class="glyphicon glyphicon-save" aria-hidden="true" style="padding-right: 5px"></span>Download
            </button>

        </div>
    </div>

</div>
