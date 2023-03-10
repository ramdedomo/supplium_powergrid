<?php

namespace App\Http\Livewire;
use LivewireUI\Modal\ModalComponent;
use App\Models\Supply;
use App\Models\Requests;
use App\Models\User;
use App\Models\Bag;
use App\Models\Receipt;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Route;
use Request;
use Carbon\Carbon;
use App\Models\Notifications;
use App\Models\Messages;
use Barryvdh\DomPDF\Facade\Pdf;
class EditRequest extends ModalComponent
{


    use Actions;
    public $message_content;
    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function getreceipt(){
        $this->receipt = Receipt::where('receipt.id', $this->request)
        ->join('status', 'receipt.supply_status', '=', 'status.status')
        ->first();

        if($this->receipt->is_supply == 1){
            $this->requests = Receipt::where('receipt.id', $this->request)
            ->join('requests', 'receipt.id', '=', 'requests.receipt_id')
            ->get();
    
            $count = 0;
            foreach($this->requests as $item){
                $this->requests[$count]['supply_price'] = Supply::find($item->supply_id)->supply_price;
                $this->requests[$count]['supply_name'] = Supply::find($item->supply_id)->supply_name;
                $this->requests[$count]['supply_type'] = (Supply::find($item->supply_id)->supply_type == 0) ? "Supply" : "Equipments";
                $count++;
            }
    
            $userdetails = User::where('id', $this->receipt->user_id)
            ->join('department_type', 'user.department', '=', 'department_type.department')
            ->join('user_type', 'user.user_type', '=', 'user_type.user_type')
            ->select('user.*', 'user_type.role as usertype', 'department_type.department_description as userdepartment')
            ->first();
    
            $pdfContent = PDF::loadView('pdf', [
                'requests' => $this->requests,
                'receipt' => $this->receipt,
                'user_details' => $userdetails
            ])->output();
    
            return response()->streamDownload(
                fn () => print($pdfContent),
                "#".$this->request."_receipt.pdf"
            );
        }elseif($this->receipt->is_supply == 0){
            $this->requests = Receipt::where('receipt.id', $this->request)
            ->join('requests', 'receipt.id', '=', 'requests.receipt_id')
            ->get();
    
            $count = 0;
            foreach($this->requests as $item){
                $this->requests[$count]['supply_price'] = Supply::find($item->supply_id)->supply_price;
                $this->requests[$count]['supply_name'] = Supply::find($item->supply_id)->supply_name;
                $this->requests[$count]['supply_type'] = (Supply::find($item->supply_id)->supply_type == 0) ? "Supply" : "Equipments";
                $count++;
            }
    
            $userdetails = User::where('id', $this->receipt->user_id)
            ->join('department_type', 'user.department', '=', 'department_type.department')
            ->join('user_type', 'user.user_type', '=', 'user_type.user_type')
            ->select('user.*', 'user_type.role as usertype', 'department_type.department_description as userdepartment')
            ->first();
    
            $pdfContent = PDF::loadView('par', [
                'requests' => $this->requests,
                'receipt' => $this->receipt,
                'user_details' => $userdetails
            ])->output();
    
            return response()->streamDownload(
                fn () => print($pdfContent),
                "#".$this->request."_receipt.pdf"
            );
        }else{
            $this->requests = Receipt::where('receipt.id', $this->request)
            ->join('requests', 'receipt.id', '=', 'requests.receipt_id')
            ->get();
    
            $supply_list = [];
            $equipment_list = [];

            foreach($this->requests as $item){
                if(Supply::find($item->supply_id)->supply_type == 0){
                    $supply_list[] = [
                       'supply' => Supply::find($item->supply_id),
                       'qty' => $item->quantity
                    ];
                }else{
                    $equipment_list[] = [
                        'supply' => Supply::find($item->supply_id),
                        'qty' => $item->quantity
                     ];
                }
            }

            //todo: edit ppmp pdf content
            $pdfContent = PDF::loadView('ppmp', [
                'supplies' => $supply_list,
                'equipments' => $equipment_list,
                'receipt' => "#".$this->request."_ppmp.pdf"
            ])->setPaper('a4', 'landscape')->output();

            return response()->streamDownload(
                fn () => print($pdfContent),
                "#".$this->request."_ppmp.pdf"
            );


        }

    
    }

