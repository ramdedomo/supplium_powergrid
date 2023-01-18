<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;
use App\Models\Supply;
use App\Models\Bag;
use App\Models\User;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Route;
use Request;
use Carbon\Carbon;
use App\Models\Notifications;
use App\Models\Messages;

class ViewRequest extends ModalComponent
{
    use Actions;
    public $requests;
    public $message_content;


    
    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function done_confirm(){
        Receipt::where('id', $this->request)->update([
            'supply_status' => 5,
            'done_at' => Carbon::now()
        ]);

        $exists = Notifications::where('receipt_id', $this->request)->first();
        
        Notifications::create([
            'user_id' => $exists->user_id,
            'receipt_id' => $exists->receipt_id,
            'notification_type' => 6,
            'is_supply' => $this->receipt->is_supply
        ]);   
        
        Messages::create([
            'user_id' => Auth::user()->id,
            'receipt_id' => $exists->receipt_id,
            'message_type' => 6
        ]);

        $this->dialog()->show([
            'title'       => 'Request Done!',
            'description' => 'The Request is Succesfully Receive!',
            'icon'        => 'success',
        ]);

        $this->closeModal();
        $this->emit('itemRequested');
        $this->emit('itemUpdated');
    }

    public function done(){
        
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Complete this Request?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Accept',
                'method' => 'done_confirm',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);

    }

    public function cancel_confirm(){
        Receipt::where('id', $this->request)->update([
            'supply_status' => 7,
            'canceled_at' => Carbon::now()
        ]);

        $exists = Notifications::where('receipt_id', $this->request)->first();
        
        Notifications::create([
            'user_id' => $exists->user_id,
            'receipt_id' => $exists->receipt_id,
            'notification_type' => 5,
            'is_supply' => $this->receipt->is_supply
        ]);    

        Messages::create([
            'user_id' => Auth::user()->id,
            'receipt_id' => $exists->receipt_id,
            'message_type' => 5
        ]);

        $this->dialog()->show([
            'title'       => 'Request Canceled!',
            'description' => 'The Request is Succesfully Canceled!',
            'icon'        => 'success',
        ]);

        $this->closeModal();
        $this->emit('itemRequested');
        $this->emit('itemUpdated');
    }

    public function cancel(){

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Cancel this Request?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Accept',
                'method' => 'cancel_confirm',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);

    }

    public function mount($request){
  
        $this->request = $request;
        $this->receipt = Receipt::where('receipt.id', $request)
        ->join('status', 'receipt.supply_status', '=', 'status.status')
        ->first();
        $this->requests = Receipt::where('receipt.id', $request)
        ->join('requests', 'receipt.id', '=', 'requests.id')
        ->get();

        $count = 0;
        foreach($this->requests as $item){
            $this->requests[$count]['supply_name'] = Supply::find($item->supply_id)->supply_name;
            $this->requests[$count]['supply_type'] = (Supply::find($item->supply_id)->supply_type == 0) ? "Supply" : "Equipments";
            $count++;
        }

        $this->user = User::find($this->receipt->user_id);
    }


    public function send_message(){
        $this->validate([
            'message_content' => 'required|max:60'
        ],[
            'required' => 'Please enter Message.',
            'max' => '60 characters only.'
        ]);

        Messages::create([
            'user_id' => Auth::user()->id,
            'receipt_id' => $this->request,
            'message' => $this->message_content,
            'message_type' => 7
        ]);

        $this->notification([
            'title'       => 'Message Sent!',
            'description' => 'Message successfuly Sent!',
            'icon'        => 'success',
        ]);

    }

    public function render()
    {
        $this->messages = Messages::where('receipt_id',  $this->request)
        ->join('user', 'messages.user_id', 'user.id')
        ->select('messages.*', 'user.firstname', 'user.lastname')
        ->get();

        return view('livewire.view-request', ['messages' => $this->messages]);
    }

}
