
<div id="div_id_name" style=" margin-bottom:25px" class="form-group @error($SWName["wireModel"]) has-error @enderror" >
    <div class="row center-block">
        <label for="id_name" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$SWName['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($SWName["wireModel"])) blur-red @else blur @endif ">SW name&nbsp;
            <span style="color: #ab0f0f" class="glyphicon glyphicon-asterisk small"></span>
        </label>

        <div class="input-group col-md-9">

            <div class="input-group-addon border" >
                <a tabindex="0" role="button" data-toggle="popover" title="Info" data-placement="bottom"
                   data-content="{{$SWName['info']}}"><i class="glyphicon thin glyphicon-info-sign" ></i>
                </a>
            </div>
            <div class="input-group-addon border" wire:key="popover.{{$SWName['codeMetaKey'].$time}}">
                <a tabindex="0" role="button" data-toggle="popover" title="{{$SWName['codeMetaKey']}}"
                   data-content="{{$SWName['codeMetaInfo'].preg_replace('/\?/', $SWName['expanded-JSON-LD'] , $SWName['expanded'])
                                    .preg_replace('/\?/', $SWName['compacted-JSON-LD'] , $SWName['compacted'])}}">
                    <div id="popover-content" style="display: none;">
                        <button class='btn btn-secondary'>Popover Button</button>
                    </div>
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_name" name="name" autocomplete="on"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}} = "{{$SWName['wireModel']}}" placeholder="{{$SWName['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$SWName['wireModel']" :crossMark="true"/>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$SWName['wireModel']"/>
</div>

<div id="div_id_description" class="form-group" style="margin-bottom:25px">
    <div class="row center-block">
        <label for="id_description" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$description['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="blur">Description</label>

        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0" role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$description['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>
            <div class=" input-group-addon border" wire:key="popover.{{$description['codeMetaKey'].$time}}">

                <a tabindex="0" role="button" data-toggle="popover" title="{{$description['codeMetaKey']}}" data-html="true"
                   data-content="{{$description['codeMetaInfo'].preg_replace('/\?/', $description['expanded-JSON-LD'] , $description['expanded'])
                                    .preg_replace('/\?/', $description['compacted-JSON-LD'] , $description['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>
            <textarea class="input-md form-control" placeholder="{{$description['placeHolder']}}" name="description" id="id_description"
                      wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.class="noDirt"
                      wire:model.{{$tripMode}}="{{$description['wireModel']}}"></textarea>
        </div>
    </div>
</div>

<div id="div_id_dateCreated" style="margin-bottom:25px" class="form-group  @error($dateCreated['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_dateCreated" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$dateCreated['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($dateCreated['wireModel'])) blur-red @else blur @endif ">Creation date
        </label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$dateCreated['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$dateCreated['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$dateCreated['codeMetaKey']}}" data-html="true"
                   data-content="{{$dateCreated['codeMetaInfo'].preg_replace('/\?/', $dateCreated['expanded-JSON-LD'] , $dateCreated['expanded'])
                                    .preg_replace('/\?/', $dateCreated['compacted-JSON-LD'] , $dateCreated['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="date" class="input-md form-control" id="id_dateCreated" name="dateCreated"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}} ="{{$dateCreated['wireModel']}}"/>

            <x-livewire.view-errors :wiredFormData="$dateCreated['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$dateCreated['wireModel']"/>
</div>

<div id="div_id_datePublished" style="margin-bottom:25px" class="form-group @error($datePublished['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_datePublished" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$datePublished['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($datePublished['wireModel'])) blur-red @else blur @endif ">Publication date</label>

        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$datePublished['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$datePublished['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$datePublished['codeMetaKey']}}" data-html="true"
                   data-content="{{$datePublished['codeMetaInfo'].preg_replace('/\?/', $datePublished['expanded-JSON-LD'] , $datePublished['expanded'])
                                    .preg_replace('/\?/', $datePublished['compacted-JSON-LD'] , $datePublished['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="date" class="input-md form-control" id="id_datePublished" name="datePublished"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$datePublished['wireModel']}}"/>

            <x-livewire.view-errors :wiredFormData="$datePublished['wireModel']" :crossMark="true"/>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$datePublished['wireModel']"/>
</div>

<div id="div_id_publishedRadio" style="margin-bottom:25px" class="form-group clearfix">
    <div class="row center-block">
        <div class="col-md-3 like-label"
             wire:target="extractCodeMeta, viewFlags.swPublished, generateCodeMeta"
             wire:loading.class="blur">Is this SW instance scholarly-published?
        </div>
        <div class="col-md-9 input-group">

            <label class="radio-inline">
                <input type="radio" name="publishedOptionsRadios" id="id_publishedRadio_1" value="1"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swPublished" @checked($viewFlags['swPublished'])  > Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="publishedOptionsRadios" id="id_publishedRadio_0" value="0"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swPublished" @checked(!$viewFlags['swPublished'])>No
            </label>

        </div>
    </div>
</div>

<div id="div_id_publisher" style="margin-bottom:25px"  @php($hasError = (bool)$errors->has($publisher['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swPublished'], 'has-error' => $hasError])>
    <div class="row center-block">
        <label for="id_publisher" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swPublished, @if($tripMode!=='defer') {{$publisher['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($publisher['wireModel'])) blur-red @else blur @endif ">Publisher</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$publisher['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class="input-group-addon border" wire:key="popover.{{$publisher['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$publisher['codeMetaKey']}}" data-html="true"
                   data-content="{{$publisher['codeMetaInfo'].preg_replace('/\?/', $publisher['expanded-JSON-LD'] , $publisher['expanded'])
                                    .preg_replace('/\?/', $publisher['compacted-JSON-LD'] , $publisher['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_publisher" name="publisher"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$publisher['wireModel']}}" placeholder="{{$publisher['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$publisher['wireModel']" :crossMark="true"/>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$publisher['wireModel']"/>

</div>

<div id="div_id_url" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has($url['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swPublished'], 'has-error' => $hasError])>
    <div class="row center-block">
        <label for="id_url" class="col-md-3 control-label"
               wire:target="extractCodeMeta,viewFlags.swPublished, @if($tripMode!=='defer') {{$url['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($url['wireModel'])) blur-red @else blur @endif ">Publication URL</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$url['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$url['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$url['codeMetaKey']}}" data-html="true"
                   data-content="{{$url['codeMetaInfo'].preg_replace('/\?/', $url['expanded-JSON-LD'] , $url['expanded'])
                                    .preg_replace('/\?/', $url['compacted-JSON-LD'] , $url['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" id="id_url" name="url"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$url['wireModel']}}" placeholder="{{$url['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$url['wireModel']" :crossMark="true"/>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$url['wireModel']"/>
</div>

<div id="div_id_license" style=" margin-bottom:25px" class="form-group">
    <div class="row center-block">
        <label for="id_license" class="col-md-3 control-label"
               wire:target="extractCodeMeta, {{$licenseInput['wireModel']}}, generateCodeMeta"
               wire:loading.class="blur">License</label>
        <div class="col-md-9 input-group">
            <div class="input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$licenseInput['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$licenseInput['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$licenseInput['codeMetaKey']}}" data-html="true"
                   data-content="{{$licenseInput['codeMetaInfo'].preg_replace('/\?/', $licenseInput['expanded-JSON-LD'] , $licenseInput['expanded'])
                                    .preg_replace('/\?/', $licenseInput['compacted-JSON-LD'] , $licenseInput['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text" class="input-md form-control" wire:model.debounce.200ms="{{$licenseInput['wireModel']}}"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease @else generateCodeMeta @endif"
                   wire:loading.class="noDirt"
                   wire:dblclick="$emit('listEvent')" id="id_license" name="license" placeholder="{{$licenseInput['placeHolder']}}"/>
            <div class="input-group-addon">
                <a tabindex="0" role="button"
                   wire:click="$emit('clearOut', '{{explode('.', $licenseInput['wireModel'])[1]}}')"><i class="glyphicon glyphicon-erase"></i></a>
            </div>
        </div>
    </div>
</div>

<div id="div_id_select_license" style="margin-top: -20px; margin-bottom:25px;"
     class="form-group @error($license['wireModel']) has-error @else hide @enderror" >
    <div class="row center-block">
        <label for="id_select_license" class="col-md-3 control-label" wire:target="extractCodeMeta" wire:loading.class="blur">
        </label>
        <div class="col-md-9 input-group">
            <div class="input-group-addon border">
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$license['info']}}">
                    <i class="glyphicon glyphicon-filter"></i></a>
            </div>
            <select class="form-control" id="id_select_license" name="select_license"
            wire:model="{{$license['wireModel']}}"
                    wire:target="@if($tripMode!=='defer') viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                    wire:change="getLicenseByIdentifier($event.target.value)" size="{{ min(count($licenses) + 1, 7) }}">

                <option value="" disabled selected hidden>Please type in a proper SPDX License</option>

                @foreach($licenses as $licenseInitials => $licenseFullName)

                    <option value="{{ $licenseInitials }}">{{ $licenseInitials.": ".$licenseFullName }}</option>

                @endforeach
            </select>
            <x-livewire.view-errors :wiredFormData="$license['wireModel']" :crossMark="true"/>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$license['wireModel']"/>

</div>

<hr class="style1"/>

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
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
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
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$keywords['wireModel']}}" placeholder="{{$keywords['placeHolder']}}"   />
        </div>
    </div>
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

            <textarea class="input-md form-control"  id="id_referencePublication" name="referencePublication"
                      wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                      wire:model.{{$tripMode}}="{{$referencePublication['wireModel']}}" placeholder="{{$referencePublication['placeHolder']}}">
            </textarea>

            <x-livewire.view-errors :wiredFormData="$referencePublication['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$referencePublication['wireModel']"/>
</div>

<hr class="style1"/>

<div id="div_id_releaseRadio" style=" margin-bottom:25px" class="form-group clearfix">
    <div class="row center-block">
        <div class="col-md-3 like-label"
             wire:target="extractCodeMeta, viewFlags.swRelease, generateCodeMeta"
             wire:loading.class="blur">Is this instance a Software Release?
        </div>
        <div class="col-md-9 input-group">

            <label class="radio-inline">
                <input type="radio" name="optionsRadios" id="id_releaseRadio_1" value="1"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                        wire:model="viewFlags.swRelease" @checked($viewFlags['swRelease'])> Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="optionsRadios" id="id_releaseRadio_0" value="0"
                       wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                       @else generateCodeMeta @endif" wire:loading.attr="disabled"
                       wire:model="viewFlags.swRelease" @checked(!$viewFlags['swRelease'])>No
            </label>

        </div>
    </div>
</div>

<div id="div_id_softwareVersion" style=" margin-bottom:25px" class="form-group">
    <div class="row center-block">
        <label for="id_softwareVersion" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$softwareVersion['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="blur">SW Version</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$softwareVersion['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$softwareVersion['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$softwareVersion['codeMetaKey']}}" data-html="true"
                   data-content="{{$softwareVersion['codeMetaInfo'].preg_replace('/\?/', $softwareVersion['expanded-JSON-LD'] , $SWName['expanded'])
                                    .preg_replace('/\?/', $softwareVersion['compacted-JSON-LD'] , $softwareVersion['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_softwareVersion" name="softwareVersion"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$softwareVersion['wireModel']}}" placeholder="{{$softwareVersion['placeHolder']}}"/>
        </div>
    </div>
</div>

<div id="div_id_version" style="margin-top: 10px; margin-bottom:25px;" @php($hasError = (bool)$errors->has($version['wireModel']))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRelease'], 'has-error' => $hasError]) >
    <div class="row center-block">
        <label for="id_version" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRelease, @if($tripMode!=='defer') {{$version['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($version['wireModel'])) blur-red @else blur @endif ">Version Number</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$version['info']}}"> <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$version['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$version['codeMetaKey']}}" data-html="true"
                   data-content="{{$version['codeMetaInfo'].preg_replace('/\?/', $version['expanded-JSON-LD'] , $version['expanded'])
                                    .preg_replace('/\?/', $version['compacted-JSON-LD'] , $version['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_version" name="version"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$version['wireModel']}}" placeholder="{{$version['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$version['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$version['wireModel']"/>
</div>

<div id="div_id_hasPart" style=" margin-bottom:25px" class="form-group @error($hasPart['wireModel']) has-error @enderror" >
    <div class="row center-block">
        <label for="id_hasPart" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$hasPart['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($hasPart['wireModel'])) blur-red @else blur @endif ">Has part</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$hasPart['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>
            <div class=" input-group-addon border" wire:key="popover.{{$hasPart['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$hasPart['codeMetaKey']}}" data-html="true"
                   data-content="{{$hasPart['codeMetaInfo'].preg_replace('/\?/', $hasPart['expanded-JSON-LD'] , $hasPart['expanded'])
                                    .preg_replace('/\?/', $hasPart['compacted-JSON-LD'] , $hasPart['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_hasPart" name="hasPart"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$hasPart['wireModel']}}" placeholder="{{$hasPart['placeHolder']}}"/>

            <x-livewire.view-errors :wiredFormData="$hasPart['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$hasPart['wireModel']"/>
</div>

<div id="div_id_isPartOf" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has('formData.isPartOf'))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRelease'], 'has-error' => $hasError]) >
    <div class="row center-block">
        <label for="id_isPartOf" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRelease, @if($tripMode!=='defer') {{$isPartOf['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($isPartOf['wireModel'])) blur-red @else blur @endif ">Is part of</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$isPartOf['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>
            <div class=" input-group-addon border" wire:key="popover.{{$isPartOf['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$isPartOf['codeMetaKey']}}" data-html="true"
                   data-content="{{$isPartOf['codeMetaInfo'].preg_replace('/\?/', $isPartOf['expanded-JSON-LD'] , $isPartOf['expanded'])
                                    .preg_replace('/\?/', $isPartOf['compacted-JSON-LD'] , $isPartOf['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="text"  class="input-md form-control" id="id_isPartOf" name="isPartOf"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$isPartOf['wireModel']}}" placeholder="{{$isPartOf['placeHolder']}}"   />

            <x-livewire.view-errors :wiredFormData="$isPartOf['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$isPartOf['wireModel']"/>
</div>

<div id="div_id_dateModified" style=" margin-bottom:25px" class="form-group @error($dateModified['wireModel']) has-error @enderror">
    <div class="row center-block">
        <label for="id_dateModified" class="col-md-3 control-label"
               wire:target="extractCodeMeta, @if($tripMode!=='defer') {{$dateModified['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($dateModified['wireModel'])) blur-red @else blur @endif ">Release date</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$dateModified['info']}}">
                    <i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$dateModified['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$dateModified['codeMetaKey']}}" data-html="true"
                   data-content="{{$dateModified['codeMetaInfo'].preg_replace('/\?/', $dateModified['expanded-JSON-LD'] , $dateModified['expanded'])
                                    .preg_replace('/\?/', $dateModified['compacted-JSON-LD'] , $dateModified['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <input type="date" class="input-md form-control" id="id_dateModified" name="dateModified"
                   wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                   wire:model.{{$tripMode}}="{{$dateModified['wireModel']}}"/>

            <x-livewire.view-errors :wiredFormData="$dateModified['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$dateModified['wireModel']"/>
</div>

<div id="div_id_releaseNotes" style=" margin-bottom:25px" @php($hasError = (bool)$errors->has('formData.releaseNotes'))
    @class(['form-group','fadeIn', 'hide' => !$viewFlags['swRelease'], 'has-error' => $hasError]) >
    <div class="row center-block">
        <label for="id_releaseNotes" class="col-md-3 control-label"
               wire:target="extractCodeMeta, viewFlags.swRelease, @if($tripMode!=='defer') {{$releaseNotes['wireModel']}} @else generateCodeMeta @endif"
               wire:loading.class="@if($errors->has($releaseNotes['wireModel'])) blur-red @else blur @endif ">Release notes</label>
        <div class="col-md-9 input-group">
            <div class=" input-group-addon border" >
                <a tabindex="0"   role="button" data-toggle="popover" title="Info" data-html="true" data-placement="bottom"
                   data-content="{{$releaseNotes['info']}}"><i class="glyphicon glyphicon-info-sign"></i></a>
            </div>

            <div class=" input-group-addon border" wire:key="popover.{{$releaseNotes['codeMetaKey'].$time}}">

                <a tabindex="0"   role="button" data-toggle="popover" title="{{$releaseNotes['codeMetaKey']}}" data-html="true"
                   data-content="{{$releaseNotes['codeMetaInfo'].preg_replace('/\?/', $releaseNotes['expanded-JSON-LD'] , $releaseNotes['expanded'])
                                    .preg_replace('/\?/', $releaseNotes['compacted-JSON-LD'] , $releaseNotes['compacted'])}}">
                    <i class="glyphicon thin glyphicon-console"></i>
                </a>
            </div>

            <textarea class="input-md form-control" name="releaseNotes" id="id_releaseNotes"
                      wire:target="@if($tripMode!=='defer') formData, viewFlags.swPublished, viewFlags.swRelease
                                    @else generateCodeMeta @endif" wire:loading.class="noDirt"
                      wire:model.{{$tripMode}}="{{$releaseNotes['wireModel']}}" placeholder="{{$releaseNotes['placeHolder']}}">
                </textarea>

            <x-livewire.view-errors :wiredFormData="$releaseNotes['wireModel']" :crossMark="true"/>
        </div>
    </div>
    <x-livewire.view-errors :wiredFormData="$releaseNotes['wireModel']"/>
</div>

