
<h4 style="text-align:center; margin-bottom: 25px;text-shadow: 0 2px 6px rgb(0 0 0 / 15%);">SW {{ucfirst($personType)}}s</h4>

@for ($person = 0; $person < $personNumber; $person++)

    <div class="centeredPerson" id="div_h5_{{$personType}}_{{$person}}">
        <h5>{{ucfirst($personType)}} {{$person+1}}</h5>
    </div>

    <div class="row fadeIn center-block"  style=" margin-bottom:5px" id="row_1_{{$personType}}_{{$person}}">

        <div wire:key="{{$personType}}_{{ $person }}_givenName" id="div_id_{{ $personType.$person }}_givenName"
             class="form-group col-md-6 @error($wirePerson.$person.$givenName['inWireModel']) has-error @enderror">

            <div>
                <label for="id_{{ $personType.$person }}_givenName" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wirePerson.$person.$givenName['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wirePerson.$person.$givenName["inWireModel"])) blur-red @else blur @endif ">Given Name
                </label>
                <div class="input-group" wire:key="popover._{{$personType}}_{{$person.$time}}_givenName">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/', $personType, $givenName['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$givenName['codeMetaKey']}}" data-html="true"
                           @if($personType !== 'author')
                               data-content="{{preg_replace('/\?/',$personType, $givenName['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', function() use($givenName, $personType){
                                                   return preg_replace('/\?/', $personType, $givenName['expanded-JSON-LD-person']);
                                               }, $givenName['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', $personType, $givenName['compacted-JSON-LD-person']), $givenName['compacted-person'])
                                               }}"
                            @else
                               data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $givenName['codeMetaInfo'])
                                        .preg_replace('/\?/', $givenName['expanded-JSON-LD-author'] , $givenName['expanded-author'])
                                        .preg_replace('/\?/', $givenName['compacted-JSON-LD-author'] , $givenName['compacted-author'])}}"
                            @endif
                           >
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_{{ $personType.$person }}_givenName" name="{{ $personType.$person }}_givenName"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$loopTripMode}}="{{$wirePerson.$person.$givenName["inWireModel"]}}" placeholder="{{$givenName['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wirePerson.$person.$givenName['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

        <div wire:key="{{$personType}}_{{ $person }}_familyName" id="div_id_{{ $personType.$person }}_familyName"
             class="form-group col-md-6 @error($wirePerson.$person.$familyName['inWireModel']) has-error @enderror">

            <div>
                <label for="id_{{ $personType.$person }}_familyName" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wirePerson.$person.$familyName['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wirePerson.$person.$familyName['inWireModel'])) blur-red @else blur @endif ">Family Name
                </label>
                <div class="input-group" wire:key="popover._{{$personType}}_{{$person.$time}}_familyName">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/', $personType, $familyName['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$familyName['codeMetaKey']}}" data-html="true"
                           @if($personType !=='author')
                               data-content="{{preg_replace('/\?/', $personType, $familyName['codeMetaInfo'])
                                             .preg_replace('/\?/', $personType , preg_replace('/\?/', $familyName['expanded-JSON-LD-person'], $familyName['expanded-person']))
                                             .preg_replace('/\?/', $personType , preg_replace('/\?/', $familyName['compacted-JSON-LD-person'], $familyName['compacted-person']))
                                             }}"
                           @else
                               data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $familyName['codeMetaInfo'])
                                        .preg_replace('/\?/', $familyName['expanded-JSON-LD-author'] , $familyName['expanded-author'])
                                        .preg_replace('/\?/', $familyName['compacted-JSON-LD-author'] , $familyName['compacted-author'])}}"
                           @endif
                           >
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_{{ $personType.$person }}_familyName" name="{{ $personType.$person }}_familyName"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$loopTripMode}}="{{$wirePerson.$person.$familyName['inWireModel']}}" placeholder="{{$familyName['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wirePerson.$person.$familyName['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

    </div>

    <x-livewire.view-errors :wiredFormData="[$wirePerson.$person.$givenName['inWireModel'], $wirePerson.$person.$familyName['inWireModel']]" :errorArray="true"/>

    <div class="row fadeIn center-block" style=" margin-bottom:5px" id="row_2_{{$personType}}_{{$person}}">

        <div wire:key="{{$personType}}_{{ $person }}_email" id="div_id_{{ $personType.$person }}_email"
             class="form-group col-md-6 @error($wirePerson.$person.$email['inWireModel']) has-error @enderror">

            <div>
                <label for="id_{{ $personType.$person }}_email" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wirePerson.$person.$email['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wirePerson.$person.$email['inWireModel'])) blur-red @else blur @endif ">Email
                </label>
                <div class="input-group" wire:key="popover._{{$personType}}_{{$person.$time}}_email">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/', $personType, $email['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$email['codeMetaKey']}}" data-html="true"
                           @if($personType !== 'author')
                               data-content="{{preg_replace('/\?/',$personType, $email['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', $personType, $email['expanded-JSON-LD-person']), $email['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', $personType, $email['compacted-JSON-LD-person']), $email['compacted-person'])
                                               }}"
                           @else
                               data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $email['codeMetaInfo'])
                                        .preg_replace('/\?/', $email['expanded-JSON-LD-author'] , $email['expanded-author'])
                                        .preg_replace('/\?/', $email['compacted-JSON-LD-author'] , $email['compacted-author'])}}"
                           @endif
                           >
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_{{ $personType.$person }}_email" name="{{ $personType.$person }}_email"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$loopTripMode}}="{{$wirePerson.$person.$email['inWireModel']}}" placeholder="{{$email['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wirePerson.$person.$email['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>

        <div wire:key="{{$personType}}_{{ $person }}_@id" id="div_id_{{ $personType.$person }}_@id"
             class="form-group col-md-6 @error($wirePerson.$person.$personID['inWireModel']) has-error @enderror">

            <div>
                <label for="id_{{ $personType.$person }}_@id" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wirePerson.$person.$personID['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wirePerson.$person.$personID['inWireModel'])) blur-red @else blur @endif ">URI
                </label>
                <div class="input-group" wire:key="popover._{{$personType}}_{{$person.$time}}_@id">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/', $personType, $personID['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$personID['codeMetaKey']}}" data-html="true"
                           @if($personType !== 'author')
                               data-content="{{preg_replace('/\?/',$personType, $personID['codeMetaInfo'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', $personType, $personID['expanded-JSON-LD-person']), $personID['expanded-person'])
                                               .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', $personType, $personID['compacted-JSON-LD-person']), $personID['compacted-person'])
                                               }}"
                           @else
                               data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $personID['codeMetaInfo'])
                                        .preg_replace('/\?/', $personID['expanded-JSON-LD-author'] , $personID['expanded-author'])
                                        .preg_replace('/\?/', $personID['compacted-JSON-LD-author'] , $personID['compacted-author'])}}"
                           @endif
                           >
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text" id="id_{{ $personType.$person }}_@id" name="{{ $personType.$person }}_@id" class="input-md form-control"
                           wire:model.{{$loopTripMode}}="{{$wirePerson.$person.$personID['inWireModel']}}"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt" placeholder="{{$personID['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wirePerson.$person.$personID['inWireModel']" :crossMark="true"/>
                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="[$wirePerson.$person.$email['inWireModel'], $wirePerson.$person.$personID['inWireModel']]" :errorArray="true"/>

    <div class="row fadeIn center-block" id="row_3_{{$personType}}_{{$person}}">
        <div wire:key="{{$personType}}_{{ $person }}_affiliation" id="div_id_{{ $personType.$person }}_affiliation"
             class="form-group col-md-12 affiliation @error($wirePerson.$person.$affiliation["inWireModel"]) has-error @enderror">

            <div>
                <label for="id_{{ $personType.$person }}_affiliation" class="control-label"
                       wire:target="extractCodeMeta, @if($tripMode!=='defer') {{ $wirePerson.$person.$affiliation['inWireModel'] }} @else generateCodeMeta @endif"
                       wire:loading.class="@if($errors->has($wirePerson.$person.$affiliation["inWireModel"])) blur-red @else blur @endif ">Affiliation</label>

                <div class="input-group" wire:key="popover._{{$personType}}_{{$person.$time}}_affiliation">
                    <div class=" input-group-addon border" >
                        <a tabindex="0"  role="button" data-toggle="popover" title="Info" data-html="true"
                           data-content="{{preg_replace('/Person/', $personType, $affiliation['info'])}}"><i class="glyphicon glyphicon-info-sign"></i></a>
                    </div>

                    <div class=" input-group-addon border">
                        <a tabindex="0"  role="button" data-toggle="popover" title="{{$affiliation['codeMetaKey']}}" data-html="true"
                           @if($personType !=='author')
                               data-content="{{
                                             preg_replace('/\?/', $personType, $affiliation['codeMetaInfo'])
                                            .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', $personType, $affiliation['expanded-JSON-LD-person']), $affiliation['expanded-person'])
                                            .preg_replace_callback('/\?/', fn()=>preg_replace('/\?/', $personType, $affiliation['compacted-JSON-LD-person']), $affiliation['compacted-person'])
                                            }}"
                           @else
                               data-content="{{preg_replace_callback_array([ '/\?/' => fn()=> 'author', '/ \|\| Object/' => fn() =>''], $affiliation['codeMetaInfo'])
                                        .preg_replace('/\?/', $affiliation['expanded-JSON-LD-author'] , $affiliation['expanded-author'])
                                        .preg_replace('/\?/', $affiliation['compacted-JSON-LD-author'] , $affiliation['compacted-author'])}}"
                           @endif
                           >
                            <i class="glyphicon thin glyphicon-console"></i>
                        </a>
                    </div>

                    <input type="text"  class="input-md form-control" id="id_{{ $personType.$person }}_affiliation" name="{{ $personType.$person }}_affiliation"
                           wire:target="@if($tripMode!=='defer') formData
                                            @else generateCodeMeta @endif" wire:loading.class="noDirt"
                           wire:model.{{$loopTripMode}}="{{$wirePerson.$person.$affiliation["inWireModel"]}}" placeholder="{{$affiliation['placeHolder']}}"/>

                    <x-livewire.view-errors :wiredFormData="$wirePerson.$person.$affiliation['inWireModel']" :crossMark="true"/>

                </div>
            </div>
        </div>
    </div>

    <x-livewire.view-errors :wiredFormData="$wirePerson.$person.$affiliation['inWireModel']" :errorArray="true"/>

    @switch($personType)
        @case('contributor')
        @case('maintainer')
            <x-livewire.person-deletions :personType="$personType" :personIdx="$person" />
            @if($person + 1 !== $personNumber)
                <hr class="style1"/>
            @endif
        @break
        @default
            <x-livewire.person-deletions :personType="$personType" :personIdx="$person" :authorNumber="$personNumber" />
            <hr class="style1"/>
    @endswitch

@endfor

