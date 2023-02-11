<?php

namespace App\Http\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\Supply;
use Carbon\Carbon;
use App\Models\Receipt;
use App\Models\Notifications;
use App\Models\Messages;
use App\Models\Requests;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class AddRequestQty extends ModalComponent
{
    public $supplies = [];
    public $supplies_details_supply;
    public $supplies_details_equipment;
    public $qty;

    public function mount($supplies){
        $this->supplies = $supplies;
        foreach($this->supplies as $supply){
            if(Supply::find($supply)->supply_type == 0){
                $this->supplies_details_supply[] = [
                    'id' => $supply,
                    'supply_name' => Supply::find($supply)->supply_name ?? ''
                ];
            }else{
                $this->supplies_details_equipment[] = [
                    'id' => $supply,
                    'supply_name' => Supply::find($supply)->supply_name ?? ''
                ];
            }
        }
    }

    public function add(){
        $qty_validate = [];
        $qty_validate_msg = [];
        foreach($this->supplies as $supply){
            $qty_validate += ['qty.'.$supply => 'required'];
            $qty_validate_msg += ['qty.'.$supply => strtolower(Supply::find($supply)->supply_name.' Quantity Required.')];
        }

        $this->validate($qty_validate,$qty_validate_msg);

        if(!is_null($this->supplies)){
            $receipt = Receipt::create([
                'user_id' => Auth::user()->id,
                'supply_status' => 5,
                'accepted_at' => Carbon::now(),
                'chair_at' => Carbon::now(),
                'dean_at' => Carbon::now(),
                'supply_at' => Carbon::now(),
                'done_at' => Carbon::now(),
                'ced_at' => Carbon::now(),
                'is_supply' => 3
            ])->id;

            Notifications::create([
                'user_id' => Auth::user()->id,
                'receipt_id' => $receipt,
                'notification_type' => 10,
                'is_supply' => 3
            ]);

            Notifications::create([
                'user_id' => Auth::user()->id,
                'receipt_id' => $receipt,
                'notification_type' => 110,
                'is_supply' => 3
            ]);

            Messages::create([
                'user_id' => Auth::user()->id,
                'receipt_id' => $receipt,
                'message_type' => 10
            ]);
            
            foreach($this->supplies as $supply){
                Requests::create([
                    'supply_id' => $supply,
                    'receipt_id' => $receipt,
                    'quantity' => $this->qty[$supply],
                ]);
            }

            $supply_list = [];
            $equipment_list = [];

            foreach($this->supplies as $supply){
                if(Supply::find($supply)->supply_type == 0){
                    $supply_list[] = [
                       'supply' => Supply::find($supply),
                       'qty' => $this->qty[$supply]
                    ];
                }else{
                    $equipment_list[] = [
                        'supply' => Supply::find($supply),
                        'qty' => $this->qty[$supply]
                     ];
                }
            }
        }

        $this->emit('itemRequested');
        $this->forceClose()->closeModal();

        //todo: edit ppmp pdf content
        $pdfContent = PDF::loadView('ppmp', [
            'supplies' => $supply_list,
            'equipments' => $equipment_list,
            'receipt' => "#".$receipt."_ppmp.pdf"
        ])->setPaper('a4', 'landscape')->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            "#".$receipt."_ppmp.pdf"
        );
        
        // dd($this->qty, $this->supplies);
    }
    
    public function render()
    {
        return view('livewire.add-request-qty');
    }
}
