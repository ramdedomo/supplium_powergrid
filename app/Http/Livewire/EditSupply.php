<?php

namespace App\Http\Livewire;
use LivewireUI\Modal\ModalComponent;
use App\Models\Supply;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EditSupply extends ModalComponent
{
    use WithFileUploads;
    use Actions;
    public $supply_details;
    public $itemname;
    public $itemstocks;
    public $itemcategory;
    public $itemdescription;
    public $supply;
    public $itemphoto;
    public $itemcolor;
    public $itemunit;


    public function mount($supply)
    {
        $this->supply = $supply;

        $this->supply_details = Supply::where('id', $supply)->first();
        
        $this->itemdescription = $this->supply_details->supply_desc;
        $this->itemname = $this->supply_details->supply_name;
        $this->itemstocks = $this->supply_details->supply_stocks;
        $this->itemcategory = ($this->supply_details->supply_type == 0) ? "Supply" : "Equipments";
        $this->itemcolor = $this->supply_details->supply_color;
        $this->itemunit = $this->supply_details->supply_unit;
        $this->currentphoto = $this->supply_details->supply_photo;
        $this->itemprice = $this->supply_details->supply_price;
    }

    
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

    // public function updatedPhoto()
    // {
    //     $this->validate([
    //         'itemphoto' => 'image|mimes:jpeg,png,jpg|max:2048',
    //     ]);
    // }

    public function removephoto(){
        $this->reset('itemphoto');
        $this->itemphoto = null;
        $this->currentphoto = null;
    }

    public function update(){

        $this->validate();

        if(!is_null($this->itemphoto)){
            $this->validate([
                'itemphoto' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            Storage::putFile('public', $this->itemphoto);
            $photo = $this->itemphoto->hashName();
        }else{
            $photo = $this->currentphoto;
        }

        $a = Supply::where('id', $this->supply)->first()->supply_photo;
   
        if(!is_null($a)){
            File::delete(public_path('storage/'.$a));
        }

        $update = Supply::where('id', $this->supply)
            ->update([
                'supply_desc' => $this->itemdescription,
                'supply_name' => $this->itemname,
                'supply_stocks' => $this->itemstocks,
                'supply_type' => ($this->itemcategory == "Supply") ? 0 : 1,
                'supply_color' => $this->itemcolor,
                'supply_photo' => $photo,
                'supply_unit' => $this->itemunit
            ]);


        if($update){
            $this->dialog([
                    'title'       => 'Item Updated!',
                    'description' => $this->itemname . " Updated",
                    'icon'        => 'warning'
            ]);
        }else{
            $this->dialog([
                'title'       => 'Something went Wrong',
                'description' => 'Please try again or later',
                'icon'        => 'warning'
            ]);
        };


        $this->emit('itemUpdated');

    }

    public function delete(){
        // $this->notification()->confirm([
        //     'title'       => 'Are you Sure?',
        //     'description' => 'Delete this Item?',
        //     'acceptLabel' => 'Yes, Confirm',
        //     'method'      => 'deleted',
        //     'params'      => 'Item Deleted',
        // ]);
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Delete this Item (' . $this->itemname . ')?',
            'acceptLabel' => 'Yes, Confirm',
            'method'      => 'deleted',
            'params'      => 'Item Deleted',
        ]);
    }

    public function deleted(){
       $this->closeModal();

       $deleted = Supply::where('id', $this->supply)->delete();

       if($deleted){
            $this->notification()->send([
                'title'       => 'Item Deleted!',
                'description' => $this->itemname . " Deleted",
                'icon'        => 'warning'
            ]);

            $this->emit('itemUpdated');
       }


    }

    public function render()
    {
        return view('livewire.edit-supply');
    }
}

