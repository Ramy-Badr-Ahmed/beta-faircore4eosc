<div class="row">
    <div style=" margin:auto; text-align:center; border: none" class="col-md-12">

            <span class="btn -btn-white clear" wire:click="resetIndex('{{$type}}', {{ $funderIdx }})"
                  wire:target="resetIndex('{{$type}}', {{ $funderIdx }})" wire:loading.attr="disabled">
                Clear out Funder {{ $funderNumber===1 ? "" : $funderIdx  + 1 }}
            </span>

        @if($swFunders)
            @if($funderIdx + 1 === $funderNumber)
                <button class="btn btn-xs -btn -btn-effect"
                        wire:click.prevent="$set('funderNumber', {{$funderNumber+1}})" wire:target="funderNumber" wire:loading.attr="disabled">Funder
                    <span class="glyphicon glyphicon-plus" style="margin-left: 2px; font-family: Consolas, sans-serif; font-size: large"></span>
                    <span class="glyphicon glyphicon-plus" style="font-family: Consolas, sans-serif; font-size: large"></span>
                </button>
            @endif
            <span class="btn -btn-white remove" wire:click="removeFunder({{ $funderIdx }})" wire:target="removeFunder({{ $funderIdx }})" wire:loading.attr="disabled">
                    Remove Funder {{$funderIdx+1}}
                </span>
        @endif

    </div>
</div>