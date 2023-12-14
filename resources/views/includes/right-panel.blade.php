<div id ="right_panel_box" class="bodyShadow-right-panel {{ $viewFlags['jsonPanel'] ? 'panel-success' : 'panel-danger'}}" style=" margin-top:50px; border: none;">

    @include('includes.right-panel-heading', $viewFlags)

    <div class="panel-body" >

        <div class="tab-content">

            <div role="tabpanel" id="json" @class(['tab-pane', 'fadeIn', 'active' => $viewFlags['jsonActive']])  >
                <div wire:key="jsonMode.{{$time}}" style="float:right" >
                    <div  class="btn-group btn-group-xs" role="group" wire:loading.class="removePointer" wire:target="activateJSONMode, codeMetaImport">
                        <span @class(['btn','-btn', '-btn-effect-toggle-mode', 'active' => $viewFlags['jsonReadOnly']])

                              @style(['padding: 1px 5px', 'background-image: linear-gradient(to bottom, #ffdf6a, #fad768, #f5d067, #f0c865, #ebc164);
                                       text-shadow: 0px 0px 1px rgba(0, 0, 0, 0.23);
                                       color: #342B0C'
                                            => !$viewFlags['jsonReadOnly'],
                                       'background: linear-gradient(0deg,#336685 0,#2aa6e5); color: #fff'
                                            => $viewFlags['jsonReadOnly']])
                               wire:click="activateJSONMode(true)"
                              tabindex="0" role="button" data-toggle="modePopover" title="CodeMeta.js Mode" data-placement="bottom"
                              data-content="<b>Export mode</b>: Fill in the form to generate <code>codeMeta.json</code> in the textarea below. <br><br>Use either the
                                <span class='btn btn-xs btn-info -btn -btn-effect'>Get JSON</span> button or a round-trip selection mode above.">Export
                        </span>

                        <span @class(['btn', '-btn', '-btn-effect-toggle-mode', 'active' => !$viewFlags['jsonReadOnly']])

                              @style(['padding: 1px 5px', 'background-image: linear-gradient(to bottom, #ffdf6a, #fad768, #f5d067, #f0c865, #ebc164);
                                      text-shadow: 0px 0px 1px rgba(0, 0, 0, 0.23);
                                      color: #342B0C'
                                            => $viewFlags['jsonReadOnly'],
                                      'background: linear-gradient(0deg,#336685 0,#2aa6e5); color: #fff'
                                            => !$viewFlags['jsonReadOnly']])
                               wire:click="activateJSONMode(false)"
                              tabindex="0" role="button" data-toggle="modePopover" title="CodeMeta.js Mode" data-placement="bottom"
                              data-content="<b>Import mode</b>: Write a <code>codeMeta.json</code> in the textarea below to scatter its key-value pairs to the form.
                              <br><br>Use the <span class='btn btn-xs btn-info -btn -btn-effect'>Scatter JSON</span> button to import it to the form.
                              <br><br>Note: <code>JSON-LD</code> structure is not yet fully implemented. Currently, the Export mode structure only can be imported back.">Import
                        </span>
                    </div>
                </div>

                @if($viewFlags['jsonReadOnly'])

                    <div class="@error('codeMetaJSON') has-error @enderror" id="id_exportMode" >
                        <div class="row" style="border: none" wire:key="codeMetaJSON.{{$time}}">
                            <div class="col-md-5">
                                <label for="id_codeMetaJSON" class="control-label" style="letter-spacing: 1px;"
                                       wire:target="generateCodeMeta, activatePill, download, copy, @if($viewFlags['tripMode']==='lazy') formData @endif"
                                       wire:loading.class="@if($errors->has('fetchError')) blur-red @else blur @endif ">
                                        <span style="border: none">
                                            <a tabindex="0" role="button" data-toggle="rightPopover" title="{{$JSonLDTitle}}" data-html="true" data-placement="right"
                                               data-content="{{$JSonLDInfo}}">
                                                <i class="glyphicon thin glyphicon-info-sign"></i>
                                            </a>
                                            <span style="padding-left: 5px">CodeMeta.json</span>
                                        </span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <div class="hidden transit-message"
                                     wire:target="@if($viewFlags['tripMode']==='lazy') formData @else generateCodeMeta @endif"
                                     wire:loading.class.remove="hidden">
                                    <span>@if($viewFlags['tripMode']==='lazy') Updating @else Fetching @endif..</span>
                                </div>
                                <button @class(["btn", "btn-xs", "btn-info", "-btn", "-btn-effect", "hide"=> $viewFlags['tripMode'] !== 'defer'])
                                        wire:click ="generateCodeMeta(true)"
                                        wire:target="generateCodeMeta" wire:loading.class="hidden">
                                    <span class="glyphicon glyphicon-random" aria-hidden="true" style="padding-right: 5px"></span>Get JSON</button>
                            </div>
                        </div>
                        <textarea class="form-control" rows="{{ isset($codeMetaJSON) ? substr_count($codeMetaJSON, "\n") + 1 : 3 }}" wire:model="codeMetaJSON"
                                  id="id_codeMetaJSON" name="codeMetaJSON" placeholder="Fill in the form to generate in here codemeta.json" readonly>{{$codeMetaJSON}}</textarea>
                    </div>
                @else
                    <div class="@error('codeMetaImport') has-error @enderror">
                        <div class="row" style="border: none">
                            <div class="col-md-5">
                                <label for="id_codeMetaImport" class="control-label" style="letter-spacing: 1px;"
                                       wire:target="extractCodeMeta, activatePill, download, copy"
                                       wire:loading.class="@if($errors->has('scatterError')) blur-red @else blur @endif ">
                                        <div style="border: none">
                                            <a tabindex="0" role="button" data-toggle="rightPopover" title="{{$JSonLDTitle}}" data-html="true" data-placement="right"
                                               data-content="{{$JSonLDInfo}}">
                                                <i class="glyphicon thin glyphicon-info-sign"></i>
                                            </a>
                                            <span style="padding-left: 5px">CodeMeta.json</span>
                                        </div>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <span style="display: none"></span>
                                <div class="hidden transit-message" wire:target="extractCodeMeta" wire:loading.class.remove="hidden">Scattering..</div>
                                <button class = "btn btn-xs btn-info -btn -btn-effect"
                                        wire:click="extractCodeMeta()" wire:target="extractCodeMeta" wire:loading.class="hidden">
                                    <span class="glyphicon glyphicon-random" aria-hidden="true" style="padding-left: 5px; transform: rotateY(180deg);"></span>Scatter JSON</button>
                            </div>
                        </div>
                        <div style="border: none; padding-left: 10px">
                            @error('codeMetaImport')
                            <i class="glyphicon glyphicon-bell bell text-danger" style="padding: 0.25em;"></i>
                            @php
                                $messageSeperated = explode("\n", $message)
                            @endphp
                            @for ($i = 0; $i < count($messageSeperated); $i++)
                                <span class="-box-shadow fadeIn"  style="background-color: #f9f2f4; font-family: Consolas, sans-serif; color: #cb365c">
                                    {{ $messageSeperated[$i] }}
                                </span><br>
                            @endfor
                            <br>
                            @enderror
                        </div>
                        <div id="playCheck" class="hidden">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 50px;display: block; margin: 10px auto 0;">
                                <circle class="path circle mode" fill="none" stroke="#A8B400" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"></circle>
                                <polyline class="path check mode" fill="none" stroke="#A8B400" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10"
                                          points="100.2,40.2 51.5,88.8 29.8,67.5 "></polyline>
                            </svg>
                        </div>
                        <textarea class ="form-control" rows="{{ isset($codeMetaImport) ? substr_count($codeMetaImport, "\n") : 3 }}"
                                  wire:model.lazy="codeMetaImport" id="id_codeMetaImport" name="codeMetaImport"
                                  placeholder="Write in here to scatter codeMeta.json to form" >{{ $codeMetaImport }}</textarea>
                    </div>
                @endif
            </div>

            <x-livewire.right-panel-tab-content :tapFor="'swhXML'" :isActivated="$viewFlags['swhXMLActive'] === true" :isDisabled="true/*!(isset($codeMetaJSON)|isset($codeMetaImport))*/"
                                                :tripMode="$viewFlags['tripMode']" :textAreaInput="$swhXML"/>

            <x-livewire.right-panel-tab-content :tapFor="'bibTex'" :isActivated="$viewFlags['bibTexActive'] === true" :isDisabled="false/*!(isset($codeMetaJSON)|isset($codeMetaImport))*/"
                                                :tripMode="$viewFlags['tripMode']" :textAreaInput="$bibTex"/>

            <x-livewire.right-panel-tab-content :tapFor="'bibLaTex'" :isActivated="$viewFlags['bibLaTexActive'] === true" :isDisabled="false/*!(isset($codeMetaJSON)|isset($codeMetaImport))*/"
                                                :tripMode="$viewFlags['tripMode']" :textAreaInput="$bibLaTex"/>

            <x-livewire.right-panel-tab-content :tapFor="'dataCite'" :isActivated="$viewFlags['dataCiteActive'] === true" :isDisabled="false/*!(isset($codeMetaJSON)|isset($codeMetaImport))*/"
                                                :tripMode="$viewFlags['tripMode']" :textAreaInput="$dataCite"/>

            <x-livewire.right-panel-tab-content :tapFor="'github'" :isActivated="$viewFlags['githubActive'] === true" :isDisabled="true"
                                                :tripMode="$viewFlags['tripMode']" :textAreaInput="$github"/>

            <x-livewire.right-panel-tab-content :tapFor="'zenodo'" :isActivated="$viewFlags['zenodoActive'] === true" :isDisabled="true"
                                                :tripMode="$viewFlags['tripMode']" :textAreaInput="$zenodo"/>

        </div>
    </div>

    @include('includes.right-panel-footer', $viewFlags, [
        'codeMetaJSON' => $codeMetaJSON, 'codeMetaImport' => $codeMetaImport,
        'swhXML' => $swhXML, 'bibTex'   => $bibTex, 'bibLaTex' => $bibLaTex,
        'dataCite' => $dataCite, 'github'  => $github, 'zenodo'  => $zenodo ] )

</div>

