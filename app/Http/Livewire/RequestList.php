<?php

namespace App\Http\Livewire;

use App\Models\Receipt;
use App\Models\Status;
use App\Models\Department;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};
use Illuminate\Support\Facades\Auth;
use DB;

final class RequestList extends PowerGridComponent
{
    use ActionButton;
    //
    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */

    protected function getListeners()
    {
        return [
            'pg:datePicker-'   .  $this->tableName  => 'datePikerChanged',
            'pg:editable-'     .  $this->tableName  => 'inputTextChanged',
            'pg:toggleable-'   .  $this->tableName  => 'inputTextChanged',
            'pg:multiSelect-'  .  $this->tableName  => 'multiSelectChanged',
            'pg:toggleColumn-' .  $this->tableName  => 'toggleColumn',
            'pg:eventRefresh-' .  $this->tableName  => '$refresh',
            'itemUpdated' => '$refresh',
        ];
    }


    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return Builder<\App\Models\Receipt>
    */
    public function datasource(): Builder
    {
        if(Auth::user()->department == 0){
            if(Auth::user()->user_type != 5){
                return Receipt::query()
                ->join('status', function ($categories) {
                    $categories->on('receipt.supply_status', '=', 'status.status');
                })
                ->join('user', function ($categories) {
                    $categories->on('receipt.user_id', '=', 'user.id');
                })
                ->join('department_type', function ($categories) {
                    $categories->on('user.department', '=', 'department_type.department');
                })
                ->orderBy('receipt.created_at', 'DESC')
                ->select([
                    DB::raw('CONCAT(user.firstname, " ", user.lastname) AS fullname'),
                    'department_type.department_description as department',
                    'receipt.*',
                    'status.*',
                ]);
            }else{
                return Receipt::query()
                ->join('status', function ($categories) {
                    $categories->on('receipt.supply_status', '=', 'status.status');
                })
                ->join('user', function ($categories) {
                    $categories->on('receipt.user_id', '=', 'user.id');
                })
                ->join('department_type', function ($categories) {
                    $categories->on('user.department', '=', 'department_type.department');
                })
                ->where('receipt.is_supply', 0)
                ->orderBy('receipt.created_at', 'DESC')
                ->select([
                    DB::raw('CONCAT(user.firstname, " ", user.lastname) AS fullname'),
                    'department_type.department_description as department',
                    'receipt.*',
                    'status.*',
                ]);
            }
        }else{
            return Receipt::query()
            ->join('status', function ($categories) {
                $categories->on('receipt.supply_status', '=', 'status.status');
            })
            ->join('user', function ($categories) {
                $categories->on('receipt.user_id', '=', 'user.id');
            })
            ->join('department_type', function ($categories) {
                $categories->on('user.department', '=', 'department_type.department');
            })
            ->where('user.department', Auth::user()->department)
            ->where('receipt.is_supply', 0)
            ->orderBy('receipt.created_at', 'DESC')
            ->select([
                DB::raw('CONCAT(user.firstname, " ", user.lastname) AS fullname'),
                'department_type.department_description as department',
                'receipt.*',
                'status.*',
            ]);
        }

    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ??? IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')

            ->addColumn('department')


            ->addColumn('created_at')

           /** Example of custom column using a closure **/
            // ->addColumn('created_at_lower', function (Receipt $model) {
            //     return strtolower(e($model->created_at));
            // })

            ->addColumn('updated_at')
            ->addColumn('supply_status')
            ->addColumn('user_id')

            ->addColumn('created_at_formatted', function (Receipt $model) {
                return date_format(Carbon::parse($model->created_at), 'M/d h:i A');
            })
            ->addColumn('updated_at_formatted', function (Receipt $model) {
                return date_format(Carbon::parse($model->updated_at), 'M/d h:i A');
            })

            ->addColumn('created_at')
            ->addColumn('updated_at');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('RECEIPT', 'id')
            ->searchable(),

            Column::make('DEPARTMENT', 'department')
            ->makeInputSelect(
                Department::all(),
                'department_description', //role from usertype
                'department_description' //role from select all
            )
            ->searchable(),

            Column::make('NAME', 'fullname'),

            Column::make('PLACED', 'created_at_formatted')
            ->makeInputDatePicker('created_at')
            ->sortable()
            ->searchable(),

            Column::make('LAST UPDATED', 'updated_at_formatted')
            ->makeInputDatePicker('updated_at')
            ->sortable()
            ->searchable(),

            Column::make('SUPPLY STATUS', 'status_desc')
            ->makeInputSelect(
                Status::all(),
                'status_desc', //role from usertype
                'status_desc' //role from select all
            ),
        ]
    ;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid Receipt Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
       return [
        Button::add('edit')
        ->caption('<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
      </svg>')
        ->class('outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-2 py-2 text-slate-500 hover:bg-slate-100 ring-slate-200 dark:ring-slate-600 dark:border-slate-500
        dark:ring-offset-slate-800 dark:text-slate-400 dark:hover:bg-slate-700')
        ->openModal('edit-request', ["request" => 'id']),
        //    Button::make('edit', 'Edit')
        //        ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
        //        ->route('receipt.edit', ['receipt' => 'id']),

        //    Button::make('destroy', 'Delete')
        //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
        //        ->route('receipt.destroy', ['receipt' => 'id'])
        //        ->method('delete')
        ];
    }


    public function header(): array
    {
        if(Auth::user()->user_type != 1 && Auth::user()->user_type != 4){
        return [
            Button::add('add')
                ->caption('PPMP')
                ->class('font-bold inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     bg-white border text-slate-500 hover:bg-slate-50 ring-slate-200
                dark:text-slate-200 dark:ring-slate-700 dark:border-slate-700
                dark:bg-slate-700 dark:hover:bg-slate-600 dark:hover:ring-slate-600
                dark:ring-offset-slate-800')
                ->openModal('add-request', []),

            Button::add(''),
                
            //...
        ];
     }else{
        return [];
     }
    }
    

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid Receipt Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($receipt) => $receipt->id === 1)
                ->hide(),
        ];
    }
    */
}
