
<h4 style="text-align:center; margin-bottom: 25px; text-shadow: 0 2px 6px rgb(0 0 0 / 15%);">SW Authors</h4>

@for ($author = 0; $author < $authorNumber; $author++)

    {{--@php($validateAuthor = "formData.author.".$author.".")--}}

    @php($wireAuthor = "formData.author.".$author)

    {{--<x-livewire.form-data-author"/>--}}     {{--todo: move to sub-components--}}

    {{--<h5 style="text-align:center; margin-bottom: 25px;text-shadow: 0 2px 6px rgb(0 0 0 / 15%);" id="div_h5_author_{{$author}}">Author {{$author+1}}</h5>--}}

    <div class="centeredPerson" id="div_h5_author_{{$author}}">
        <h5 >Author {{$author+1}}</h5>
    </div>

    <div class="row fadeIn center-block" style=" margin-bottom:5px; border: none" id="row_1_author_{{$author}}">

        <div wire:key="author_{{ $author }}_givenName" id="div_id_author{{ $author }}_givenName"
             class="form-group col-md-6 @error($wireAuthor.$givenName['inWireModel']) has-error @enderror " {{--style="border: none; padding-left: 15px; padding-right: 0;"--}}>

            <div>

                <label for="id_author{{ $author }}_givenName" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireAuthor.$givenName['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireAuthor.$givenName['inWireModel'])) blur-red @else blur @endif ">Given Name
                </label>
                <div class="input-group" wire:key="popover._author_{{$author.$time}}_givenName">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','author', $givenName['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">

                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$givenName['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $givenName['codeMetaInfo'])
                                        .preg_replace('/\?/', $givenName['expanded-JSON-LD-author'] , $givenName['expanded-author'])
                                        .preg_replace('/\?/', $givenName['compacted-JSON-LD-author'] , $givenName['compacted-author'])}}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_author{{ $author }}_givenName" name="author{{ $author }}_givenName"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{ $wireAuthor.$givenName['inWireModel'] }}" placeholder="{{$givenName['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireAuthor.$givenName['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

        <div wire:key="author_{{ $author }}_familyName" id="div_id_author{{ $author }}_familyName"
             class="form-group col-md-6 @error($wireAuthor.$familyName['inWireModel']) has-error @enderror" {{--style="border:none; padding-left: 15px; padding-right: 0;"--}}>

            <div>

                <label for="id_author{{ $author }}_familyName" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireAuthor.$familyName['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireAuthor.$familyName['inWireModel'])) blur-red @else blur @endif ">Family Name
                </label>
                <div class="input-group" wire:key="popover._author_{{$author.$time}}_familyName">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','author', $familyName['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">

                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$familyName['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $familyName['codeMetaInfo'])
                                        .preg_replace('/\?/', $familyName['expanded-JSON-LD-author'] , $familyName['expanded-author'])
                                        .preg_replace('/\?/', $familyName['compacted-JSON-LD-author'] , $familyName['compacted-author'])}}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_author{{ $author }}_familyName" name="author{{ $author }}_familyName"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireAuthor.$familyName['inWireModel']}}" placeholder="{{$familyName['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireAuthor.$familyName['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="[$wireAuthor.$givenName['inWireModel'], $wireAuthor.$familyName['inWireModel']]" :errorArray="true"/>

    <div class="row fadeIn center-block" style="margin-bottom: 5px; border: none" id="row_2_author_{{$author}}">

        <div wire:key="author_{{ $author }}_email" id="div_id_author{{ $author }}_email"
             class="form-group col-md-6 @error($wireAuthor.$email['inWireModel']) has-error @enderror">

            <div>
                <label for="id_author{{ $author }}_email" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireAuthor.$email['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireAuthor.$email['inWireModel'])) blur-red @else blur @endif ">Email
                </label>
                <div class="input-group" wire:key="popover._author_{{$author.$time}}_email">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','author', $email['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">

                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$email['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $email['codeMetaInfo'])
                                        .preg_replace('/\?/', $email['expanded-JSON-LD-author'] , $email['expanded-author'])
                                        .preg_replace('/\?/', $email['compacted-JSON-LD-author'] , $email['compacted-author'])}}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_author{{ $author }}_email" name="author{{ $author }}_email"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireAuthor.$email['inWireModel']}}" placeholder="{{$email['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireAuthor.$email['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

        <div wire:key="author_{{ $author }}_@id" id="div_id_author{{ $author }}_@id"
             class="form-group col-md-6 @error($wireAuthor.$personID['inWireModel']) has-error @enderror">

            <div>
                <label for="id_author{{ $author }}_@id" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireAuthor.$personID['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireAuthor.$personID['inWireModel'])) blur-red @else blur @endif ">URI
                </label>
                <div class="input-group" wire:key="popover._author_{{$author.$time}}_@id">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','author', $personID['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">

                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$personID['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $personID['codeMetaInfo'])
                                        .preg_replace('/\?/', $personID['expanded-JSON-LD-author'] , $personID['expanded-author'])
                                        .preg_replace('/\?/', $personID['compacted-JSON-LD-author'] , $personID['compacted-author'])}}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text" class="input-md form-control" id="id_author{{ $author }}_@id" name="author{{ $author }}_@id"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireAuthor.$personID['inWireModel']}}" placeholder="{{$personID['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireAuthor.$personID['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

    </div>

    <x-livewire.view-errors :wiredFormData="[$wireAuthor.$email['inWireModel'], $wireAuthor.$personID['inWireModel']]" :errorArray="true"/>

    <div class="row fadeIn center-block" id="row_3_author_{{$author}}">
        <div wire:key="author_{{ $author }}_affiliation" id="div_id_author{{ $author }}_affiliation"
             class="form-group col-md-12 affiliation @error($wireAuthor.$affiliation["inWireModel"]) has-error @enderror">

            <div>
                <label for="id_author{{ $author }}_affiliation" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireAuthor.$affiliation['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireAuthor.$affiliation["inWireModel"])) blur-red @else blur @endif ">Affiliation
                </label>
                <div class="input-group" wire:key="popover._author_{{$author.$time}}_affiliation">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','author', $affiliation['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">

                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$affiliation['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $affiliation['codeMetaInfo'])
                                        .preg_replace('/\?/', $affiliation['expanded-JSON-LD-author'] , $affiliation['expanded-author'])
                                        .preg_replace('/\?/', $affiliation['compacted-JSON-LD-author'] , $affiliation['compacted-author'])}}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>


                    <input type="text"  class="input-md form-control" id="id_author{{ $author }}_affiliation" name="author{{ $author }}_affiliation"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireAuthor.$affiliation["inWireModel"]}}" placeholder="{{$affiliation['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireAuthor.$affiliation['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$wireAuthor.$affiliation['inWireModel']" :errorArray="true"/>

    <x-livewire.person-deletions :personType="'author'" :personIdx="$author" :authorNumber="$authorNumber"/>

    <hr class="style1"/>

@endfor

<h4 style="text-align:center; margin-bottom: 25px;text-shadow: 0 2px 6px rgb(0 0 0 / 15%);">SW Contributors</h4>

@for ($contributor = 0; $contributor < $contributorNumber; $contributor++)

    {{--@php($validateContributor = "formData.contributor.".$contributor.".")--}}

    @php($wireContributor = "formData.contributor.".$contributor)

    {{--<h5 style="text-align:center; margin-bottom: 25px;text-shadow: 0 2px 6px rgb(0 0 0 / 15%);" id="div_h5_contributor_{{$contributor}}">Contributor {{$contributor+1}}</h5>--}}

    <div class="centeredPerson" id="div_h5_contributor_{{$contributor}}">
        <h5>Contributor {{$contributor+1}}</h5>
    </div>

    <div class="row fadeIn center-block"  style=" margin-bottom:5px" id="row_1_contributor_{{$contributor}}">

        <div wire:key="contributor_{{ $contributor }}_givenName" id="div_id_contributor{{ $contributor }}_givenName"
             class="form-group col-md-6 @error($wireContributor.$givenName['inWireModel']) has-error @enderror">

            <div>
                <label for="id_contributor{{ $contributor }}_givenName" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireContributor.$givenName['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireContributor.$givenName["inWireModel"])) blur-red @else blur @endif ">Given Name
                </label>
                <div class="input-group" wire:key="popover._contributor_{{$contributor.$time}}_givenName">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','contributor', $givenName['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$givenName['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace('/\?/','contributor', $givenName['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', function() use($givenName){
                                                   return preg_replace('/\?/', 'contributor', $givenName['expanded-JSON-LD-person']);
                                               }, $givenName['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'contributor', $givenName['compacted-JSON-LD-person']), $givenName['compacted-person'])
                                               }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_contributor{{ $contributor }}_givenName" name="contributor{{ $contributor }}_givenName"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireContributor.$givenName["inWireModel"]}}" placeholder="{{$givenName['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireContributor.$givenName['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

        <div wire:key="contributor_{{ $contributor }}_familyName" id="div_id_contributor{{ $contributor }}_familyName"
             class="form-group col-md-6 @error($wireContributor.$familyName['inWireModel']) has-error @enderror">

            <div>
                <label for="id_contributor{{ $contributor }}_familyName" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireContributor.$familyName['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireContributor.$familyName['inWireModel'])) blur-red @else blur @endif ">Family Name
                </label>
                <div class="input-group" wire:key="popover._contributor_{{$contributor.$time}}_familyName">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','contributor', $familyName['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$familyName['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace('/\?/','contributor', $familyName['codeMetaInfo'])
                                             .preg_replace('/\?/', 'contributor' , preg_replace('/\?/', $familyName['expanded-JSON-LD-person'], $familyName['expanded-person']))
                                             .preg_replace('/\?/', 'contributor' , preg_replace('/\?/', $familyName['compacted-JSON-LD-person'], $familyName['compacted-person']))
                                             }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_contributor{{ $contributor }}_familyName" name="contributor{{ $contributor }}_familyName"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireContributor.$familyName['inWireModel']}}" placeholder="{{$familyName['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireContributor.$familyName['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

    </div>

    <x-livewire.view-errors :wiredFormData="[$wireContributor.$givenName['inWireModel'], $wireContributor.$familyName['inWireModel']]" :errorArray="true"/>

    <div class="row fadeIn center-block" style=" margin-bottom:5px" id="row_2_contributor_{{$contributor}}">

        <div wire:key="contributor_{{ $contributor }}_email" id="div_id_contributor{{ $contributor }}_email"
             class="form-group col-md-6 @error($wireContributor.$email['inWireModel']) has-error @enderror">

            <div>
                <label for="id_contributor{{ $contributor }}_email" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireContributor.$email['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireContributor.$email['inWireModel'])) blur-red @else blur @endif ">Email
                </label>
                <div class="input-group" wire:key="popover._contributor_{{$contributor.$time}}_email">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','contributor', $email['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$email['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace('/\?/','contributor', $email['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'contributor', $email['expanded-JSON-LD-person']), $email['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'contributor', $email['compacted-JSON-LD-person']), $email['compacted-person'])
                                               }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_contributor{{ $contributor }}_email" name="contributor{{ $contributor }}_email"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireContributor.$email['inWireModel']}}" placeholder="{{$email['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireContributor.$email['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

        <div wire:key="contributor_{{ $contributor }}_@id" id="div_id_contributor{{ $contributor }}_@id"
             class="form-group col-md-6 @error($wireContributor.$personID['inWireModel']) has-error @enderror">

            <div>
                <label for="id_contributor{{ $contributor }}_@id" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireContributor.$personID['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireContributor.$personID['inWireModel'])) blur-red @else blur @endif ">URI
                </label>
                <div class="input-group" wire:key="popover._contributor_{{$contributor.$time}}_@id">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','contributor', $personID['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$personID['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace('/\?/','contributor', $personID['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'contributor', $personID['expanded-JSON-LD-person']), $personID['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'contributor', $personID['compacted-JSON-LD-person']), $personID['compacted-person'])
                                               }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text" id="id_contributor{{ $contributor }}_@id" name="contributor{{ $contributor }}_@id" class="input-md form-control"
                           wire:model.{{$tripMode}}="{{$wireContributor.$personID['inWireModel']}}"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt" placeholder="{{$personID['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireContributor.$personID['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="[$wireContributor.$email['inWireModel'], $wireContributor.$personID['inWireModel']]" :errorArray="true"/>

    <div class="row fadeIn center-block" id="row_3_contributor_{{$contributor}}">
        <div wire:key="contributor_{{ $contributor }}_affiliation" id="div_id_contributor{{ $contributor }}_affiliation"
             class="form-group col-md-12 affiliation @error($wireContributor.$affiliation["inWireModel"]) has-error @enderror">

            <div>
                <label for="id_contributor{{ $contributor }}_affiliation" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireContributor.$affiliation['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireContributor.$affiliation["inWireModel"])) blur-red @else blur @endif ">Affiliation</label>

                <div class="input-group" wire:key="popover._contributor_{{$contributor.$time}}_affiliation">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','contributor', $affiliation['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$affiliation['codeMetaKey']}}" data-html="true"
                           data-content="{{
                                             preg_replace('/\?/','contributor', $affiliation['codeMetaInfo'])
                                            .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'contributor', $affiliation['expanded-JSON-LD-person']), $affiliation['expanded-person'])
                                            .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'contributor', $affiliation['compacted-JSON-LD-person']), $affiliation['compacted-person'])
                                            }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_contributor{{ $contributor }}_affiliation" name="contributor{{ $contributor }}_affiliation"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireContributor.$affiliation["inWireModel"]}}" placeholder="{{$affiliation['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireContributor.$affiliation['inWireModel']" :crossMark="true"/>

                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$wireContributor.$affiliation['inWireModel']" :errorArray="true"/>

    <x-livewire.person-deletions :personType="'contributor'" :personIdx="$contributor" />

    @if($contributor + 1 !== $contributorNumber)
        <hr class="style1"/>
    @endif

@endfor

<hr class="style1"/>

<h4 style="text-align:center; margin-bottom: 25px;text-shadow: 0 2px 6px rgb(0 0 0 / 15%);">SW Maintainers</h4>

@for ($maintainer = 0; $maintainer < $maintainerNumber; $maintainer++)

    {{--@php($validateMaintainer = "formData.maintainer.".$maintainer.".")--}}
    @php($wireMaintainer = "formData.maintainer.".$maintainer)

    {{--<h5 style="text-align:center; margin-bottom: 25px;text-shadow: 0 2px 6px rgb(0 0 0 / 15%);" id="div_h5_maintainer_{{$maintainer}}">Maintainer {{$maintainer+1}}</h5>--}}

    <div class="centeredPerson" id="div_h5_maintainer_{{$maintainer}}">
        <h5>Maintainer {{$maintainer+1}}</h5>
    </div>

    {{--<x-livewire.form-data-author key="{{ $key }}"/>--}}
    <div class="row fadeIn center-block" style=" margin-bottom:5px" id="row_1_maintainer_{{$maintainer}}">

        <div wire:key="maintainer_{{ $maintainer }}_givenName" id="div_id_maintainer{{ $maintainer }}_givenName"
             class="form-group col-md-6 @error($wireMaintainer.$givenName['inWireModel']) has-error @enderror">

            <div>
                <label for="id_maintainer{{ $maintainer }}_givenName" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireMaintainer.$givenName['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireMaintainer.$givenName['inWireModel'])) blur-red @else blur @endif ">Given Name
                </label>
                <div class="input-group" wire:key="popover._maintainer_{{$maintainer.$time}}_givenName">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','maintainer', $givenName['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$givenName['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace('/\?/','maintainer', $givenName['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $givenName['expanded-JSON-LD-person']), $givenName['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $givenName['compacted-JSON-LD-person']), $givenName['compacted-person'])
                                               }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_maintainer{{ $maintainer }}_givenName" name="maintainer{{ $maintainer }}_givenName"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireMaintainer.$givenName['inWireModel']}}"  placeholder="{{$givenName['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireMaintainer.$givenName['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

        <div wire:key="maintainer_{{ $maintainer }}_familyName" id="div_id_maintainer{{ $maintainer }}_familyName"
             class="form-group col-md-6 @error($wireMaintainer.$familyName['inWireModel']) has-error @enderror">

            <div>
                <label for="id_maintainer{{ $maintainer }}_familyName" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireMaintainer.$familyName['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireMaintainer.$familyName['inWireModel'])) blur-red @else blur @endif ">Family Name
                </label>

                <div class="input-group" wire:key="popover._maintainer_{{$maintainer.$time}}_familyName">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="CodeMeta Key: maintainer.familyName" data-html="true"
                           data-content="{{preg_replace('/Person/','maintainer', $familyName['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$familyName['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace('/\?/','maintainer', $familyName['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $familyName['expanded-JSON-LD-person']), $familyName['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $familyName['compacted-JSON-LD-person']), $familyName['compacted-person'])
                                               }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_maintainer{{ $maintainer }}_familyName" name="maintainer{{ $maintainer }}_familyName"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireMaintainer.$familyName['inWireModel']}}" placeholder="{{$familyName['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireMaintainer.$familyName['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="[$wireMaintainer.$givenName['inWireModel'], $wireMaintainer.$familyName['inWireModel']]" :errorArray="true"/>

    <div class="row fadeIn center-block" style=" margin-bottom:5px" id="row_2_maintainer_{{$maintainer}}">

        <div wire:key="maintainer_{{ $maintainer }}_email" id="div_id_maintainer{{ $maintainer }}_email"
             class="form-group col-md-6 @error($wireMaintainer.$email['inWireModel']) has-error @enderror">

            <div>
                <label for="id_maintainer{{ $maintainer }}_email" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireMaintainer.$email['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireMaintainer.$email['inWireModel'])) blur-red @else blur @endif ">Email
                </label>

                <div class="input-group" wire:key="popover._maintainer_{{$maintainer.$time}}_email">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','maintainer', $email['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$email['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace('/\?/','maintainer', $email['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $email['expanded-JSON-LD-person']), $email['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $email['compacted-JSON-LD-person']), $email['compacted-person'])
                                               }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_maintainer{{ $maintainer }}_email" name="maintainer{{ $maintainer }}_email"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireMaintainer.$email['inWireModel']}}" placeholder="{{$email['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireMaintainer.$email['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

        <div wire:key="maintainer_{{ $maintainer }}_@id" id="div_id_maintainer{{ $maintainer }}_@id"
             class="form-group col-md-6 @error($wireMaintainer.$personID['inWireModel']) has-error @enderror">

            <div>

                <label for="id_maintainer{{ $maintainer }}_@id" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireMaintainer.$personID['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireMaintainer.$personID['inWireModel'])) blur-red @else blur @endif ">URI
                </label>

                <div class="input-group" wire:key="popover._maintainer_{{$maintainer.$time}}_@id">
                    <div class="input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/','maintainer', $personID['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$personID['codeMetaKey']}}" data-html="true"
                           data-content="{{preg_replace('/\?/','maintainer', $personID['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $personID['expanded-JSON-LD-person']), $personID['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $personID['compacted-JSON-LD-person']), $personID['compacted-person'])
                                               }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_maintainer{{ $maintainer }}_@id" name="maintainer{{ $maintainer }}_@id"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireMaintainer.$personID['inWireModel']}}" placeholder="{{$personID['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireMaintainer.$personID['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="[$wireMaintainer.$email['inWireModel'], $wireMaintainer.$personID['inWireModel']]" :errorArray="true"/>

    <div class="row fadeIn center-block" id="row_3_maintainer_{{$maintainer}}">
        <div wire:key="maintainer_{{ $maintainer }}_affiliation" id="div_id_maintainer{{ $maintainer }}_affiliation"
             class="form-group col-md-12 affiliation @error($wireMaintainer.$affiliation['inWireModel']) has-error @enderror">

            <div>
                <label for="id_maintainer{{ $maintainer }}_affiliation" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wireMaintainer.$affiliation['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wireMaintainer.$affiliation['inWireModel'])) blur-red @else blur @endif ">Affiliation
                </label>

                <div class="input-group" wire:key="popover._maintainer_{{$maintainer.$time}}_affiliation">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/', 'maintainer', $affiliation['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$affiliation['codeMetaKey']}}" data-html="true"
                           data-content="{{
                                             preg_replace('/\?/', 'maintainer', $affiliation['codeMetaInfo'])
                                            .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $affiliation['expanded-JSON-LD-person']), $affiliation['expanded-person'])
                                            .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', 'maintainer', $affiliation['compacted-JSON-LD-person']), $affiliation['compacted-person'])
                                            }}">
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_maintainer{{ $maintainer }}_affiliation" name="maintainer{{ $maintainer }}_affiliation"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$tripMode}}="{{$wireMaintainer.$affiliation['inWireModel']}}" placeholder="{{$affiliation['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wireMaintainer.$affiliation['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$wireMaintainer.$affiliation['inWireModel']" :errorArray="true"/>

    <x-livewire.person-deletions :personType="'maintainer'" :personIdx="$maintainer" />

    @if($maintainer + 1 !== $maintainerNumber)
        <hr class="style1"/>
    @endif
@endfor

<hr class="final">

