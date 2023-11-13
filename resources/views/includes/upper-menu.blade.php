<div class="row centered-content" style="text-align:center; border: none;">
    <div class="col-md-12">
        <span style="text-shadow: -1px 1px 3px rgb(0 0 0 / 25%);">Rendered @ <strong> {{$time}} </strong></span>
        <button class="btn btn-xs btn-success -btn -btn-effect-refresh" wire:click.prevent="$refresh" style="margin-left: 9px; padding-right: 7px; padding-left: 7px">Refresh</button>
        <span style="margin-left: 11px; text-shadow: -1px 1px 3px rgb(0 0 0 / 25%);">CodeMeta Generation Style:</span>

        <div wire:key="bt.{{$time}}" class="btn-group btn-group-xs btn-xs list-inline" style="margin-left: 9px;" role="group" wire:loading.class="removePointer" wire:target="viewFlags.tripMode">

            <button type="button" @class(['btn','-btn', '-btn-effect-toggle', 'active' => $tripMode === 'defer',])
            @style(['padding: 1px 5px', 'background-image: linear-gradient(to bottom, #ffdf6a, #fad768, #f5d067, #f0c865, #ebc164);
                     text-shadow: 0px 0px 1px rgba(0, 0, 0, 0.23);
                     color: #342B0C'
                          => !($tripMode === 'defer'),
                     'background: linear-gradient(0deg,#336685 0,#2aa6e5); color: #fff'
                          => $tripMode === 'defer'
                     ])
                    wire:click.prevent ="$set('viewFlags.tripMode', 'defer')"
                    tabindex="0" role="button" data-toggle="modePopover" title="LiveWire Mode" data-placement="bottom"
                    data-content="<b>Defer</b>: Generates <code>codeMeta.json</code> fields <i>manually</i> through the
                        <span class='btn btn-xs btn-info -btn -btn-effect'>Get JSON</span> button.">Manual
            </button>

            <button type="button" @class(['btn', '-btn', '-btn-effect-toggle', 'active' => $tripMode=== 'lazy',])
            @style(['padding: 1px 5px', 'background-image: linear-gradient(to bottom, #ffdf6a, #fad768, #f5d067, #f0c865, #ebc164);
                     text-shadow: 0px 0px 1px rgba(0, 0, 0, 0.23);
                     color: #342B0C'
                          => !($tripMode === 'lazy'),
                     'background: linear-gradient(0deg, #336685 0,#2aa6e5); color: #fff'
                          => $tripMode === 'lazy'
                     ])
                    wire:click.prevent ="$set('viewFlags.tripMode', 'lazy')"
                    tabindex="0" role="button" data-toggle="modePopover" title="LiveWire Mode" data-placement="bottom"
                    data-content="<b>Lazy</b>: Generates <code>codeMeta.json</code> fields <i>automatically</i> one after another.">Sequential
            </button>

            <button type="button" @class(['btn', '-btn', '-btn-effect-toggle', 'active' => $tripMode === 'poll.5000ms',])
            @style(['padding: 1px 5px', 'background-image: linear-gradient(to bottom, #ffdf6a, #fad768, #f5d067, #f0c865, #ebc164);
                     text-shadow: 0px 0px 1px rgba(0, 0, 0, 0.23);
                     color: #342B0C'
                          => !($tripMode === 'poll.5000ms'),
                     'background: linear-gradient(0deg, #336685 0,#2aa6e5); color: #fff'
                          => $tripMode === 'poll.5000ms'])
                    wire:click.prevent ="$emit('tripModeFromBlade', 'poll.5000ms')"
                    tabindex="0" role="button" data-toggle="modePopover" title="LiveWire Mode" data-placement="bottom"
                    data-content="<b>Poll</b>: Generates <code>codeMeta.json</code> fields <i>automatically</i> every 5 seconds.">Periodic
            </button>

            <button type="button" @class(['btn', '-btn', '-btn-effect-toggle', 'active' => $tripMode === 'debounce.200ms',])
            @style(['padding: 1px 5px', 'background-image: linear-gradient(to bottom, #ffdf6a, #fad768, #f5d067, #f0c865, #ebc164);
                     text-shadow: 0px 0px 1px rgba(0, 0, 0, 0.23);
                     color: #342B0C'
                          => !($tripMode === 'debounce.200ms'),
                     'background: linear-gradient(0deg, #336685 0,#2aa6e5); color: #fff'
                          => $tripMode === 'debounce.200ms'
                     ])
                    wire:click.prevent ="$set('viewFlags.tripMode', 'debounce.200ms')"
                    tabindex="0" role="button" data-toggle="modePopover" title="LiveWire Mode" data-placement="bottom"
                    data-content="<b>Debounce</b>: Generates <code>codeMeta.json</code> fields <i>automatically</i> in real-time (with delay of 200ms).">Live
            </button>
        </div>
    </div>
</div>