    public function accept_confirm(){
        
        $status = null;
        $exists = Notifications::where('receipt_id', $this->request)->first();

        if($this->receipt->is_supply == 1){

            switch ($this->receipt->supply_status) {
                case 0:
                    $status = 4;
          
                    Receipt::where('id', $this->request)->update([
                        'supply_status' => $status,
                        'supply_at' => Carbon::now()
                    ]); 

                         
                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 3,
                        'is_supply' => 1
                    ]);   

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 4,
                        'is_supply' => 1
                    ]);   

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $exists->receipt_id,
                        'message_type' => 3
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $exists->receipt_id,
                        'message_type' => 4
                    ]);

             
                    break;
                case 4:
                    $status = 5;
                    Receipt::where('id', $this->request)->update([
                        'supply_status' => $status,
                        'done_at' => Carbon::now()
                    ]);

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 6,
                        'is_supply' => 1
                    ]);   

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $exists->receipt_id,
                        'message_type' => 6
                    ]);

                    break;
            }

        }else{

            switch ($this->receipt->supply_status) {
                case 0:
                    if(Department::find(Auth::user()->department)->nonteaching == 0){
                        $status = 1;
          
                        Receipt::where('id', $this->request)->update([
                            'supply_status' => $status,
                            'chair_at' => Carbon::now()
                        ]);
    
                        Notifications::create([
                            'user_id' => $exists->user_id,
                            'receipt_id' => $exists->receipt_id,
                            'notification_type' => 102,
                            'is_supply' => 0
                        ]);   
    
                        Notifications::create([
                            'user_id' => $exists->user_id,
                            'receipt_id' => $exists->receipt_id,
                            'notification_type' => 1,
                            'is_supply' => 0
                        ]);   
    
                        Messages::create([
                            'user_id' => Auth::user()->id,
                            'receipt_id' => $exists->receipt_id,
                            'message_type' => 1
                        ]);
                    }else{
                        $status = 6;
          
                        Receipt::where('id', $this->request)->update([
                            'supply_status' => $status,
                            'head_at' => Carbon::now()
                        ]);
    
                        Notifications::create([
                            'user_id' => $exists->user_id,
                            'receipt_id' => $exists->receipt_id,
                            'notification_type' => 105,
                            'is_supply' => 0
                        ]);   
    
                        Notifications::create([
                            'user_id' => $exists->user_id,
                            'receipt_id' => $exists->receipt_id,
                            'notification_type' => 9,
                            'is_supply' => 0
                        ]);   
    
                        Messages::create([
                            'user_id' => Auth::user()->id,
                            'receipt_id' => $exists->receipt_id,
                            'message_type' => 9
                        ]);
    
                    }
                 
        
                    break;
                case 1:
                    $status = 2;
                    Receipt::where('id', $this->request)->update([
                        'supply_status' => $status,
                        'dean_at' => Carbon::now()
                    ]);

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 2,
                        'is_supply' => 0
                    ]);   
     
                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $exists->receipt_id,
                        'message_type' => 2
                    ]);

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 105,
                        'is_supply' => 0
                    ]);   

                    break;

                case 2:
                    $status = 3;
                    Receipt::where('id', $this->request)->update([
                        'supply_status' => $status,
                        'ced_at' => Carbon::now()
                    ]);

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 103,
                        'is_supply' => 0
                    ]);   

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 8,
                        'is_supply' => 0
                    ]);   
     
                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $exists->receipt_id,
                        'message_type' => 8
                    ]);
                    break;
                case 3:
                    $status = 4;
                    Receipt::where('id', $this->request)->update([
                        'supply_status' => $status,
                        'supply_at' => Carbon::now()
                    ]);

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 4,
                        'is_supply' => 0
                    ]);   

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 3,
                        'is_supply' => 0
                    ]);   
     
                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $exists->receipt_id,
                        'message_type' => 4
                    ]);

                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $exists->receipt_id,
                        'message_type' => 3
                    ]);

                    break;
                case 6:
                    $status = 3;
                    Receipt::where('id', $this->request)->update([
                        'supply_status' => $status,
                        'ced_at' => Carbon::now()
                    ]);

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 103,
                        'is_supply' => 0
                    ]);   

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 8,
                        'is_supply' => 0
                    ]);   
     
                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $exists->receipt_id,
                        'message_type' => 8
                    ]);
                    break;
                case 4:
                    $status = 5;
                    Receipt::where('id', $this->request)->update([
                        'supply_status' => $status,
                        'done_at' => Carbon::now()
                    ]);

                    Notifications::create([
                        'user_id' => $exists->user_id,
                        'receipt_id' => $exists->receipt_id,
                        'notification_type' => 6,
                        'is_supply' => 0
                    ]);   
                    
                    Messages::create([
                        'user_id' => Auth::user()->id,
                        'receipt_id' => $exists->receipt_id,
                        'message_type' => 6
                    ]);

                    break;
                    
              }

        }


        if($status == 5){
            $this->dialog()->show([
                'title'       => 'Request Done!',
                'description' => 'The Request is Succesfully Receive!',
                'icon'        => 'success',
            ]);
        }else{
            $this->notification([
                'title'       => 'Request Accepted!',
                'description' => 'The Request is Succesfully Accepted!',
                'icon'        => 'success',
                'iconColor'   => 'text-amber-500'
            ]);
        }


        $this->closeModal();
        $this->emit('itemUpdated');

    }

    public function accept(){

        if($this->receipt->supply_status == 4){
            $this->dialog()->confirm([
                'title'       => 'Are you Sure?',
                'description' => 'Complete this Request?',
                'icon'        => 'question',
                'accept'      => [
                    'label'  => 'Yes, Accept',
                    'method' => 'accept_confirm',
                ],
                'reject' => [
                    'label'  => 'No, cancel',
                ],
            ]);
        }else{
            $this->dialog()->confirm([
                'title'       => 'Are you Sure?',
                'description' => 'Accept this Request?',
                'icon'        => 'question',
                'accept'      => [
                    'label'  => 'Yes, Accept',
                    'method' => 'accept_confirm',
                ],
                'reject' => [
                    'label'  => 'No, cancel',
                ],
            ]);
        }



    }

    public function cancel_confirm(){
        //todo: return the decremented value
        Receipt::where('id', $this->request)->update([
            'supply_status' => 7,
            'canceled_at' => Carbon::now()
        ]);

        $supplies = Requests::where('receipt_id', $this->request)->get();
        foreach($supplies as $supply){
            Supply::find($supply->supply_id)->increment('supply_stocks', $supply->quantity);
        }

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
        ->join('requests', 'receipt.id', '=', 'requests.receipt_id')
        ->get();

        $count = 0;
        foreach($this->requests as $item){
            $this->requests[$count]['supply_photo'] = Supply::find($item->supply_id)->supply_photo;
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

        return view('livewire.edit-request');
    }
}
