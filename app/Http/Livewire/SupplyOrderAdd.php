<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;
use App\Models\Supply;
use App\Models\Bag;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Route;
use Request;

class SupplyOrderAdd extends ModalComponent
{

    use Actions;
    protected function rules()
    {
        return [
            'quantity' => 'required|numeric|min:1|max:'.$this->supply_stocks,
        ];
    }

    public function mount($supply)
    {
        $this->supply = $supply;
        $this->supply_name = Supply::find($supply)->supply_name;
        $this->supply_stocks = Supply::find($supply)->supply_stocks;
        $this->quantity = Bag::where('supply_id', $supply)->where('user_id', Auth::user()->id)->first()->quantity;
    }

    public function cart(){
        $this->validate();

        Bag::where('supply_id', $this->supply)
        ->where('user_id', Auth::user()->id)
        ->update([
            'quantity' => $this->quantity
        ]);

        $this->notification([
            'title'       => 'Supply/Equipment Updated!',
            'description' => 'Updated '.$this->quantity.' Item/s on '.$this->supply_name,
            'icon'        => 'success'
        ]);
        $this->closeModal();
        $this->emit('bagUpdated');

    }

    public function render()
    {
        return view('livewire.supply-order-add');
    }
}
