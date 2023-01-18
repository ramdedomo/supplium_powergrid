<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Supply;

class SuppliumBrowseItems extends Component
{
    public $supplies;

    public function mount(){
        $this->supplies = Supply::join('supply_type', 'supply.supply_type', '=', 'supply_type.supply_type')
        ->select('supply.*', 'supply_type.supply_name as supplyname')
        ->get();


    }

    public function render()
    {
        
        return view('livewire.supplium-browse-items');
    }
}
