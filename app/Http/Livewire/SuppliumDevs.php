<?php

namespace App\Http\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class SuppliumDevs extends ModalComponent
{
    public function render()
    {
        $developer = [
            ['role' => 'Project Documentation', 'name' => 'Bautista, Marc Adrian'],
            ['role' => 'Project Documentation', 'name' => 'Caba, Prince Gabriel'],
            ['role' => 'Programmer', 'name' => 'Dedomo, Ram Wendel'],
            ['role' => 'Project Documentation', 'name' => 'Lantonio, Anthony'],
            ['role' => 'Project Documentation / Logo Creator', 'name' => 'Morota, Aldrin'],
        ];

        return view('livewire.supplium-devs', ['developers' => $developer]);
    }
}
