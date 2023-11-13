<div class="row">

    <div class="col-sm-3">
        <x-livewire.wire-model-text-input
            modelName="metadata"
            property="authors.{{ $key }}.firstName"
            label="Author {{ $key + 1 }}, First Name"
        />
    </div>

    <div class="col-sm-3">
        <x-livewire.wire-model-text-input
            modelName="metadata"
            property="authors.{{ $key }}.lastName"
            label="Author {{ $key + 1 }}, Last Name"
        />
    </div>

    <div class="col-sm-3">
        <x-livewire.wire-model-text-input
            modelName="metadata"
            property="authors.{{ $key }}.affiliation"
            label="Author {{ $key + 1 }}, Affiliation"
        />
    </div>

    <x-livewire.wire-modal/>

    <span class="btn btn-sm" wire:click="removeAuthor({{ $key }})" style="margin-top: 2.55em" data-toggle="modal" data-target="#exampleModal">Remove</span>

</div>
