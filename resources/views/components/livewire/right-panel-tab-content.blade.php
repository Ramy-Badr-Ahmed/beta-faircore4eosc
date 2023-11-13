
<div role="tabpanel" id="{{$tapFor}}"  @class(['tab-pane', 'fadeIn', 'active' => $isActivated, 'has-error' => $errors->has($tapFor)])>
    <div style="float:right">
        <button @class(['btn', 'btn-xs', 'btn-info' ,'-btn', '-btn-effect',
                        'btn-primary -btn-effect-deposit'
                            => $tapFor === "swhXML"
                            ])
            wire:loading.class="hidden" wire:target="convertTo, depositMetaData2Swh"
            @if($tapFor === 'swhXML') disabled @endif   {{--todo: remove disabled when deposit ready--}}

            wire:click="@if($tapFor === "swhXML") depositMetaData2Swh() @else convertTo('{{$tapFor}}') @endif" >

            @if($tapFor === "swhXML")
                <span class="glyphicon glyphicon-flag" aria-hidden="true" style="padding-right: 5px"></span>Deposit2Swh
            @else
                <span class="glyphicon glyphicon-random" aria-hidden="true" style="padding-right: 5px"></span>Get {{$tapFor}}
            @endif
        </button>
    </div>

    <div class="row">
        <div class="col-md-5">
            <label for="id_{{$tapFor}}" class="control-label" style="letter-spacing: 2px;"
                   wire:target="convertTo, activatePill, download, copy, @if($tripMode==='lazy') formData @endif" wire:loading.class="blur">{{$tapFor}}</label>
        </div>
        @if($tapFor === "swhXML")
            <div class="col-md-4">
                <button class="btn btn-xs btn-info -btn -btn-effect" wire:click="generateSwhXML()" wire:loading.class="hidden" wire:target="generateSwhXML">
                    <span class="glyphicon glyphicon-random" aria-hidden="true" style="padding-right: 5px"></span>Get XML</button>
            </div>
        @endif
    </div>

    <textarea class="form-control" rows="{{ isset($textAreaInput) ? substr_count($textAreaInput, "\n") +1 : 3 }}" wire:model="{{$tapFor}}"
              id="id_{{$tapFor}}" name="{{$tapFor}}" readonly placeholder="Conversion appears here for {{$tapFor}} @if(!in_array($tapFor, ['bibTex', 'bibLaTex', 'dataCite']))(under construction)
              @endif">{{$textAreaInput}}</textarea>
</div>
