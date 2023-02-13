<?php

namespace App\Http\Livewire;
use LivewireUI\Modal\ModalComponent;
use App\Models\Supply;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
class AddSupply extends ModalComponent
{
    use Actions;
    use WithFileUploads;
    public $itemname;
    public $itemstocks;
    public $itemcategory;
    public $itemdescription;
    public $itemcolor;
    public $itemphoto;
    public $itemprice;
    public $itemunit;


    protected function rules()
    {
        return [
            'itemname' => 'required',
            'itemstocks' => 'required|numeric|gt:0',
            'itemunit' => 'required',
            'itemcategory' => 'required',
            'itemcolor' => 'required',
            'itemprice' => 'required|numeric'
        ];
    }

    public function updatedPhoto()
    {
        $this->validate([
            'itemphoto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
    }

    public function removephoto(){
        $this->reset('itemphoto');
        $this->itemphoto = null;

    }
    
    public function additem()
    {
        $this->validate();
        
        if(!is_null($this->itemphoto)){
            $this->validate([
                'itemphoto' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            Storage::putFile('public', $this->itemphoto);
            $photo = $this->itemphoto->hashName();

        }else{
            $photo = $this->itemphoto;
        }

        // $this->itemphoto->store('photos');

        $create = Supply::create([
            'supply_desc' => $this->itemdescription,
            'supply_name' => $this->itemname,
            'supply_stocks' => $this->itemstocks,
            'supply_type' => ($this->itemcategory == "Supply") ? 0 : 1,
            'supply_color' => $this->itemcolor,
            'supply_price' => $this->itemprice,
            'supply_photo' => $photo,
            'supply_unit' => $this->itemunit
        ]);
        

        if($create){

            $this->closeModal();
                        
            $this->notification()->send([
                'title'       => 'Item Added!',
                'description' => $this->itemname . " Added",
                'icon'        => 'warning'
            ]);

            $this->emit('itemUpdated');

        }

    }
    
    public function render()
    {
        return view('livewire.add-supply');
    }
}
