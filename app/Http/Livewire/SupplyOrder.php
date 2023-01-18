<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;
use App\Models\Supply;
use App\Models\Notifications;
use App\Models\Messages;
use App\Models\Bag;
use App\Models\User;
use App\Models\Requests;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Route;
use Request;
use Carbon\Carbon;

class SupplyOrder extends ModalComponent
{
    use Actions;
    public $supply;
    public $supply_color;
    public $supply_stocks;
    public $quantity;

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
        $this->issupply = (Supply::find($supply)->supply_type == 0) ? 1 : 0;
        $this->quantity = 1;
    }

    public function request_confirm(){
        $receipt = rand(00000000,99999999);

        if($this->issupply == 0){

            Requests::create([
                'supply_id' => $this->supply,
                'id' => $receipt,
                'quantity' => $this->quantity,
            ]);
    
            switch (Auth::user()->user_type) {
                case 4:
                    Receipt::create([
                        'user_id' => Auth::user()->id,
                        'id' => $receipt,
                        'supply_status' => 0,
                        'is_supply' => $this->issupply
                    ]);

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 100,
                        'is_supply' => 0
                    ]);

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 0,
                        'is_supply' => 0
                    ]);   
                    
                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'message_type' => 0
                    ]);
  
                    break;
                case 3:
                    Receipt::create([
                        'user_id' => Auth::user()->id,
                        'id' => $receipt,
                        'supply_status' => 1,
                        'chair_at' => Carbon::now(),
                        'is_supply' => $this->issupply
                    ]);

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 102,
                        'is_supply' => 0
                    ]);   

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 0,
                        'is_supply' => 0
                    ]);    

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 1,
                        'is_supply' => 0
                    ]);    

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'message_type' => 0
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'message_type' => 1
                    ]);

        
                    break;
                case 2:
                    Receipt::create([
                        'user_id' => Auth::user()->id,
                        'id' => $receipt,
                        'supply_status' => 4,
                        'chair_at' => Carbon::now(),
                        'dean_at' => Carbon::now(),
                        'is_supply' => $this->issupply
                    ]);

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 0,
                        'is_supply' => 0
                    ]);    

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 1,
                        'is_supply' => 0
                    ]);

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 2,
                        'is_supply' => 0
                    ]);   

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 3,
                        'is_supply' => 0
                    ]);   

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 4,
                        'is_supply' => 0
                    ]);   

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'message_type' => 0
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'message_type' => 1
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'message_type' => 2
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'message_type' => 3
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'message_type' => 4
                    ]);
        
                    break;
            }
    
        }else{

            Requests::create([
                'supply_id' => $this->supply,
                'id' => $receipt,
                'quantity' => $this->quantity,
            ]);

            Receipt::create([
                'user_id' => Auth::user()->id,
                'id' => $receipt,
                'supply_status' => 0,
                'is_supply' => $this->issupply
            ]);

            Notifications::create([
                'user_id' => Auth::user()->id,
                'receipt_id' => $receipt,
                'notification_type' => 103,
                'is_supply' => 1
            ]);  

            Notifications::create([
                'user_id' => Auth::user()->id,
                'receipt_id' => $receipt,
                'notification_type' => 0,
                'is_supply' => 1
            ]);    

            Messages::create([
                'user_id' => Auth::user()->id,
                'receipt_id' => $receipt,
                'message_type' => 0
            ]);

        }



        $this->emit('itemRequested');
        $this->closeModal();

        $this->notification()->confirm([
            'title'       => 'Request Placed!',
            'description' => 'Your Request is Succesfully Placed!',
            'accept'      => [
                'label'  => 'Check Requested Items',
                'method' => 'check',
            ],
            'reject' => [
                'label'  => 'Cancel',
            ],
            'params'      => 'Saved',
            'icon'        => 'success',
            'iconColor'   => 'text-amber-500'
        ]);

    }

    public function check(){
        return redirect('myrequests');
    }

    public function request(){
        $this->validate();


        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Send this Request?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Accept',
                'method' => 'request_confirm',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);

    }

    public function bag(){
        return redirect('bag');
    }

    public function cart(){
        $this->validate();

        $this->notification()->confirm([
            'title'       => 'Added to Bag!',
            'description' => 'Item added to Bag. Check your bag.',
            'accept'      => [
                'label'  => 'Check Bag',
                'method' => 'bag',
            ],
            'reject' => [
                'label'  => 'Cancel',
            ],
            'params'      => 'Saved',
            'icon'        => 'success',
            'iconColor'   => 'text-amber-500'
        ]);

        $isexists = Bag::where('supply_id', $this->supply)->where('user_id', Auth::user()->id)->exists();

        if($isexists){
            $getexists = Bag::where('supply_id', $this->supply)->where('user_id', Auth::user()->id)->first();

            Bag::where('supply_id', $this->supply)
            ->where('user_id', Auth::user()->id)
            ->update([
                'quantity' => $getexists->quantity + $this->quantity,
                'user_id' => Auth::user()->id,
                'supply_id' => $this->supply
            ]);
        }else{
            Bag::create([
                'quantity' => $this->quantity,
                'user_id' => Auth::user()->id,
                'supply_id' => $this->supply
            ]);
        }

        $this->closeModal();

        
    }

    public function render()
    {
        return view('livewire.supply-order');
    }
}
