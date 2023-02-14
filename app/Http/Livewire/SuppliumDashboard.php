<?php

namespace App\Http\Livewire;
use Session;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\Receipt;
use App\Models\Department;
class SuppliumDashboard extends Component
{
 
    public $table1_labels;
    public $table1_date;
    
    public $table2_labels;
    public $table2_date;

    public $table3_labels;

    private function getData(string $table)
    {
        switch ($table) {

            case 'table1':
                $data = [];
                for ($i = 1; $i <= count($this->getLabels('table1')); $i++) {
                    $find = Carbon::now()->startOfMonth()->setDay($i)->format('Y-m-d');
                    $data[] = Receipt::whereBetween('created_at',  [Carbon::parse($find)->startOfDay(), Carbon::parse($find)->endOfDay()])->count();
                }

                return $data;

            case 'table2':

                $data = [];

                foreach(range(0, 1) as $type){
                    $data[] = Receipt::whereBetween('created_at',  
                    [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->where('is_supply', $type)
                    ->count();
                }

                return $data;

                break;

            case 'table3':
                $data = [];
                for ($i = 1; $i <= count($this->getLabels('table3')); $i++) {

                    $data[] = Receipt::join('user', 'user.id', '=', 'receipt.user_id')
                    ->where('user.department', $i)
                    ->count();

                }
    
                return $data;
        }
    }

    private function getLabels(string $table)
    {
        switch ($table) {
            case 'table1':

                $labels = [];
                //loop thru days
                foreach(
                    range(1, Carbon::now()
                    ->diffInDays(Carbon::now()
                    ->month(Carbon::now()->month)
                    ->startOfMonth())
                    ) as $day){
                    
                    $labels[] = $day;
                }
        
                return $labels;

            case 'table2':

                $labels = ['Supply', 'Equipments'];
                return $labels;

                break;

            case 'table3':
                $labels = [];

                foreach (Department::where('department', '>', 0)->get() as $department) {
                    $labels[] = $department->department_description;
                }

                return $labels;
    
                break;
        }
       
    }

    public function render()
    {
        $this->table1_labels = $this->getLabels('table1');
        $this->table1_data =  $this->getData('table1');

        $this->table2_labels = $this->getLabels('table2');
        $this->table2_data = $this->getData('table2');

        $this->table3_labels =  $this->getLabels('table3');
        $this->table3_data =  $this->getData('table3');
        return view('livewire.supplium-dashboard');
    }

}


