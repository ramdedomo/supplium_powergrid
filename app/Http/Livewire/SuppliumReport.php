<?php

namespace App\Http\Livewire;

use Livewire\Component;
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
use Phpml\Regression\LeastSquares;

class SuppliumReport extends Component
{
    public $year;
    public $month;
    use WithPagination;
    public $getmonth;
    public $getyear;
    public $getpredict;

    public $predict;

    public function predict($time, $data, $target_time){
        $regression = new LeastSquares();
        $regression->train($time, $data);
        $testData = [$target_time];
        $prediction = $regression->predict($testData);
        return $prediction;
    }
 
    public function render()
    {

        if(!is_null($this->predict)){
            
            $years = range(Carbon::now()->subYear(3)->year, Carbon::now()->year);
            $supplies = Supply::all();
            $departments = Department::all();
            $test = [];

            foreach($years as $year){
                $totalcount = count($supplies);
                $count = 1;

                foreach($departments as $department){
                    $user_department = User::where('department', $department->department)->get();
                    $request_count = 0;
                    $request_count_supply = 0;
                    $request_count_equipments = 0;
                    foreach ($user_department as $user) {
                        $receipts = Receipt::where('user_id', $user->id)
                        ->whereYear('created_at', $year)
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

                    $test_department[$year][$department->department] = [
                        'request_count' => $request_count,
                        'request_count_equipments' => $request_count_equipments,
                        'request_count_supply' => $request_count_supply
                    ];
                }
                
                foreach($supplies as $supply){
                    $query = Requests::where('supply_id', $supply->id)
                    ->whereYear('created_at', $year)
                    ->count();
                    $test[$year][$supply->id] = $query;
                    $count++;
                }
            }

          
            $supply_full = [];
            foreach($test as $t){
                $count = 1;
                foreach($t as $key => $value){
                    $supply_full[$count][] = $value;
                    $count++;
                }
            }
            
            $supply_final_val = [];
            foreach($supply_full as $ful){
                $keys = [];
                foreach(array_keys($ful) as $key){
                    $keys[] = [$key];
                }
                $supply_final_val[] = round($this->predict($keys, array_values($ful), count($ful)+($this->predict-Carbon::now()->year)));
            }

            $department_full = [];
            foreach($test_department as $t){
                $count = 1;
                foreach($t as $key => $value){
                    $department_full[$count][] = $value;
                    $count++;
                }
            }


            $department_final_count = [];
            $department_final_equipment = [];
            $department_final_supply = [];

            foreach($department_full as $ful){
                $keys = [];
                $request_count = [];
                $request_count_equipments = [];
                $request_count_supply = [];

                foreach($ful as $key => $values){
                    $keys[] = [$key];
                    $request_count[] = $values['request_count'];
                    $request_count_equipments[] = $values['request_count_equipments'];
                    $request_count_supply[] = $values['request_count_supply'];
                }

                $department_final_count[] = round($this->predict($keys, array_values($request_count), count($ful)+($this->predict-Carbon::now()->year)));
                $department_final_equipment[] = round($this->predict($keys, array_values($request_count_equipments), count($ful)+($this->predict-Carbon::now()->year)));
                $department_final_supply[] = round($this->predict($keys, array_values($request_count_supply), count($ful)+($this->predict-Carbon::now()->year)));
            }

            $departments = Department::all();
            $count = 0;
            foreach($departments as $department){
                $department->request_count_supply = $department_final_count[$count];
                $department->request_count_equipments = $department_final_equipment[$count];
                $department->request_count = $department->request_count_supply+$department->request_count_equipments;
                $count++;
            }

            $supplies = Supply::all();
            $count = 0;
            foreach($supplies as $supply){
                $supply->request_count = $supply_final_val[$count];
                $supply->request_total = $supply_final_val[$count]*$supply->supply_price;
                $count++;
            }


            
        }else{
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
            foreach ($departments as $department) {
                $user_department = User::where('department', $department->department)->get();
                $request_count = 0;
                $request_count_supply = 0;
                $request_count_equipments = 0;
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

        $this->getpredict = [];
        foreach(range(Carbon::now()->addYear(1)->year, Carbon::now()->addYear(5)->year) as $year){
            $this->getpredict[$year] = ['year' => $year];
        }

                   
        function paginate($items, $perPage = 5, $page = null, $pageName = 'page')
        {
            $page = $page ?: (Paginator::resolveCurrentPage($pageName) ?: 1);
            $items = $items instanceof Collection ? $items : Collection::make($items);
            return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]);
        }

        function paginate2($items, $perPage = 5, $page = null, $pageName = 'page2')
        {
            $page = $page ?: (Paginator::resolveCurrentPage($pageName) ?: 1);
            $items = $items instanceof Collection ? $items : Collection::make($items);
            return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]);
        }


        return view('livewire.supplium-report', [
        'supplies' => paginate($supplies), 
        'departments' => paginate2($departments)
        ]);

    }
}
