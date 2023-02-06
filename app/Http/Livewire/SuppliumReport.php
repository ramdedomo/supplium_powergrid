<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Supply;
use App\Models\Requests;
use App\Models\User;
use App\Models\Receipt;
use App\Models\Department;
use Carbon\Carbon;
class SuppliumReport extends Component
{
    public $year;
    public $month;

    public $getmonth;
    public $getyear;

    public function get(){
        dd($this->year,$this->month);
    }
    

    public function render()
    {

        $supplies = Supply::all();
        foreach ($supplies as $supply) {
           $query = Requests::where('supply_id', $supply->id)
            ->when(empty($this->month), function ($query) {
                $query->whereMonth('created_at', Carbon::now()->month);
            })
            ->when(empty($this->year), function ($query) {
                $query->whereYear('created_at', Carbon::now()->year);
            })
            ->when(!empty($this->year), function ($query) {
                $query->whereYear('created_at', $this->year);
            })
            ->when(!empty($this->month), function ($query) {
                if($this->month == 0){
                    if(empty($this->year)){
                        $query->whereYear('created_at', Carbon::now()->year);
                    }else{
                        $query->whereYear('created_at', $this->year);
                    }
                }else{
                    $query->whereMonth('created_at', $this->month);
                }
            });
            
            $supply->request_count = $query->count();
            $supply->request_total = $query->count()*$supply->supply_price;
            $supply->total = $supply->request_count*$supply->supply_price;
        }


        $departments = Department::all();
        //department name
        //department type
        //total request
        foreach ($departments as $department) {
            $user_department = User::where('department', $department->department)->get();
            $request_count = 0;

            foreach ($user_department as $user) {
                $receipts = Receipt::where('user_id', $user->id)
                ->when(empty($this->year), function ($query) {
                    $query->whereYear('created_at', Carbon::now()->year);
                })
                ->when(!empty($this->year), function ($query) {
                    $query->whereYear('created_at', $this->year);
                })
                ->when(empty($this->month), function ($query) {
                    $query->whereMonth('created_at', Carbon::now()->month);
                })
                ->when(!empty($this->month), function ($query) {
                    if($this->month == 0){
                        if(empty($this->year)){
                            $query->whereYear('created_at', Carbon::now()->year);
                        }else{
                            $query->whereYear('created_at', $this->year);
                        }
                    }else{
                        $query->whereMonth('created_at', $this->month);
                    }
                })
                ->get(); 

                    foreach($receipts as $receipt){
                        $request_count += Requests::where('receipt_id', $receipt->id)->count();
                    }
            }

            $department->request_count = $request_count;
        }



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


        return view('livewire.supplium-report', ['supplies' => $supplies, 'departments' => $departments]);
    }
}
