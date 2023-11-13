<div class="row">
    <div style=" margin:auto; text-align:center; border: none" class="col-md-12">

        <span class="btn btn-sm -btn-white clear" wire:click="resetIndex('{{$personType}}', {{ $personIdx }})" wire:loading.attr="disabled"
              wire:target="resetIndex('{{$personType}}', {{ $personIdx }})" >
            Clear out @php $person = $personType ?: '' @endphp {{ ucfirst($person)." ".$personIdx+1 }}
        </span>

        <span class="btn btn-sm -btn-white remove" wire:click="removePerson('{{$personType}}', {{ $personIdx }})" wire:loading.attr="disabled"

              wire:target="removePerson('{{$personType}}', {{ $personIdx}})"

              @if($personType === 'author' && $authorNumber === 1)  id="id-removeBtn" data-toggle="modal" data-target="#removeAuthorModal" @endif  >

            Remove @php $person = $personType ?: '' @endphp {{ ucfirst($person)." ".$personIdx+1 }}

        </span>
    </div>
</div>
