
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

            <input type="text" class="input-md form-control" id="id_codeRepository" name="codeRepository"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$codeRepository['wireModel']}}" placeholder="{{$codeRepository['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$codeRepository['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$codeRepository['wireModel']"/>
</div>

<div id="div_id_contIntegration" style="margin-bottom:25px" class="form-group @error($contIntegration['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_contIntegration" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$contIntegration['wireModel']}} @else generateCodeMeta @endif"
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
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$contIntegration['wireModel']}}" placeholder="{{$contIntegration['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$contIntegration['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$contIntegration['wireModel']"/>
</div>

<div id="div_id_issueTracker" style="margin-bottom:25px" class="form-group @error($issueTracker['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_issueTracker" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$issueTracker['wireModel']}} @else generateCodeMeta @endif"
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
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$issueTracker['wireModel']}}" placeholder="{{$issueTracker['placeHolder']}}"   />

            <x-livewire.view-errors :wiredFormData="$issueTracker['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$issueTracker['wireModel']"/>
</div>

<div id="div_id_relatedLink" class="form-group" style="margin-bottom:25px">
    <div class="row center-block">
        <label for="id_relatedLink" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$relatedLink['wireModel']}} @else generateCodeMeta @endif"
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

            <textarea class="input-md form-control"  name="relatedLink" id="id_relatedLink"
                      wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                      wire:model.{{$tripMode}}="{{$relatedLink['wireModel']}}" placeholder="{{$relatedLink['placeHolder']}}">
                </textarea>
        </div>
    </div>
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
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$programmingLanguage['wireModel']}}" placeholder="{{$programmingLanguage['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$programmingLanguage['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$programmingLanguage['wireModel']"/>
</div>

<div id="div_id_runtimePlatform" style="margin-bottom:25px" class="form-group">
    <div class="row center-block">
        <label for="id_runtimePlatform" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$runtimePlatform['wireModel']}} @else generateCodeMeta @endif"
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
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$runtimePlatform['wireModel']}}" placeholder="{{$runtimePlatform['placeHolder']}}"   />
        </div>
    </div>
</div>

<div id="div_id_operatingSystem" style="margin-bottom:25px" class="form-group @error($operatingSystem['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_operatingSystem" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$operatingSystem['wireModel']}} @else generateCodeMeta @endif"
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
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$operatingSystem['wireModel']}}" placeholder="{{$operatingSystem['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$operatingSystem['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$operatingSystem['wireModel']"/>
</div>

<div id="div_id_softwareRequirements" style="margin-bottom:25px" class="form-group">
    <div class="row center-block">
        <label for="id_softwareRequirements" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$softwareRequirements['wireModel']}} @else generateCodeMeta @endif"
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
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$softwareRequirements['wireModel']}}" placeholder="{{$softwareRequirements['placeHolder']}}"   />
        </div>
    </div>
</div>

<div id="div_id_applicationCategory" style="margin-bottom:25px" class="form-group">
    <div class="row center-block">
        <label for="id_applicationCategory" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$applicationCategory['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="blur">Application Category</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$applicationCategory['info']}}"> <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$applicationCategory['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$applicationCategory['codeMetaKey']}}" data-html="true"
                   data-content="{{$applicationCategory['codeMetaInfo'].preg_replace('/\?/', $applicationCategory['expanded-JSON-LD'] , $applicationCategory['expanded'])
                                    .preg_replace('/\?/', $applicationCategory['compacted-JSON-LD'] , $applicationCategory['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_applicationCategory" name="applicationCategory"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$applicationCategory['wireModel']}}" placeholder="{{$applicationCategory['placeHolder']}}"
            />
        </div>
    </div>
</div>

<div id="div_id_keywords" style="margin-bottom:25px" class="form-group">
    <div class="row center-block">
        <label for="id_keywords" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$keywords['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="blur">Keywords</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$keywords['info']}}"> <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$keywords['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$keywords['codeMetaKey']}}" data-html="true"
                   data-content="{{$keywords['codeMetaInfo'].preg_replace('/\?/', $keywords['expanded-JSON-LD'] , $keywords['expanded'])
                                    .preg_replace('/\?/', $keywords['compacted-JSON-LD'] , $keywords['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_keywords" name="keywords"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$keywords['wireModel']}}" placeholder="{{$keywords['placeHolder']}}"   />
        </div>
    </div>
</div>

<div id="div_id_developmentStatus" style="margin-bottom:25px" class="form-group">
    <div class="row center-block">
        <label for="id_developmentStatus" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$developmentStatus['codeMetaKey']}} @else generateCodeMeta @endif"
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
                    wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                    wire:model.{{$tripMode}}="{{$developmentStatus['wireModel']}}" >

                <option value="" selected hidden>Select Development Status</option>

                @foreach($devStatuses as $devStatus)

                    <option value="{{ $devStatus }}">{{ $devStatus }}</option>

                @endforeach
            </select>
        </div>
    </div>
</div>

<hr class="style1"/>

<div id="div_id_identifier" style="margin-bottom:25px" class="form-group @error($identifier['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_identifier" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$identifier['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($identifier['wireModel'])) blur-red @else blur @endif ">Unique Identifier</label>
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
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$identifier['wireModel']}}" placeholder="{{$identifier['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$identifier['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$identifier['wireModel']"/>
</div>

<div id="div_id_referencePublication" style="margin-top: 10px; margin-bottom:25px" class="form-group @error($referencePublication['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_referencePublication" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$referencePublication['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($referencePublication['wireModel'])) blur-red @else blur @endif ">Reference Publication</label>
        <div class="col-md-9 input-group" >
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true"
                   data-content="{{$referencePublication['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$referencePublication['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$referencePublication['codeMetaKey']}}" data-html="true"
                   data-content="{{$referencePublication['codeMetaInfo'].preg_replace('/\?/', $referencePublication['expanded-JSON-LD'] , $referencePublication['expanded'])
                                    .preg_replace('/\?/', $referencePublication['compacted-JSON-LD'] , $referencePublication['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_referencePublication" name="referencePublication"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$referencePublication['wireModel']}}" placeholder="{{$referencePublication['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$referencePublication['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$referencePublication['wireModel']"/>
</div>

<div id="div_id_fundersRadio" style="margin-bottom:25px;" class="form-group clearfix">
    <div class="row center-block">
        <label for="id_fundersRadio" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swFunders, generateCodeMeta"
               wire:loading.class="blur">Is this SW instance multiply-funded?</label>
        <div class="col-md-9 input-group">

            <label class="radio-inline">
                <input type="radio" name="fundersOptionsRadios" id="id_fundersRadio_1" value="1"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                        @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swFunders"
                       @if($funderNumber===1) wire:click="$set('funderNumber', {{$funderNumber+1}})" @endif @checked($viewFlags['swFunders'])> Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="fundersOptionsRadios" id="id_fundersRadio_0" value="0"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swFunders
                                        @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swFunders"
                       wire:click ="$set('funderNumber', 1)"  @checked(!$viewFlags['swFunders'])>No
            </label>

        </div>
    </div>
</div>

@include('includes.funders')


