@php($loopTripMode = $tripMode !== 'defer' ? 'lazy' : $tripMode)

@for ($thisFunder = 0; $thisFunder < $funderNumber; $thisFunder++)

    @php($wireFunder = "formData.funder.".$thisFunder)

    <h5 style="text-align:center; margin-bottom: 25px; margin-top: -10px;">Funder {{ $viewFlags['swFunders'] ? $thisFunder+1: ''}} MetaData</h5>
    <div @class(['row', 'center-block', 'fadeIn'=> $thisFunder > 0 ]) style=" margin-bottom:5px; border: none">

        <div wire:key="funder_{{ $thisFunder }}_funding" id="div_id_funder{{ $thisFunder }}_funding"
             class="form-group col-md-6 @error($wireFunder.$funding['inWireModel']) has-error @enderror ">

            <div>
                <label for="id_funder{{ $thisFunder }}_funding" class="control-label"
                       wire:target="extractCodeMeta, viewFlags.swFunders, @if($tripMode!=='defer') {{$wireFunder.$funding['inWireModel']}} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireFunder.$funding['inWireModel'])) blur-red @else blur @endif ">Funding</label>
                <div class="input-group" wire:key="popover.{{$thisFunder.$time}}_funding">
                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info"
                           data-html="true" data-content="{{$funding['info']}}">
                            <i class="glyphicon glyphicon-info-sign"></i>
                        </a>
                    </div>

                    <div class=" input-group-addon border">

                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$funding['codeMetaKey']}}"
                           data-html="true" data-content="{{$funding['codeMetaInfo'].preg_replace('/\?/', $funding['expanded-JSON-LD'] , $funding['expanded'])
                                    .preg_replace('/\?/', $funding['compacted-JSON-LD'] , $funding['compacted'])}}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text" class="input-md form-control" id="id_funder{{ $thisFunder }}_funding" name="funder{{ $thisFunder }}_funding"
                           wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                        @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$loopTripMode}}="{{$wireFunder.$funding['inWireModel']}}" placeholder="{{$funding['placeHolder']}}"
                    />
                </div>
            </div>
        </div>

        <div wire:key="funder_{{ $thisFunder }}_funder" id="div_id_funder{{ $thisFunder }}_funder"
             class="form-group col-md-6 @error($wireFunder.$funder['inWireModel']) has-error @enderror">

            <div>
                <label for="id_funder{{ $thisFunder }}_funder" class="control-label"
                       wire:target="extractCodeMeta, viewFlags.swFunders, @if($tripMode!=='defer') {{$wireFunder.$funder['inWireModel']}} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireFunder.$funder['inWireModel'])) blur-red @else blur @endif ">Funder
                </label>
                <div class="input-group" wire:key="popover.{{$thisFunder.$time}}_funder">
                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{$funder['info']}}">
                            <i class="glyphicon glyphicon-info-sign"></i>
                        </a>
                    </div>

                    <div class=" input-group-addon border">

                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$funder['codeMetaKey']}}"
                           data-html="true" data-content="{{$funder['codeMetaInfo'].preg_replace('/\?/', $funder['expanded-JSON-LD'] , $funder['expanded'])
                                    .preg_replace('/\?/', $funder['compacted-JSON-LD'] , $funder['compacted'])}}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text" class="input-md form-control" id="id_funder{{ $thisFunder }}_funder" name="funder{{ $thisFunder }}_funder"
                           wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                        @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$loopTripMode}}="{{$wireFunder.$funder['inWireModel']}}" placeholder="{{$funder['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireFunder.$funder['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="[$wireFunder.$funding['inWireModel'], $wireFunder.$funder['inWireModel']]" :errorArray="true" :funder="true" :funderNumber="$funderNumber"/>

    <div class="row fadeIn center-block" style="border: none">
        <div wire:key="funder_{{ $thisFunder }}_@id" id="div_id_funder{{ $thisFunder }}_@id"
             class="form-group col-md-12 affiliation @error($wireFunder.$funderID["inWireModel"]) has-error @enderror">

            <div>
                <label for="id_funder{{ $thisFunder }}_@id" class="control-label"
                       wire:target="extractCodeMeta, viewFlags.swFunders, @if($tripMode!=='defer') {{$wireFunder.$funderID['inWireModel']}} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireFunder.$funderID["inWireModel"])) blur-red @else blur @endif ">Funder Identifier (URI)
                </label>
                <div class="input-group" wire:key="popover.{{$thisFunder.$time}}_@id">
                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info"
                           data-html="true"
                           data-content="{{$funderID['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">

                        <a tabindex="0"  role="button" data-toggle="popover"
                           title="{{$funderID['codeMetaKey']}}" data-html="true"
                           data-content="{{$funderID['codeMetaInfo'].preg_replace('/\?/', $funderID['expanded-JSON-LD'] , $funderID['expanded'])
                                    .preg_replace('/\?/', $funderID['compacted-JSON-LD'] , $funderID['compacted'])}}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>
                    <input type="text"  class="input-md form-control" id="id_funder{{ $thisFunder }}_@id" name="funder{{ $thisFunder }}_@id"
                           wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                        @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$loopTripMode}}="{{$wireFunder.$funderID["inWireModel"]}}" placeholder="{{$funderID['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireFunder.$funderID['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$wireFunder.$funderID['inWireModel']" :errorArray="true" :funder="true" :funderNumber="$funderNumber"/>

    <x-livewire.funder-deletions :type="'funder'" :funderIdx="$thisFunder" :funderNumber="$funderNumber" :swFunders="$viewFlags['swFunders']"/>

    @if($thisFunder + 1 !== $funderNumber)
        <hr class="style1"/>
    @endif

@endfor



