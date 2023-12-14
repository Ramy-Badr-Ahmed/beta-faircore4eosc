<?php

namespace App\Http\Livewire\MetaData;

use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

trait Listeners
{

    public function fillList(): void
    {
        if(!isset($this->formData['licenseInput'])){
            $this->licenses = Arr::map(self::$spdx->getLicenses(), function($val){
                return $val[1];
            });
        }
        $this->dispatchBrowserEvent('showDropdown');
    }

    public function activateImport(bool $value): void
    {
        $this->viewFlags['jsonReadOnly'] = $value;
    }

    public function setTripModeFromJS(string $mode): void
    {
        $this->viewFlags['tripMode'] = $mode;
    }

    /**
     * @throws ValidationException
     */
    public function eraseField(string $property): void
    {
        unset($this->formData[$property]);

        if($property === 'licenseInput'){
            unset($this->formData['license']);
            $this->dispatchBrowserEvent('showDropdown', ['view' => 'hide']);
        }
        if($property === 'idType'){
            $this->reset('idType');
        }
        if($this->viewFlags['tripMode'] !== 'defer'){
            $this->generateCodeMeta(true);
        }
    }

    public function decreasePerson(string $person): void
    {
        $person = $person.'Number';
        $this->{$person}--;
    }

    public function preventReload(): void
    {
       $this->emit('clearPops');
    }

}
