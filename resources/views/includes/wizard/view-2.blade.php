
<div id="div_id_codeRepository" style="margin-bottom:25px" class="form-group @error($codeRepository['wireModel']) has-error @enderror">

    <div class="row center-block">

        <label for="id_codeRepository" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$codeRepository['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($codeRepository['wireModel'])) blur-red @else blur @endif ">Code Repository
            <span style="color: #ab0f0f" class="glyphicon glyphicon-asterisk small"></span>
        </label>

        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$codeRepository['info']}}"><i class="glyphicon glyphicon-info-sign "></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$codeRepository['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$codeRepository['codeMetaKey']}}" data-html="true"
                   data-content="{{$codeRepository['codeMetaInfo'].preg_replace('/\?/', $codeRepository['expanded-JSON-LD'] , $codeRepository['expanded'])
                                    .preg_replace('/\?/', $codeRepository['compacted-JSON-LD'] , $codeRepository['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_codeRepository" name="codeRepository" placeholder="{{$codeRepository['placeHolder']}}"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.lazy="{{$codeRepository['wireModel']}}"/>

            <x-livewire.view-errors :wiredFormData="$codeRepository['wireModel']" :crossMark="true"/>
        </div>
    </div>

    @if(!$errors->has($codeRepository['wireModel']))
        <div class="flex-container fadeInUp" style="border:none; margin-top: 15px;">
            <div class="flex-Error-bell">
                <i class="glyphicon glyphicon-search text-info"></i>
            </div>
            <div class="flex-Error-msg">
                <span class="-msg">Known to Software Heritage: <i class="hidden" wire:target="{{$codeRepository['wireModel']}}, checkRepoWithSwh" wire:loading.class.remove="hidden">Checking ...</i><i wire:target="{{$codeRepository['wireModel']}},checkRepoWithSwh " wire:loading.class.add="hidden">{{var_export($isKnown, true)}}</i></span>

                @if($isKnown)
                    <a tabindex="0" role="button" data-toggle="popover" data-placement="bottom" title="{{$swhVisit['visitTitle']}}" data-html="true"
                       wire:key="popoverInfo.{{$codeRepository['codeMetaKey'].$time}}" data-content="{{ preg_replace_array('/\?/', $visitData, $swhVisit['visitData'])}}">
                        <i class="glyphicon thin glyphicon-zoom-in"></i><i class="glyphicon thin glyphicon-info-sign"></i>
                    </a>
                    <button @class(["btn", "btn-xs", "btn-info", "-btn", "-btn-effect", "hide" => $archivalRunning === true]) style="margin-left: 10px"
                            wire:click.prevent="archiveNow()" wire:loading.attr="disabled">
                        <span class="glyphicon glyphicon-repeat" aria-hidden="true" style="padding-right: 5px"></span>Re-Archive!
                    </button>
                @endif

                <button @class(["btn", "btn-xs", "btn-info", "-btn", "-btn-effect", "hide" => $isKnown === true || !isset($isKnown) || $archivalRunning === true])
                    wire:click.prevent="archiveNow()" wire:loading.attr="disabled">
                        <span class="glyphicon glyphicon-flag" aria-hidden="true" style="padding-right: 5px"></span>Archive it!
                </button>

                <button @class(["btn", "btn-xs", "btn-info", "-btn", "-btn-effect", "hide" => !isset($archivalRunning)])
                        wire:click.prevent="checkRepoWithSwh()" wire:loading.attr="disabled" style="margin-left: 10px">
                    <span class="glyphicon glyphicon-repeat" aria-hidden="true" style="padding-right: 5px"></span>Check
                </button>

                <a href="{{route('on-the-fly-view')}}" target='_blank' @class(["hide" => !isset($archivalRunning)]) style="margin-left: 8px">
                    <span style="font-family: Consolas, sans-serif">Progress</span>
                    <span class="glyphicon glyphicon-new-window" aria-hidden="true" style="margin: auto 5px;font-size: 14px"></span>
                </a>

            </div>
        </div>
    @endif

    <x-livewire.view-errors :wiredFormData="$codeRepository['wireModel']"/>
</div>

<div id="div_id_identifierRadio" style="margin-bottom:25px" class="form-group clearfix">
    <div class="row center-block">
        @php
            $hasError = $errors->has($identifier['wireModel']);
            $hasIdError = $hasError && str_contains($errors->get($identifier['wireModel'])[0], 'incompatible');
        @endphp
        <div class="col-md-3 like-label @if($hasIdError) text-danger @endif"
             wire:target="extractCodeMeta, idType, generateCodeMeta"
             wire:loading.class="@if($errors->has($identifier['wireModel'])) blur-red @else blur @endif" >Identifier Type
        </div>
        <div class="col-md-9 input-group">

            <label @class(['radio-inline', 'text-danger' => $hasIdError && $idType === 'DOI']) >
                <input type="radio" name="identifierOptionsRadios" id="id_identifierRadio_DOI" value="DOI"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements, idType
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="idType">DOI
            </label>
            <label @class(['radio-inline', 'text-danger' => $hasIdError && $idType === 'SWHID'])>
                <input type="radio" name="identifierOptionsRadios" id="id_identifierRadio_SWHID" value="SWHID"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements, idType
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="idType">SWHID Resolver
            </label>
        </div>
    </div>
</div>


<div id="div_id_identifier" style="margin-bottom:25px" class="form-group @error($identifier['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_identifier" class="col-md-3 control-label"
               wire:target="extractCodeMeta, idType, @if($tripMode!=='defer') {{$identifier['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($identifier['wireModel'])) blur-red @else blur @endif ">Unique Identifier<br>{{$idType}}</label>
        <div class="col-md-9 input-group" >
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$identifier['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i>
                </a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$identifier['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$identifier['codeMetaKey']}}" data-html="true"
                   data-content="{{$identifier['codeMetaInfo'].preg_replace('/\?/', $identifier['expanded-JSON-LD'] , $identifier['expanded'])
                                    .preg_replace('/\?/', $identifier['compacted-JSON-LD'] , $identifier['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_identifier" name="identifier"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.lazy="{{$identifier['wireModel']}}"
                   placeholder="@switch($idType) @case('DOI') {{$identifier['placeHolderDOI']}} @break @case('SWHID') {{$identifier['placeHolderSWHID']}} @break @default {{$identifier['placeHolder']}}
                                @endswitch"
                   @disabled($idType === null)/>

            <x-livewire.view-errors :wiredFormData="$identifier['wireModel']" :crossMark="true"/>
        </div>
    </div>

    @if(!$errors->has($identifier['wireModel']) && $idType === 'SWHID')
        <div class="flex-container fadeInUp" style="border:none; margin-top: 15px;">
            <div class="flex-Error-bell">
                <i class="glyphicon glyphicon-search text-info"></i>
            </div>
            <div class="flex-Error-msg">
                <span class="-msg">Software Heritage DAG Node (status code): <i class="hidden" wire:target="{{$identifier['wireModel']}}, checkIdentifierWithSwh" wire:loading.class.remove="hidden">Checking ...</i><i wire:target="{{$identifier['wireModel']}}, checkIdentifierWithSwh " wire:loading.class.add="hidden">{{var_export($idStatusCode, true)}}@switch($idStatusCode) @case(200) — Found @break @case(400) — Invalid @break @case(404) — Not Found @break @endswitch</i></span>

                <button @class(["btn", "btn-xs", "btn-info", "-btn", "-btn-effect", "hide" => $idStatusCode === 200 || !isset($idStatusCode)])
                        wire:click.prevent="checkIdentifierWithSwh()" wire:loading.attr="disabled" wire:target="{{$identifier['wireModel']}}, checkIdentifierWithSwh">
                    <span class="glyphicon glyphicon-repeat" aria-hidden="true" style="padding-right: 5px"></span>Check
                </button>

            </div>
        </div>
    @endif

    <x-livewire.view-errors :wiredFormData="$identifier['wireModel']"/>
</div>

<div id="div_id_repoRadio" style="margin-bottom:25px" class="form-group clearfix">
    <div class="row center-block">
        <div class="col-md-4 like-label"
             wire:target="extractCodeMeta, viewFlags.swRepository, generateCodeMeta"
             wire:loading.class="blur" wire:key="popover.swRepositoryRadio.{{$time}}">
            <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
               data-content="{{$swRadio['repository']}}"><i class="glyphicon glyphicon-info-sign" style="margin-right: 5px"></i>
            </a>Are there Repository-related MetaData?
        </div>
        <div class="col-md-8 input-group">

            <label class="radio-inline">
                <input type="radio" name="repoOptionsRadios" id="id_repoRadio_1" value="1"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swRepository" @checked($viewFlags['swRepository'])  > Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="repoOptionsRadios" id="id_repoRadio_0" value="0"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swRepository" @checked(!$viewFlags['swRepository'])>No
            </label>

        </div>
    </div>
</div>

<div id="div_id_contIntegration" style="margin-bottom:25px"  @php($hasError = (bool)$errors->has($contIntegration['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRepository'], 'has-error' => $hasError])>
    <div class="row center-block">
        <label for="id_contIntegration" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRepository, @if($tripMode!=='defer') {{$contIntegration['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($contIntegration['wireModel'])) blur-red @else blur @endif ">Continuous Integration
        </label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$contIntegration['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$contIntegration['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$contIntegration['codeMetaKey']}}" data-html="true"
                   data-content="{{$contIntegration['codeMetaInfo'].preg_replace('/\?/', $contIntegration['expanded-JSON-LD'] , $contIntegration['expanded'])
                                    .preg_replace('/\?/', $contIntegration['compacted-JSON-LD'] , $contIntegration['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_contIntegration" name="contIntegration"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$contIntegration['wireModel']}}" placeholder="{{$contIntegration['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$contIntegration['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$contIntegration['wireModel']"/>
</div>

<div id="div_id_issueTracker" style="margin-bottom:25px"  @php($hasError = (bool)$errors->has($issueTracker['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRepository'], 'has-error' => $hasError])>
    <div class="row center-block">
        <label for="id_issueTracker" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRepository, @if($tripMode!=='defer') {{$issueTracker['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($issueTracker['wireModel'])) blur-red @else blur @endif ">Issue Tracker
        </label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$issueTracker['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$issueTracker['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$issueTracker['codeMetaKey']}}" data-html="true"
                   data-content="{{$issueTracker['codeMetaInfo'].preg_replace('/\?/', $issueTracker['expanded-JSON-LD'] , $issueTracker['expanded'])
                                    .preg_replace('/\?/', $issueTracker['compacted-JSON-LD'] , $issueTracker['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_issueTracker" name="issueTracker"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$issueTracker['wireModel']}}" placeholder="{{$issueTracker['placeHolder']}}"   />

            <x-livewire.view-errors :wiredFormData="$issueTracker['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$issueTracker['wireModel']"/>
</div>

<div id="div_id_readme" style="margin-bottom:25px"  @php($hasError = (bool)$errors->has($readme['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRepository'], 'has-error' => $hasError])>
    <div class="row center-block">
        <label for="id_readme" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRepository, @if($tripMode!=='defer') {{$readme['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($readme['wireModel'])) blur-red @else blur @endif ">ReadMe File</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$readme['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$readme['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$readme['codeMetaKey']}}" data-html="true"
                   data-content="{{$readme['codeMetaInfo'].preg_replace('/\?/', $readme['expanded-JSON-LD'] , $readme['expanded'])
                                    .preg_replace('/\?/', $readme['compacted-JSON-LD'] , $readme['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_readme" name="readme"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$readme['wireModel']}}" placeholder="{{$readme['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$readme['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$readme['wireModel']"/>
</div>

<div id="div_id_relatedLink" style="margin-bottom:25px"  @php($hasError = (bool)$errors->has($relatedLink['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRepository'], 'has-error' => $hasError])>
    <div class="row center-block">
        <label for="id_relatedLink" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRepository, @if($tripMode!=='defer') {{$relatedLink['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="blur">Related Links
        </label>
        <div class="col-md-9 input-group" >
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$relatedLink['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$relatedLink['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$relatedLink['codeMetaKey']}}" data-html="true"
                   data-content="{{$relatedLink['codeMetaInfo'].preg_replace('/\?/', $relatedLink['expanded-JSON-LD'] , $relatedLink['expanded'])
                                    .preg_replace('/\?/', $relatedLink['compacted-JSON-LD'] , $relatedLink['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            @php($relatedLinkTripMode = $tripMode !== 'defer' ? 'lazy' : $tripMode)

            <textarea class="input-md form-control"  name="relatedLink" id="id_relatedLink"
                      wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                      wire:model.{{$relatedLinkTripMode}}="{{$relatedLink['wireModel']}}"
                      placeholder="{{$relatedLink['placeHolder']}}">
                </textarea>
            <x-livewire.view-errors :wiredFormData="$relatedLink['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$relatedLink['wireModel']" :errorURLArray="true"/>
</div>

<div id="div_id_developmentStatus" style="margin-bottom:25px"  @php($hasError = (bool)$errors->has($developmentStatus['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRepository'], 'has-error' => $hasError])>
    <div class="row center-block">
        <label for="id_developmentStatus" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRepository, @if($tripMode!=='defer') {{$developmentStatus['codeMetaKey']}} @else generateCodeMeta @endif"
               wire:loading.class="blur">Development Status</label>
        <div class="col-md-9 input-group" >
            <div class="input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$developmentStatus['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$developmentStatus['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$developmentStatus['codeMetaKey']}}" data-html="true"
                   data-content="{{$developmentStatus['codeMetaInfo'].preg_replace('/\?/', $developmentStatus['expanded-JSON-LD'] , $developmentStatus['expanded'])
                                    .preg_replace('/\?/', $developmentStatus['compacted-JSON-LD'] , $developmentStatus['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <select class="form-control" id="id_developmentStatus" name="developmentStatus"
                    wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                    wire:model.{{$tripMode}}="{{$developmentStatus['wireModel']}}" >

                <option value="" selected hidden>Select Development Status</option>

                @foreach($devStatuses as $devStatus)

                    <option value="{{ $devStatus }}">{{ $devStatus }}</option>

                @endforeach
            </select>
            <div class="input-group-addon">
                <a tabindex="0" role="button"
                   wire:click="$emit('clearOut', '{{explode('.', $developmentStatus['wireModel'])[1]}}')"><i class="glyphicon glyphicon-erase"></i></a>
            </div>
            <x-livewire.view-errors :wiredFormData="$developmentStatus['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$developmentStatus['wireModel']"/>
</div>

<hr class="style1"/>

<div id="div_id_bundleRadio" style="margin-bottom:25px" class="form-group clearfix">
    <div class="row center-block">
        <div class="col-md-4 like-label"
             wire:target="extractCodeMeta, viewFlags.swBundle, generateCodeMeta"
             wire:loading.class="blur" wire:key="popover.swBundleRadio.{{$time}}">
            <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
               data-content="{{$swRadio['bundle']}}"><i class="glyphicon glyphicon-info-sign" style="margin-right: 5px"></i>
            </a>Is this SW instance a SW bundle as well?
        </div>
        <div class="col-md-8 input-group">

            <label class="radio-inline">
                <input type="radio" name="bundleOptionsRadios" id="id_bundleRadio_1" value="1"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swBundle" @checked($viewFlags['swBundle'])> Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="bundleOptionsRadios" id="id_bundleRadio_0" value="0"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swBundle" @checked(!$viewFlags['swBundle'])>No
            </label>

        </div>
    </div>
</div>

<div id="div_id_downloadUrl" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has($downloadUrl['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swBundle'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_downloadUrl" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swBundle, @if($tripMode!=='defer') {{$downloadUrl['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($downloadUrl['wireModel'])) blur-red @else blur @endif ">Download URL</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$downloadUrl['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$downloadUrl['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$downloadUrl['codeMetaKey']}}" data-html="true"
                   data-content="{{$downloadUrl['codeMetaInfo'].preg_replace('/\?/', $downloadUrl['expanded-JSON-LD'] , $downloadUrl['expanded'])
                                    .preg_replace('/\?/', $downloadUrl['compacted-JSON-LD'] , $downloadUrl['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_downloadUrl" name="downloadUrl"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$downloadUrl['wireModel']}}" placeholder="{{$downloadUrl['placeHolder']}}"
            />
            <x-livewire.view-errors :wiredFormData="$downloadUrl['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$downloadUrl['wireModel']"/>
</div>

<div id="div_id_installUrl" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has($installUrl['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swBundle'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_installUrl" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swBundle, @if($tripMode!=='defer') {{$installUrl['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($installUrl['wireModel'])) blur-red @else blur @endif ">Install URL</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$installUrl['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>
            <div class=" input-group-addon border" wire:key="popover.{{$installUrl['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$installUrl['codeMetaKey']}}" data-html="true"
                   data-content="{{$installUrl['codeMetaInfo'].preg_replace('/\?/', $installUrl['expanded-JSON-LD'] , $installUrl['expanded'])
                                    .preg_replace('/\?/', $installUrl['compacted-JSON-LD'] , $installUrl['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_installUrl" name="installUrl"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$installUrl['wireModel']}}" placeholder="{{$installUrl['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$installUrl['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$installUrl['wireModel']"/>
</div>

<div id="div_id_buildInstructions" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has($buildInstructions['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swBundle'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_buildInstructions" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swBundle, @if($tripMode!=='defer') {{$buildInstructions['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($buildInstructions['wireModel'])) blur-red @else blur @endif ">Build instructions</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$buildInstructions['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>
            <div class=" input-group-addon border" wire:key="popover.{{$buildInstructions['codeMetaKey'].$time}}">
                <a tabindex="0"   role="button" data-toggle="popover" title="{{$buildInstructions['codeMetaKey']}}" data-html="true"
                   data-content="{{$buildInstructions['codeMetaInfo'].preg_replace('/\?/', $buildInstructions['expanded-JSON-LD'] , $buildInstructions['expanded'])
                                    .preg_replace('/\?/', $buildInstructions['compacted-JSON-LD'] , $buildInstructions['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>
            <input type="text"  class="input-md form-control" id="id_buildInstructions" name="buildInstructions"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$buildInstructions['wireModel']}}" placeholder="{{$buildInstructions['placeHolder']}}"   />

            <x-livewire.view-errors :wiredFormData="$buildInstructions['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$buildInstructions['wireModel']"/>
</div>

<div id="div_id_softwareHelp" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has($softwareHelp['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swBundle'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_softwareHelp" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swBundle, @if($tripMode!=='defer') {{$softwareHelp['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($softwareHelp['wireModel'])) blur-red @else blur @endif ">Software Help</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$softwareHelp['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>
            <div class=" input-group-addon border" wire:key="popover.{{$softwareHelp['codeMetaKey'].$time}}">
                <a tabindex="0"   role="button" data-toggle="popover" title="{{$softwareHelp['codeMetaKey']}}" data-html="true"
                   data-content="{{$softwareHelp['codeMetaInfo'].preg_replace('/\?/', $softwareHelp['expanded-JSON-LD'] , $softwareHelp['expanded'])
                                    .preg_replace('/\?/', $softwareHelp['compacted-JSON-LD'] , $softwareHelp['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>
            <input type="text"  class="input-md form-control" id="id_softwareHelp" name="softwareHelp"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$softwareHelp['wireModel']}}" placeholder="{{$softwareHelp['placeHolder']}}"   />

            <x-livewire.view-errors :wiredFormData="$softwareHelp['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$softwareHelp['wireModel']"/>
</div>


<div id="div_id_encodingRadio" style="margin-bottom:25px" @class(['form-group', 'clearfix', 'fadeIn', 'hide' => !$viewFlags['swBundle']])>
    <div class="row center-block">
        <div class="col-md-4 like-label"
             wire:target="extractCodeMeta, viewFlags.swFileSystem, viewFlags.swBundle, generateCodeMeta"
             wire:loading.class="blur" wire:key="popover.swFileSystemRadio.{{$time}}">
            <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
               data-content="{{$swRadio['fileSystem']}}"><i class="glyphicon glyphicon-info-sign" style="margin-right: 5px"></i>
            </a>Are there FileSystem-related metadata?
        </div>
        <div class="col-md-8 input-group">

            <label class="radio-inline">
                <input type="radio" name="encodingOptionsRadios" id="id_encodingRadio_1" value="1"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swFileSystem" @checked($viewFlags['swFileSystem'])> Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="encodingOptionsRadios" id="id_encodingRadio_0" value="0"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swFileSystem" @checked(!$viewFlags['swFileSystem'])>No
            </label>

        </div>
    </div>
</div>

<div id="div_id_fileSize" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has($fileSize['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swFileSystem'] || !$viewFlags['swBundle'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_fileSize" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swFileSystem, viewFlags.swBundle, @if($tripMode!=='defer') {{$fileSize['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($fileSize['wireModel'])) blur-red @else blur @endif ">File size</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$fileSize['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$fileSize['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$fileSize['codeMetaKey']}}" data-html="true"
                   data-content="{{$fileSize['codeMetaInfo'].preg_replace('/\?/', $fileSize['expanded-JSON-LD'] , $fileSize['expanded'])
                                    .preg_replace('/\?/', $fileSize['compacted-JSON-LD'] , $fileSize['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_fileSize" name="fileSize"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$fileSize['wireModel']}}" placeholder="{{$fileSize['placeHolder']}}"
            />
            <x-livewire.view-errors :wiredFormData="$fileSize['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$fileSize['wireModel']"/>
</div>

<div id="div_id_fileFormat" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has($fileFormat['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swFileSystem'] || !$viewFlags['swBundle'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_fileFormat" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swFileSystem, viewFlags.swBundle, @if($tripMode!=='defer') {{$fileFormat['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($fileFormat['wireModel'])) blur-red @else blur @endif ">File format</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$fileFormat['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$fileFormat['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$fileFormat['codeMetaKey']}}" data-html="true"
                   data-content="{{$fileFormat['codeMetaInfo'].preg_replace('/\?/', $fileFormat['expanded-JSON-LD'] , $fileFormat['expanded'])
                                    .preg_replace('/\?/', $fileFormat['compacted-JSON-LD'] , $fileFormat['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_fileFormat" name="fileSize"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$fileFormat['wireModel']}}" placeholder="{{$fileFormat['placeHolder']}}"/>
            <x-livewire.view-errors :wiredFormData="$fileFormat['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$fileFormat['wireModel']"/>
</div>

<div id="div_id_encoding" style=" margin-bottom:25px"  @php($hasError = (bool)$errors->has($encoding['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swFileSystem'] || !$viewFlags['swBundle'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_encoding" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swFileSystem, viewFlags.swBundle, @if($tripMode!=='defer') {{$encoding['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($encoding['wireModel'])) blur-red @else blur @endif ">Encoding</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$encoding['info']}}"> <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$encoding['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$encoding['codeMetaKey']}}" data-html="true"
                   data-content="{{$encoding['codeMetaInfo'].preg_replace('/\?/', $encoding['expanded-JSON-LD'] , $encoding['expanded'])
                                    .preg_replace('/\?/', $encoding['compacted-JSON-LD'] , $encoding['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_encoding" name="encoding"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$encoding['wireModel']}}" placeholder="{{$encoding['placeHolder']}}"
            />
            <x-livewire.view-errors :wiredFormData="$encoding['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$encoding['wireModel']"/>
</div>

<hr class="style1"/>

<div id="div_id_programmingLanguage" style="margin-bottom:25px" class="form-group @error($programmingLanguage['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_programmingLanguage" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$programmingLanguage['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($programmingLanguage['wireModel'])) blur-red @else blur @endif ">Programming Languages &nbsp;
            <span style="color: #ab0f0f" class="glyphicon glyphicon-asterisk small"></span>
        </label>
        <div class="col-md-9 input-group" >
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$programmingLanguage['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$programmingLanguage['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$programmingLanguage['codeMetaKey']}}" data-html="true"
                   data-content="{{$programmingLanguage['codeMetaInfo'].preg_replace('/\?/', $programmingLanguage['expanded-JSON-LD'] , $programmingLanguage['expanded'])
                                    .preg_replace('/\?/', $programmingLanguage['compacted-JSON-LD'] , $programmingLanguage['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_programmingLanguage" name="programmingLanguage"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$programmingLanguage['wireModel']}}" placeholder="{{$programmingLanguage['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$programmingLanguage['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$programmingLanguage['wireModel']"/>
</div>

<div id="div_id_codeRadio" style="margin-bottom:25px" class="form-group clearfix">
    <div class="row center-block">
        <div class="col-md-4 like-label"
             wire:target="extractCodeMeta, viewFlags.swCode, generateCodeMeta"
             wire:loading.class="blur" wire:key="popover.swCodeRadio.{{$time}}">
            <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
               data-content="{{$swRadio['code']}}"><i class="glyphicon glyphicon-info-sign" style="margin-right: 5px"></i>
            </a>Are there Code-related MetaData?
        </div>
        <div class="col-md-8 input-group">

            <label class="radio-inline">
                <input type="radio" name="codeOptionsRadios" id="id_repoRadio_1" value="1"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swCode" @checked($viewFlags['swCode'])  > Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="codeOptionsRadios" id="id_repoRadio_0" value="0"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swCode" @checked(!$viewFlags['swCode'])>No
            </label>

        </div>
    </div>
</div>

<div id="div_id_runtimePlatform" style="margin-bottom:25px" @php($hasError = (bool)$errors->has($runtimePlatform['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swCode'], 'has-error' => $hasError])>
    <div class="row center-block">
        <label for="id_runtimePlatform" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swCode, @if($tripMode!=='defer') {{$runtimePlatform['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="blur">Runtime Platform</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$runtimePlatform['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$runtimePlatform['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$runtimePlatform['codeMetaKey']}}" data-html="true"
                   data-content="{{$runtimePlatform['codeMetaInfo'].preg_replace('/\?/', $runtimePlatform['expanded-JSON-LD'] , $runtimePlatform['expanded'])
                                    .preg_replace('/\?/', $runtimePlatform['compacted-JSON-LD'] , $runtimePlatform['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_runtimePlatform" name="runtimePlatform"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$runtimePlatform['wireModel']}}" placeholder="{{$runtimePlatform['placeHolder']}}"   />

            <x-livewire.view-errors :wiredFormData="$runtimePlatform['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$runtimePlatform['wireModel']"/>
</div>

<div id="div_id_operatingSystem" style="margin-bottom:25px"  @php($hasError = (bool)$errors->has($operatingSystem['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swCode'], 'has-error' => $hasError])>
    <div class="row center-block">
        <label for="id_operatingSystem" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swCode, @if($tripMode!=='defer') {{$operatingSystem['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($operatingSystem['wireModel'])) blur-red @else blur @endif ">Operating System</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$operatingSystem['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$operatingSystem['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$operatingSystem['codeMetaKey']}}" data-html="true"
                   data-content="{{$operatingSystem['codeMetaInfo'].preg_replace('/\?/', $operatingSystem['expanded-JSON-LD'] , $operatingSystem['expanded'])
                                    .preg_replace('/\?/', $operatingSystem['compacted-JSON-LD'] , $operatingSystem['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_operatingSystem" name="operatingSystem"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$operatingSystem['wireModel']}}" placeholder="{{$operatingSystem['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$operatingSystem['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$operatingSystem['wireModel']"/>
</div>


<div id="div_id_softwareRequirements" style="margin-bottom:25px"  @class(['form-group','fadeIn', 'hide' => !$viewFlags['swCode']])>
    <div class="row center-block">
        <label for="id_softwareRequirements" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swCode, @if($tripMode!=='defer') {{$softwareRequirements['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="blur">SW Requirements</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$softwareRequirements['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$softwareRequirements['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$softwareRequirements['codeMetaKey']}}" data-html="true"
                   data-content="{{$softwareRequirements['codeMetaInfo'].preg_replace('/\?/', $softwareRequirements['expanded-JSON-LD'] , $softwareRequirements['expanded'])
                                    .preg_replace('/\?/', $softwareRequirements['compacted-JSON-LD'] , $softwareRequirements['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_softwareRequirements" name="softwareRequirements"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$softwareRequirements['wireModel']}}" placeholder="{{$softwareRequirements['placeHolder']}}"   />
        </div>
    </div>
</div>

<div id="div_id_requirementsRadio" style="margin-bottom:25px" @class(['form-group', 'clearfix', 'fadeIn', 'hide' => !$viewFlags['swCode']])>
    <div class="row center-block">
        <div class="col-md-4 like-label"
             wire:target="extractCodeMeta, viewFlags.swRequirements, viewFlags.swCode, generateCodeMeta"
             wire:loading.class="blur" wire:key="popover.swPerformanceRadio.{{$time}}">
            <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
               data-content="{{$swRadio['performance']}}"><i class="glyphicon glyphicon-info-sign" style="margin-right: 5px"></i>
            </a>Are there Performance-related metadata?
        </div>
        <div class="col-md-8 input-group">

            <label class="radio-inline">
                <input type="radio" name="requirementsOptionsRadios" id="id_requirementsRadio_1" value="1"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swRequirements" @checked($viewFlags['swRequirements'])> Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="requirementsOptionsRadios" id="id_requirementsRadio_0" value="0"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swRequirements" @checked(!$viewFlags['swRequirements'])>No
            </label>

        </div>
    </div>
</div>

<div id="div_id_processorRequirements" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has($processorRequirements['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRequirements'] || !$viewFlags['swCode'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_processorRequirements" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRequirements, viewFlags.swCode, @if($tripMode!=='defer') {{$processorRequirements['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($processorRequirements['wireModel'])) blur-red @else blur @endif ">Processor Requirements</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$processorRequirements['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$processorRequirements['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$processorRequirements['codeMetaKey']}}" data-html="true"
                   data-content="{{$processorRequirements['codeMetaInfo'].preg_replace('/\?/', $processorRequirements['expanded-JSON-LD'] , $processorRequirements['expanded'])
                                    .preg_replace('/\?/', $processorRequirements['compacted-JSON-LD'] , $processorRequirements['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_processorRequirements" name="processorRequirements"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$processorRequirements['wireModel']}}" placeholder="{{$processorRequirements['placeHolder']}}"
            />
            <x-livewire.view-errors :wiredFormData="$processorRequirements['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$processorRequirements['wireModel']"/>
</div>

<div id="div_id_memoryRequirements" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has($memoryRequirements['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRequirements'] || !$viewFlags['swCode'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_memoryRequirements" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRequirements, viewFlags.swCode, @if($tripMode!=='defer') {{$memoryRequirements['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($memoryRequirements['wireModel'])) blur-red @else blur @endif ">Memory Requirements</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="info" data-html="true" data-placement="bottom"
                   data-content="{{$memoryRequirements['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$memoryRequirements['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$memoryRequirements['codeMetaKey']}}" data-html="true"
                   data-content="{{$memoryRequirements['codeMetaInfo'].preg_replace('/\?/', $memoryRequirements['expanded-JSON-LD'] , $memoryRequirements['expanded'])
                                    .preg_replace('/\?/', $memoryRequirements['compacted-JSON-LD'] , $memoryRequirements['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_memoryRequirements" name="memoryRequirements"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$memoryRequirements['wireModel']}}" placeholder="{{$memoryRequirements['placeHolder']}}"/>
            <x-livewire.view-errors :wiredFormData="$memoryRequirements['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$memoryRequirements['wireModel']"/>
</div>

<div id="div_id_storageRequirements" style=" margin-bottom:25px"  @php($hasError = (bool)$errors->has($storageRequirements['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRequirements'] || !$viewFlags['swCode'], 'has-error' => $hasError ])>
    <div class="row center-block">
        <label for="id_encoding" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRequirements, viewFlags.swCode, @if($tripMode!=='defer') {{$storageRequirements['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($storageRequirements['wireModel'])) blur-red @else blur @endif ">Storage Requirements</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$storageRequirements['info']}}"> <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$storageRequirements['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$storageRequirements['codeMetaKey']}}" data-html="true"
                   data-content="{{$storageRequirements['codeMetaInfo'].preg_replace('/\?/', $storageRequirements['expanded-JSON-LD'] , $storageRequirements['expanded'])
                                    .preg_replace('/\?/', $storageRequirements['compacted-JSON-LD'] , $storageRequirements['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_storageRequirements" name="storageRequirements"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swRepository, viewFlags.swBundle, viewFlags.swCode, viewFlags.swFunders, viewFlags.swFileSystem, viewFlags.swRequirements
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$storageRequirements['wireModel']}}" placeholder="{{$storageRequirements['placeHolder']}}"
            />
            <x-livewire.view-errors :wiredFormData="$storageRequirements['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$storageRequirements['wireModel']"/>
</div>


