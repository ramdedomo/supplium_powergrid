<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};
use Illuminate\Support\Facades\Auth;

final class Users extends PowerGridComponent
{
    use ActionButton;

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
                
            Header::make()
            ->showSearchInput()
            ->showToggleColumns(),

            
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
    * @return Builder<\App\Models\User>
    */
    public function datasource(): Builder
    {
        
        if(Auth::user()->user_type == 1){
            return User::query()
            ->join('user_type', function ($categories) {
                $categories->on('user.user_type', '=', 'user_type.user_type');
            })
            ->where('user.id', '!=', Auth::user()->id)
            ->where('user.user_type', '!=', 1)
            ->select([
                'user.*',
                'user_type.role as role',
            ]);
        }else{
            return User::query()
            ->join('user_type', function ($categories) {
                $categories->on('user.user_type', '=', 'user_type.user_type');
            })
            ->where('user.user_type', '!=', 1)
            ->where('user.id', '!=', Auth::user()->id)
            ->where('user.department', Auth::user()->department)
            ->select([
                'user.*',
                'user_type.role as role',
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
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('role')
            ->addColumn('email')

           /** Example of custom column using a closure **/
            ->addColumn('email_lower', function (User $model) {
                return strtolower(e($model->email));
            })

            ->addColumn('updated_at')
            ->addColumn('created_at')
            ->addColumn('firstname')
            ->addColumn('lastname')
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
            Column::make('ROLE', 'role')
                ->makeInputSelect(
                    UserType::all(),
                    'role', //role from usertype
                    'role' //role from select all
                )

                ->searchable(),
                

            Column::make('EMAIL', 'email')
                ->searchable(),

            Column::add()
                ->field('firstname')
                ->hidden()
                ->searchable(),

            Column::add()
                ->field('lastname')
                ->hidden()
                ->searchable(),

            Column::make('UPDATED AT', 'updated_at')
                ->makeInputDatePicker('updated_at')
                ->sortable()
                ->searchable(),

            Column::make('CREATED AT', 'created_at')
                ->makeInputDatePicker('created_at')
                ->sortable()
                ->searchable(),



 

        ]
;
    }

    public function header(): array
    {
        return [
            Button::add('add')
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
              </svg>')
                ->class('outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     bg-white border text-slate-500 hover:bg-slate-50 ring-slate-200
                dark:text-slate-200 dark:ring-slate-700 dark:border-slate-700
                dark:bg-slate-700 dark:hover:bg-slate-600 dark:hover:ring-slate-600
                dark:ring-offset-slate-800')
                ->openModal('add-user', []),

            Button::add(''),
                
            //...
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid User Action Buttons.
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
        ->openModal('edit-user', ["user" => 'id']),

        // Button::add('info')
        // ->caption('<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        // <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        // </svg>')
        // ->class('outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-2 py-2 text-slate-500 hover:bg-slate-100 ring-slate-200 dark:ring-slate-600 dark:border-slate-500
        // dark:ring-offset-slate-800 dark:text-slate-400 dark:hover:bg-slate-700')
        // ->openModal('info-user', ["user" => 'id']),

        ];


    }
    

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid User Action Rules.
     *
     * @return array<int, RuleActions>
     */

    
    public function actionRules(): array
    {
       return [

            //Supply Admin = Red 1
            //User = Green 0
            //Dean = Indigo 2
            //Chair = Blue 3


           //Hide button edit for ID 1
        //    Rule::rows()
        //         ->when(function ($user) { 
        //             return $user->role == 'User';
        //         })->setAttribute('class', 'bg-green-100'),

        //     Rule::rows()
        //         ->when(function ($user) { 
        //             return $user->role == 'Supply Administrator';
        //         })->setAttribute('class', 'bg-red-100'),
            
        //     Rule::rows()
        //         ->when(function ($user) { 
        //             return $user->role == 'Dean';
        //         })->setAttribute('class', 'bg-indigo-100'),

        //     Rule::rows()
        //         ->when(function ($user) { 
        //             return $user->role == 'Chair';
        //         })->setAttribute('class', 'bg-amber-100'),

               
        ];
    }
    
}
