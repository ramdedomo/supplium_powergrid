<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Notifications;
use App\Models\Bag;
use App\Models\Requests;
use App\Models\Receipt;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Messages;
class SuppliumBag extends Component
{
    use WithPagination;
    use Actions;

    public $check = [];

    protected $listeners = ['bagUpdated' => '$refresh'];

    public function remove($id){
        Bag::where('supply_id', $id)->delete();
    }


    public function sendrequest(){

        $supplies = [];
        $equipments = [];
        //seperate equipments and supplies

        foreach($this->check as $item){
            if(explode(',', $item)[2] == "Supply"){
                $supplies[] = [
                    'id' => explode(',', $item)[3],
                    'quantity' => explode(',', $item)[1],
                ];
            }else{
                $equipments[] = [
                    'id' => explode(',', $item)[3],
                    'quantity' => explode(',', $item)[1],
                ];
            }
        }

        

        //all supplies will have same receipt id and destination
        $receipt_supplies = rand(00000000,99999999);

        foreach($supplies as $supply){

            Requests::create([
                'supply_id' => $supply['id'],
                'id' => $receipt_supplies,
                'quantity' => $supply['quantity'],
            ]);

            Receipt::create([
                'user_id' => Auth::user()->id,
                'id' => $receipt_supplies,
                'supply_status' => 0,
                'is_supply' => 1
            ]);


            Bag::where('user_id', Auth::user()->id)->where('supply_id', $supply['id'])->delete();
        }

        if(!empty($supplies)){

            Notifications::create([
                'user_id' => Auth::user()->id,
                'receipt_id' => $receipt_supplies,
                'notification_type' => 103,
                'is_supply' => 1
            ]);  

            Notifications::create([
                'user_id' => Auth::user()->id,
                'receipt_id' => $receipt_supplies,
                'notification_type' => 0,
                'is_supply' => 1
            ]);    

            Messages::create([
                'user_id' => Auth::user()->id,
                'receipt_id' => $receipt_supplies,
                'message_type' => 0
            ]);

        }


        //all equipments will have same receipt id and destination
        $receipt_equipments = rand(00000000,99999999);

        foreach($equipments as $equipment){

            Requests::create([
                'supply_id' => $equipment['id'],
                'id' => $receipt_equipments,
                'quantity' => $equipment['quantity'],
            ]);

            switch (Auth::user()->user_type) {
                case 4:
                    Receipt::create([
                        'user_id' => Auth::user()->id,
                        'id' => $receipt_equipments,
                        'supply_status' => 0,
                        'is_supply' => 0
                    ]);

 

                    break;
                case 3:
                    Receipt::create([
                        'user_id' => Auth::user()->id,
                        'id' => $receipt_equipments,
                        'supply_status' => 1,
                        'chair_at' => Carbon::now(),
                        'is_supply' => 0
                    ]);

        
                    break;
                case 2:
                    Receipt::create([
                        'user_id' => Auth::user()->id,
                        'id' => $receipt_equipments,
                        'supply_status' => 4,
                        'chair_at' => Carbon::now(),
                        'dean_at' => Carbon::now(),
                        'is_supply' => 0
                    ]);

               
        
        
                    break;
            }

 
            Bag::where('user_id', Auth::user()->id)->where('supply_id', $equipment['id'])->delete();
        }

        if(!empty($equipments)){
            switch (Auth::user()->user_type) {
                case 4:

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 100,
                        'is_supply' => 0
                    ]);   

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 0,
                        'is_supply' => 0
                    ]);    

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'message_type' => 0
                    ]);
  

        
                    break;
                case 3:

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 102,
                        'is_supply' => 0
                    ]);   
                    
                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 0,
                        'is_supply' => 0
                    ]);    

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 1,
                        'is_supply' => 0
                    ]);    

                    
                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'message_type' => 0
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'message_type' => 1
                    ]);
 
        
                    break;
                case 2:
                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 0,
                        'is_supply' => 0
                    ]);    

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 1,
                        'is_supply' => 0
                    ]);

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 2,
                        'is_supply' => 0
                    ]);   

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 3,
                        'is_supply' => 0
                    ]);   

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 4,
                        'is_supply' => 0
                    ]);   

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'message_type' => 0
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'message_type' => 1
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'message_type' => 2
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'message_type' => 3
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'message_type' => 4
                    ]);
        
        
                    break;
            }
        }


        $this->emit('itemRequested');

        $this->dialog()->show([
            'title'       => 'Request Sent!',
            'description' => 'The Request is Succesfully Sent!',
            'icon'        => 'success',
        ]);

        $this->reset('check');

    }
    
    
    public function render()
    {
        return view('livewire.supplium-bag', [
            'supplies' => Bag::where('user_id', Auth::user()->id)
            ->join('supply', 'bag.supply_id', '=', 'supply.id')
            ->paginate(4),
        ]);
    }
}
