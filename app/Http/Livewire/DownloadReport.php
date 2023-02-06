<?php

namespace App\Http\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;
use App\Models\Supply;
use App\Models\Requests;
use App\Models\User;
use App\Models\Receipt;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
class DownloadReport extends ModalComponent
{
    public $year;
    public $month;
    
    public function download(){

        $departments = null;
        $supplies = null;

        $this->validate([
            'year' => 'required',
            'month' => 'required'
        ]);

        $supplies = Supply::all();
        foreach ($supplies as $supply) {
           $query = Requests::where('supply_id', $supply->id)
           ->when(true, function ($query) {
                if($this->month == 0){
                    $query->whereYear('created_at', $this->year);
                }else{
                    $query->whereMonth('created_at', $this->month)
                          ->whereYear('created_at', $this->year);
                }
            });
         
            
            $supply->request_count = $query->count();
            $supply->request_total = $query->count()*$supply->supply_price;
            $supply->total = $supply->request_count*$supply->supply_price;
        }


        $departments = Department::all();
        foreach ($departments as $department) {
            $user_department = User::where('department', $department->department)->get();
            $request_count = 0;
            $request_count_supply = 0;
            $request_count_equipments = 0;
            foreach ($user_department as $user) {
                $receipts = Receipt::where('user_id', $user->id)
                ->when(true, function ($query) {
                    if($this->month == 0){
                        $query->whereYear('created_at', $this->year);
                    }else{
                        $query->whereMonth('created_at', $this->month)
                              ->whereYear('created_at', $this->year);
                    }
                })
                ->get(); 

                    foreach($receipts as $receipt){
                        if($receipt->is_supply){
                            $request_count_supply += Requests::where('receipt_id', $receipt->id)->count();
                        }else{
                            $request_count_equipments += Requests::where('receipt_id', $receipt->id)->count();
                        }
                        $request_count += Requests::where('receipt_id', $receipt->id)->count();
                    }
            }
        
            $department->request_count = $request_count;
            $department->request_count_supply = $request_count_supply;
            $department->request_count_equipments = $request_count_equipments;
        }

        $report_details = null;

        if($this->month == 0){
            $report_details = $this->year;
        }else{
            $report_details = $this->month.".".$this->year;
        }

        $pdfContent = PDF::loadView('pdf_report', [
            'departments' => $departments,
            'supplies' => $supplies,
            'report_details' => $report_details
        ])->output();

        if($this->month == 0){
            return response()->streamDownload(
                fn () => print($pdfContent),
                "".$this->year."_reports.pdf"
            );
        }else{
            return response()->streamDownload(
                fn () => print($pdfContent),
                "".$this->month.".".$this->year."_reports.pdf"
            );
        }

    }

    public function render()
    {
        $this->getmonth = [
            ['value' => 0, 'month' => 'Whole Year'],
            ['value' => 1, 'month' => 'Janunary'],
            ['value' => 2, 'month' => 'February'],
            ['value' => 3, 'month' => 'March'],
            ['value' => 4, 'month' => 'April'],
            ['value' => 5, 'month' => 'May'],
            ['value' => 6, 'month' => 'June'],
            ['value' => 7, 'month' => 'July'],
            ['value' => 8, 'month' => 'August'],
            ['value' => 9, 'month' => 'September'],
            ['value' => 10, 'month' => 'October'],
            ['value' => 11, 'month' => 'November'],
            ['value' => 12, 'month' => 'December'],
        ];

        $this->getyear = [];
        foreach(Requests::all() as $request){
            $this->getyear[Carbon::parse($request->created_at)->year] = ['year' => Carbon::parse($request->created_at)->year];
        }

        return view('livewire.download-report');
    }
}
