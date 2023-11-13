<div>

    @if($viewFlags['readOnceError'])
        <x-livewire.header-notification :readOnceError="$readOnceError"/>
        @php return @endphp
    @endif

    <x-livewire.header-notification :offline="true"/>

    <div class="hidden" @if($viewFlags['tripMode']==='poll.5000ms') wire:{{ $viewFlags['tripMode']}} @endif = "generateCodeMeta"></div>

    <x-livewire.erase-modal/>

    <x-livewire.remove-author-modal/>

    @include('includes.upper-menu', ['time' => $time, 'tripMode' => $viewFlags['tripMode']])

    <x-session.beta.livewire-messages :time="$time"/>

    <div class="stepwizard centered-content" style="margin-top: 20px">
        @include('includes.step-wizard')
    </div>

    <div id="panels" style="display:flex; justify-content: center; column-gap: 50px; border: none; position:relative; width: 100%;">

        @include('includes.wizard.view-3-left-menu', ['viewPanel' => $viewPanel,
                                        'authorNumber' => $authorNumber,
                                        'contributorNumber' => $contributorNumber,
                                        'maintainerNumber' => $maintainerNumber
                                        ])

        <div wire:key="left_panel_{{$viewPanel}}" id="left_panel" @style(["border: none; flex: 0 790px;", "display: none" => isset($noValidations)])>
            <div class="bodyShadow" style=" margin-top:50px; border: none" id="left_panel_box">
                <div class="panel-heading headerCard">
                    <div class="panel-title" id="left-panel-title" style="text-shadow: -1px 1px 3px rgb(0 0 0 / 17%);">{{$panelNames[$viewPanel]}}
                        <span style="float:right; font-weight: bold; font-size: 85%;">
                                Step {{$viewPanel}}
                            </span>
                    </div>
                </div>
                <div class="panel-body container-fluid">
                    <form>

                        @csrf

                        @php
                            $view ='includes.wizard.view-'. $viewPanel;
                            $tripMode = $viewFlags['tripMode']==='poll.5000ms' ? 'defer' : $viewFlags['tripMode'];
                            $formTerms []= [ "tripMode" => $tripMode ];
                        @endphp


                        @include($view, $formTerms)

                    </form>
                </div>
                @include('includes.wizard.view-footers', ['viewPanel' => $viewPanel])
            </div>
        </div>

        <div wire:key="right_panel_{{$viewPanel}}" id="right_panel"  @style(["border:none; flex: 0 690px;", "display: none" => isset($noValidations)])>
            @include('includes.right-panel', $formTerms['codeMetaJSonLD'])
        </div>

        <div style="border:none; flex: 0 71px"></div>
    </div>

    @if(session()->has(['tripMode', 'validationErrors']))
        <div class="hidden" wire:init="throwAnySessionErrors"></div>
    @endif

</div>

