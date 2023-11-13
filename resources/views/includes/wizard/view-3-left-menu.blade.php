
@if($viewPanel===3)
    <div class="containerVertical" style="border:none; margin-top: 110px; position: sticky; top: 110px;
                /*justify-content:center;*/ /*margin-left: -85px;*/ /*position: fixed; left:90px ; top: 410px;*/ flex: 0 130px">

        <div class="containerVertical-column">
            <div>
                <button class="btn btn-xs btn-info -btn -btn-effect"
                        wire:click.prevent="$set('authorNumber', {{$authorNumber+1}})"
                        wire:loading.attr="disabled">Author
                    <span class="glyphicon glyphicon-plus" style="margin-left: 2px; font-family: Consolas, sans-serif; font-size: large"></span>
                    <span class="glyphicon glyphicon-plus" style="font-family: Consolas, sans-serif; font-size: large"></span>
                </button>
            </div>
            <div>
                <button class="btn btn-xs btn-info -btn -btn-effect"
                        wire:click.prevent="$set('contributorNumber', {{$contributorNumber+1}})"
                        wire:loading.attr="disabled">Contributor
                    <span class="glyphicon glyphicon-plus" style="margin-left: 2px; font-family: Consolas, sans-serif; font-size: large "></span>
                    <span class="glyphicon glyphicon-plus" style="font-family: Consolas, sans-serif; font-size: large"></span>
                </button>
            </div>
            <div>
                <button class="btn btn-xs btn-info -btn -btn-effect"
                        wire:click.prevent="$set('maintainerNumber', {{$maintainerNumber+1}})"
                        wire:loading.attr="disabled">Maintainer
                    <span class="glyphicon glyphicon-plus" style="margin-left: 2px; font-family: Consolas, sans-serif; font-size: large"></span>
                    <span class="glyphicon glyphicon-plus" style="font-family: Consolas, sans-serif; font-size: large"></span>
                </button>
            </div>
        </div>
    </div>
@else
    <div class="containerVertical" style="border:none; margin-top: 110px; position: sticky; top: 110px;
                /*justify-content:center;*/ /*margin-left: -85px;*/ /*position: fixed; left:90px ; top: 410px;*/ flex: 0 130px">
    </div>
@endif