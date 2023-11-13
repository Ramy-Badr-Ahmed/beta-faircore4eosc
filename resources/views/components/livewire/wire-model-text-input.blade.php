<div class="form-group" wire:key="{{ $modelName }}-{{ $property }}">

    <label for="{{ $modelName }}-{{ $property }}">{{ $label }}</label>

    <input type="text"
           autocomplete="off"
           id="{{ $modelName }}-{{ $property }}"
           class="form-control"

           wire:model{{ (isset($lazy) AND $lazy === false) ? '' : '.lazy' }}="{{ $modelName }}.{{ $property }}"

           placeholder="{{ $placeholder ?? '' }}"
           @if(isset($onChange)) wire:change="{{ $onChange }}" @endif
           @if(isset($onKeyDown)) wire:keydown="{{ $onKeyDown }}" @endif
           @if(isset($disabled) AND $disabled === true) disabled @endif

    />

    @error($modelName.'.'.$property) <span class="alert-danger">{{ $message }}</span> @enderror

</div>
