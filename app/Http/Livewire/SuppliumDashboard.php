<?php

namespace App\Http\Livewire;
use Session;
use Livewire\Component;

class SuppliumDashboard extends Component
{
    public $simpleModal;


    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.supplium-dashboard');
    }

}
