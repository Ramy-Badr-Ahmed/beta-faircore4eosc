<div wire:ignore.self class="modal fade" id="eraseModal" tabindex="-1" role="dialog" aria-labelledby="eraseModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true close-btn">×</span>

                </button>

            </div>

            <div class="modal-body">

                <p>You're about to erase All entries!</p>
                <p>Are you sure want to clear <strong> ALL </strong> fields without saving?</p>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-info -btn -btn-effect close-btn" data-dismiss="modal">Close</button>

                <button type="button" wire:click.prevent="erase()" class="btn btn-danger -btn -btn-effect-erase close-modal" data-dismiss="modal">Yes, Delete</button>

            </div>

        </div>

    </div>

</div>
