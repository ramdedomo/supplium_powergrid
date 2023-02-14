<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Notifications;
use App\Models\Bag;
use App\Models\Supply;
use App\Models\Requests;
use App\Models\Receipt;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Messages;
use App\Models\Department;

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
        $receipt_supplies = Receipt::create([
            'user_id' => Auth::user()->id,
            'supply_status' => 0,
            'is_supply' => 1
        ])->id;

        //all request item have same receipt id
        foreach($supplies as $supply){
            
            Requests::create([
                'supply_id' => $supply['id'],
                'receipt_id' => $receipt_supplies,
                'quantity' => $supply['quantity'],
            ]);

            //delete from bag
            Bag::where('user_id', Auth::user()->id)->where('supply_id', $supply['id'])->delete();
            //decrement stocks
            Supply::find($supply['id'])->decrement('supply_stocks', $supply['quantity']);
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

        
        //equipmetns
            switch (Auth::user()->user_type) {
                case 4:

                    $isnonteach = Department::find(Auth::user()->department)->nonteaching;
                    if($isnonteach == 0){
                        //all equipments will have same receipt id and destination
                        $receipt_equipments = Receipt::create([
                            'user_id' => Auth::user()->id,
                            'supply_status' => 0,
                            'is_supply' => 0
                        ])->id;

                        foreach ($equipments as $equipment) {
                            Requests::create([
                                'supply_id' => $equipment['id'],
                                'receipt_id' => $receipt_equipments,
                                'quantity' => $equipment['quantity'],
                            ]);

                       
                            //delete from bag
                            Bag::where('user_id', Auth::user()->id)->where('supply_id', $equipment['id'])->delete();
                            //decrement stocks
                            Supply::find($equipment['id'])->decrement('supply_stocks', $equipment['quantity']);
                        }
                    }else{
                        $receipt_equipments = Receipt::create([
                            'user_id' => Auth::user()->id,
                            'supply_status' => 0,
                            'is_supply' => 0
                        ])->id;
    
                        foreach ($equipments as $equipment) {
                            Requests::create([
                                'supply_id' => $equipment['id'],
                                'receipt_id' => $receipt_equipments,
                                'quantity' => $equipment['quantity'],
                            ]);
    
                            //delete from bag
                            Bag::where('user_id', Auth::user()->id)->where('supply_id', $equipment['id'])->delete();
                            //decrement stocks
                            Supply::find($equipment['id'])->decrement('supply_stocks', $equipment['quantity']);
                        }
                    }
        
                    break;
                case 3:

                    //all equipments will have same receipt id and destination
                    $receipt_equipments = Receipt::create([
                        'user_id' => Auth::user()->id,
                        'supply_status' => 1,
                        'chair_at' => Carbon::now(),
                        'is_supply' => 0
                    ])->id;

                    foreach ($equipments as $equipment) {
                        Requests::create([
                            'supply_id' => $equipment['id'],
                            'receipt_id' => $receipt_equipments,
                            'quantity' => $equipment['quantity'],
                        ]);

                        //delete from bag
                        Bag::where('user_id', Auth::user()->id)->where('supply_id', $equipment['id'])->delete();
                        //decrement stocks
                        Supply::find($equipment['id'])->decrement('supply_stocks', $equipment['quantity']);
                    }

        
                    break;
                case 6:
                    $receipt_equipments = Receipt::create([
                        'user_id' => Auth::user()->id,
                        'supply_status' => 6,
                        'head_at' => Carbon::now(),
                        'is_supply' => 0
                    ])->id;

                    foreach ($equipments as $equipment) {
                        Requests::create([
                            'supply_id' => $equipment['id'],
                            'receipt_id' => $receipt_equipments,
                            'quantity' => $equipment['quantity'],
                        ]);

                        //delete from bag
                        Bag::where('user_id', Auth::user()->id)->where('supply_id', $equipment['id'])->delete();
                        //decrement stocks
                        Supply::find($equipment['id'])->decrement('supply_stocks', $equipment['quantity']);
                    }
        
                    break;
                case 2:

                    $receipt_equipments = Receipt::create([
                        'user_id' => Auth::user()->id,
                        'supply_status' => 2,
                        'chair_at' => Carbon::now(),
                        'dean_at' => Carbon::now(),
                        'is_supply' => 0
                    ])->id;

                    foreach ($equipments as $equipment) {
                        Requests::create([
                            'supply_id' => $equipment['id'],
                            'receipt_id' => $receipt_equipments,
                            'quantity' => $equipment['quantity'],
                        ]);

                        //delete from bag
                        Bag::where('user_id', Auth::user()->id)->where('supply_id', $equipment['id'])->delete();
                        //decrement stocks
                        Supply::find($equipment['id'])->decrement('supply_stocks', $equipment['quantity']);
                    }
        
                    break;

                case 5:

                    $receipt_equipments = Receipt::create([
                        'user_id' => Auth::user()->id,
                        'supply_status' => 4,
                        'chair_at' => Carbon::now(),
                        'dean_at' => Carbon::now(),
                        'ced_at' => Carbon::now(),
                        'is_supply' => 0
                    ])->id;

                    foreach ($equipments as $equipment) {
                        Requests::create([
                            'supply_id' => $equipment['id'],
                            'receipt_id' => $receipt_equipments,
                            'quantity' => $equipment['quantity'],
                        ]);

                        //delete from bag
                        Bag::where('user_id', Auth::user()->id)->where('supply_id', $equipment['id'])->delete();
                        //decrement stocks
                        Supply::find($equipment['id'])->decrement('supply_stocks', $equipment['quantity']);
                    }
        
                    break;
            }

 
   
      

        if(!empty($equipments)){
            switch (Auth::user()->user_type) {
                case 4:
                    $isnonteach = Department::find(Auth::user()->department)->nonteaching;
                    if($isnonteach == 0){
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
                    }else{
                        Notifications::create([
                            'user_id' => Auth::user()->id,
                            'receipt_id' => $receipt_equipments,
                            'notification_type' => 106,
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
                    }
               
        
                    break;
                case 6:

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 105,
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
                        'notification_type' => 9,
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
                        'message_type' => 9
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
                        'notification_type' => 105,
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

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 2,
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
        
                    break;

                 case 5:

                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt_equipments,
                    //     'notification_type' => 0,
                    //     'is_supply' => 0
                    // ]);    

                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt_equipments,
                    //     'notification_type' => 1,
                    //     'is_supply' => 0
                    // ]);

                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt_equipments,
                    //     'notification_type' => 2,
                    //     'is_supply' => 0
                    // ]);   

                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt_equipments,
                    //     'notification_type' => 8,
                    //     'is_supply' => 0
                    // ]);   

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt_equipments,
                        'notification_type' => 4,
                        'is_supply' => 0
                    ]);   

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt_equipments,
                    //     'message_type' => 0
                    // ]);

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt_equipments,
                    //     'message_type' => 1
                    // ]);

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt_equipments,
                    //     'message_type' => 2
                    // ]);

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt_equipments,
                    //     'message_type' => 8
                    // ]);

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
