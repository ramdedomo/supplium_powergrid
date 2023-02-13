<?php

namespace App\Http\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use App\Models\Receipt;
use App\Models\Requests;
use App\Models\Department;
use App\Models\Notifications;
use App\Models\Messages;
use Carbon\Carbon;
use App\Models\UserType;
use App\Models\SupplyType;
use App\Models\Supply;
use Illuminate\Support\Facades\Auth;

class AddRequest extends ModalComponent
{
    public $supply = [];
    public $user;
    public $qty;

    // public function add(){
    //     $this->validate([
    //         'supply' => 'required',
    //         'user' => 'required',
    //     ]);

    //     if(!is_null($this->supply)){
    //         $this->validate([
    //             'qty' => 'required|numeric|min:1|max:'.Supply::find($this->supply)->supply_stocks,
    //         ]);
    //     }

    //     $type = (Supply::find($this->supply)->supply_type == 1) ? 0 : 1;

    //     switch (Auth::user()->user_type) {
    //         case 5:
    //             $receipt = Receipt::create([
    //                 'user_id' => $this->user,
    //                 'supply_status' => 4,
    //                 'chair_at' => Carbon::now(),
    //                 'dean_at' => Carbon::now(),
    //                 'ced_at' => Carbon::now(),
    //                 'is_supply' => $type
    //             ])->id;

                
    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 105,
    //                 'is_supply' => $type
    //             ]);    

    //             Requests::create([
    //                 'supply_id' => $this->supply,
    //                 'receipt_id' => $receipt,
    //                 'quantity' => $this->qty,
    //             ]);

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 0,
    //                 'is_supply' => $type
    //             ]);    

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 1,
    //                 'is_supply' => $type
    //             ]);

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 2,
    //                 'is_supply' => $type
    //             ]);   

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 8,
    //                 'is_supply' => $type
    //             ]);  
                
    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 4,
    //                 'is_supply' => $type
    //             ]);   

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 0
    //             ]);

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 1
    //             ]);

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 2
    //             ]);

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 8
    //             ]);

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 4
    //             ]);

    //             break;
    //         case 3:
    //             $receipt = Receipt::create([
    //                 'user_id' => $this->user,
    //                 'supply_status' => 1,
    //                 'chair_at' => Carbon::now(),
    //                 'is_supply' => $type
    //             ])->id;

    //             Requests::create([
    //                 'supply_id' => $this->supply,
    //                 'receipt_id' => $receipt,
    //                 'quantity' => $this->qty,
    //             ]);

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 100,
    //                 'is_supply' => $type
    //             ]);    

    //             Notifications::create([
    //                 'user_id' => Auth::user()->id,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 102,
    //                 'is_supply' => $type
    //             ]);   

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 0,
    //                 'is_supply' => $type
    //             ]);    

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 1,
    //                 'is_supply' => $type
    //             ]);    

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 0
    //             ]);

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 1
    //             ]);

             
    //             break;
    //         case 2:
    //             $receipt = Receipt::create([
    //                 'user_id' => $this->user,
    //                 'supply_status' => 2,
    //                 'chair_at' => Carbon::now(),
    //                 'dean_at' => Carbon::now(),
    //                 'is_supply' => $type
    //             ])->id;

    //             Requests::create([
    //                 'supply_id' => $this->supply,
    //                 'receipt_id' => $receipt,
    //                 'quantity' => $this->qty,
    //             ]);

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 102,
    //                 'is_supply' => $type
    //             ]);    

    //             Notifications::create([
    //                 'user_id' => Auth::user()->id,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 105,
    //                 'is_supply' => $type
    //             ]);   

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 0,
    //                 'is_supply' => $type
    //             ]);    

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 1,
    //                 'is_supply' => $type
    //             ]);

    //             Notifications::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'notification_type' => 2,
    //                 'is_supply' => $type
    //             ]);   

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 0
    //             ]);

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 1
    //             ]);

    //             Messages::create([
    //                 'user_id' => $this->user,
    //                 'receipt_id' => $receipt,
    //                 'message_type' => 2
    //             ]);

             
    //             break;    
    //     }

    //     dd('done');
    // }

    public function add(){
        //dd($this->supply, $this->qty);
    }

    public function render()
    {
   
        $supplies = Supply::all();

        foreach ($supplies as $supply) {

            foreach(SupplyType::all() as $type){
                if($supply->supply_type == $type->supply_type){
                    $supply->supplytype = $type->supply_name;
                    $supply->supply_name = $supply->supply_name." (".$supply->supply_unit.")";
                }
            }
        }

        // //ced
        // if(Auth::user()->user_type == 5){
        //     $users = User::where('user_type', '>', 1)
        //     ->where('id', '!=', Auth::user()->id)
        //     ->get();
            

        //     foreach ($users as $user) {
        //         $user->fullname = $user->firstname. " " .$user->lastname;
        //         foreach(UserType::all() as $type){
        //             if($user->user_type == $type->user_type){

        //                 foreach(Department::all() as $department){
        //                     if($user->department == $department->department){
        //                         $user->usertype = "(".$department->department_short.") ".$type->role;
        //                     }
        //                 }
                  
        //             }
        //         }
        //     }
        // //chair
        // }elseif(Auth::user()->user_type == 3){
        //     $users = User::where('user_type', '>=', 3)
        //     ->where('user_type', '<=', 4)
        //     ->where('department',  Auth::user()->department)
        //     ->where('id', '!=', Auth::user()->id)
        //     ->get();

        //     foreach ($users as $user) {
        //         $user->fullname = $user->firstname. " " .$user->lastname;
        //         foreach(UserType::all() as $type){
        //             if($user->user_type == $type->user_type){
        //                 $user->usertype = $type->role;
        //             }
        //         }
        //     }

        // //dean
        // }elseif(Auth::user()->user_type == 2){
        //     $users = User::where('user_type', '>=', 2)
        //     ->where('user_type', '<=', 4)
        //     ->where('department',  Auth::user()->department)
        //     ->where('id', '!=', Auth::user()->id)
        //     ->get();

        //     foreach ($users as $user) {
        //         $user->fullname = $user->firstname. " " .$user->lastname;

        //         foreach(UserType::all() as $type){
        //             if($user->user_type == $type->user_type){
        //                 $user->usertype = $type->role;
        //             }
        //         }
        //     }
        // }

        return view('livewire.add-request', ['supplies' => $supplies]);
    }
}
