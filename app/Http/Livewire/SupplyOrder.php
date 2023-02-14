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
use App\Models\Department;

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
    

        if($this->issupply == 0){

            switch (Auth::user()->user_type) {
                case 4:

                    $isnonteach = Department::find(Auth::user()->department)->nonteaching;

                    if($isnonteach == 0){
                        $receipt = Receipt::create([
                            'user_id' => Auth::user()->id,
                            'supply_status' => 0,
                            'is_supply' => $this->issupply
                        ])->id;
      
                        Requests::create([
                            'supply_id' => $this->supply,
                            'receipt_id' => $receipt,
                            'quantity' => $this->quantity,
                        ]);

                        //decrement stocks
                        Supply::find($this->supply)->decrement('supply_stocks', $this->quantity);
    
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
                    }else{
                        $receipt = Receipt::create([
                            'user_id' => Auth::user()->id,
                            'supply_status' => 0,
                            'is_supply' => $this->issupply
                        ])->id;
      
                        Requests::create([
                            'supply_id' => $this->supply,
                            'receipt_id' => $receipt,
                            'quantity' => $this->quantity,
                        ]);

                         //decrement stocks
                         Supply::find($this->supply)->decrement('supply_stocks', $this->quantity);
    
                        Notifications::create([
                            'user_id' => Auth::user()->id,
                            'receipt_id' => $receipt,
                            'notification_type' => 106,
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
                    }

  
                    break;
                case 6:

                    $receipt = Receipt::create([
                        'user_id' => Auth::user()->id,
                        'supply_status' => 6,
                        'head_at' => Carbon::now(),
                        'is_supply' => $this->issupply
                    ])->id;
  
                    Requests::create([
                        'supply_id' => $this->supply,
                        'receipt_id' => $receipt,
                        'quantity' => $this->quantity,
                    ]);

                     //decrement stocks
                     Supply::find($this->supply)->decrement('supply_stocks', $this->quantity);

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 105,
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
                        'notification_type' => 9,
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
                        'message_type' => 9
                    ]);

        
                    break;
                case 3:

                    $receipt = Receipt::create([
                        'user_id' => Auth::user()->id,
                        'supply_status' => 1,
                        'chair_at' => Carbon::now(),
                        'is_supply' => $this->issupply
                    ])->id;
  
                    Requests::create([
                        'supply_id' => $this->supply,
                        'receipt_id' => $receipt,
                        'quantity' => $this->quantity,
                    ]);

                     //decrement stocks
                     Supply::find($this->supply)->decrement('supply_stocks', $this->quantity);

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
                    $receipt = Receipt::create([
                        'user_id' => Auth::user()->id,
                        'supply_status' => 2,
                        'chair_at' => Carbon::now(),
                        'dean_at' => Carbon::now(),
                        'is_supply' => $this->issupply
                    ])->id;
  
                    Requests::create([
                        'supply_id' => $this->supply,
                        'receipt_id' => $receipt,
                        'quantity' => $this->quantity,
                    ]);

                     //decrement stocks
                     Supply::find($this->supply)->decrement('supply_stocks', $this->quantity);

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 105,
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

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 2,
                        'is_supply' => 0
                    ]);   

                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'notification_type' => 3,
                    //     'is_supply' => 0
                    // ]);   

                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'notification_type' => 4,
                    //     'is_supply' => 0
                    // ]);   

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

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'message_type' => 3
                    // ]);

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'message_type' => 4
                    // ]);
        
                    break;

                case 5: 

                    $receipt = Receipt::create([
                        'user_id' => Auth::user()->id,
                        'supply_status' => 4,
                        'chair_at' => Carbon::now(),
                        'dean_at' => Carbon::now(),
                        'ced_at' => Carbon::now(),
                        'is_supply' => $this->issupply
                    ])->id;
  
                    Requests::create([
                        'supply_id' => $this->supply,
                        'receipt_id' => $receipt,
                        'quantity' => $this->quantity,
                    ]);

                     //decrement stocks
                     Supply::find($this->supply)->decrement('supply_stocks', $this->quantity);
                    
                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'notification_type' => 0,
                    //     'is_supply' => 0
                    // ]);    

                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'notification_type' => 1,
                    //     'is_supply' => 0
                    // ]);

                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'notification_type' => 2,
                    //     'is_supply' => 0
                    // ]);   

                    // Notifications::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'notification_type' => 8,
                    //     'is_supply' => 0
                    // ]);   

                    Notifications::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'notification_type' => 4,
                        'is_supply' => 0
                    ]);   

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'message_type' => 0
                    // ]);

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'message_type' => 1
                    // ]);

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'message_type' => 2
                    // ]);

                    // Messages::create([
                    //     'user_id' => Auth::user()->id,
                    //     'receipt_id' => $receipt,
                    //     'message_type' => 8
                    // ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $receipt,
                        'message_type' => 4
                    ]);
        
                    break;
            }
    
        }else{

 
            $receipt = Receipt::create([
                'user_id' => Auth::user()->id,
                'supply_status' => 0,
                'is_supply' => $this->issupply
            ])->id;

            Requests::create([
                'receipt_id' => $receipt,
                'supply_id' => $this->supply,
                'quantity' => $this->quantity,
            ]);

            //decrement stocks
            Supply::find($this->supply)->decrement('supply_stocks', $this->quantity);

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
        
        return redirect('myrequests');

        // $this->notification()->confirm([
        //     'title'       => 'Request Placed!',
        //     'description' => 'Your Request is Succesfully Placed!',
        //     'accept'      => [
        //         'label'  => 'Check Requested Items',
        //         'method' => 'check',
        //     ],
        //     'reject' => [
        //         'label'  => 'Cancel',
        //     ],
        //     'params'      => 'Saved',
        //     'icon'        => 'success',
        //     'iconColor'   => 'text-amber-500'
        // ]);

    }

    // public function check(){
    //     return redirect('myrequests');
    // }

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

    // public function bag(){
    //     return redirect()->to('/bag');
    // }

    public function cart(){
        $this->validate();

        // $this->notification()->confirm([
        //     'title'       => 'Added to Bag!',
        //     'description' => 'Item added to Bag. Check your bag.',
        //     'accept'      => [
        //         'label'  => 'Check Bag',
        //         'method' => 'bag',
        //     ],
        //     'reject' => [
        //         'label'  => 'Cancel',
        //     ],
        //     'params'      => 'Saved',
        //     'icon'        => 'success',
        //     'iconColor'   => 'text-amber-500'
        // ]);

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
        return redirect('bag');
        
    }

    public function render()
    {
        return view('livewire.supply-order');
    }
}
