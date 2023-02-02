<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Supply;
use Livewire\WithPagination;

class SuppliumBrowseItems extends Component
{
    use WithPagination;
    
    public $search;
    public $sort;
    public $type;

    public function mount(){
    
    }

    public function render()
    {
        $supplies = Supply::searchall($this->search)
        ->when(empty($this->search), function ($query) {
            $query->where('id', '>', 0);
        })
        ->when(!empty($this->type), function ($query) {
            if($this->type == 'Supplies'){
                $query->where('supply.supply_type', 0);
            }else{
                $query->where('supply.supply_type', 1);
            }
        })
        ->when(!empty($this->sort), function ($query) {
            if($this->sort == 'A-Z'){
                $query->orderBy('supply_name', 'DESC');
            }elseif($this->sort == 'Z-A'){
                $query->orderBy('supply_name', 'ASC');
            }elseif($this->sort == 'Low - Stocks'){
                $query->orderBy('supply_stocks', 'ASC');
            }elseif($this->sort == 'High - Stocks'){
                $query->orderBy('supply_stocks', 'DESC');
            }
        })
        ->join('supply_type', 'supply.supply_type', '=', 'supply_type.supply_type')
        ->select('supply.*', 'supply_type.supply_name as supplyname')
        ->paginate(12);
        


        return view('livewire.supplium-browse-items', ['supplies' => $supplies]);
    }
}
