
@switch($viewPanel)
    @case(1)
        <div class="panel-footer footerCard">

            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm pull-right -btn -btn-effect" wire:click="proceedTo(2)" type="button" wire:loading.attr="disabled" >
                        Next<span class="glyphicon glyphicon-menu-right" aria-hidden="true" style="font-size: smaller; font-weight: bolder; padding-left: 3px;"></span>
                    </button>
                </div>
            </div>
        </div>
    @break

    @case(2)
        <div class="panel-footer footerCard">
            <div class="row">
                <div class="col-md-5 ">
                    <button class="btn btn-info btn-sm pull-left -btn -btn-effect" type="button" wire:click="$set('viewPanel', 1)" wire:loading.attr="disabled">
                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true" style="font-size: smaller; font-weight: bolder; padding-right: 3px;"></span>Back
                    </button>
                </div>
                <div class="col-md-7 ">
                    <button class="btn btn-primary btn-sm pull-right -btn -btn-effect" type="button" wire:click="proceedTo(3)" wire:loading.attr="disabled">
                        Final Step<span class="glyphicon glyphicon-menu-right" aria-hidden="true" style="font-size: smaller; font-weight: bolder; padding-left: 3px;"></span>
                    </button>

                </div>
            </div>
        </div>
    @break

    @case(3)
        <div class="panel-footer footerCard">
            <div class="row">
                <div class="col-md-5 ">
                    <button class="btn btn-info btn-sm pull-left -btn -btn-effect" type="button" wire:click="$set('viewPanel', 2)" wire:loading.attr="disabled">
                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true" style="font-size: smaller; font-weight: bolder; padding-right: 3px;"></span>
                        Back
                    </button>
                </div>
                <div class="col-md-7 ">

            <span class="btn btn-danger btn-sm -btn -btn-effect-erase" name="Erase" id="id-erase" data-toggle="modal" data-target="#eraseModal">
                <span class="glyphicon glyphicon-erase" aria-hidden="true" style="padding-right: 5px;"></span>Erase
            </span>

                    <button class="btn btn-success btn-sm pull-right -btn -btn-effect-refresh" name="Submit" id="id-submit" wire:click.prevent="save()" wire:loading.attr="disabled"
                            @disabled(!isset($viewFlags["panel3Success"]))>
                        <span class="glyphicon glyphicon-send" aria-hidden="true" style="padding-right: 5px;"></span>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    @break

@endswitch





