<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class Departments extends PowerGridComponent
{
    use ActionButton;
    public string $primaryKey = 'department';
    public string $sortField = 'department';
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
    * @return Builder<\App\Models\Department>
    */
    public function datasource(): Builder
    {

        return Department::query()
        ->where('department', '>', 0);


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
            // ->addColumn('department')
            // ->addColumn('department')
            ->addColumn('department_description')
            ->addColumn('department_short');
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
            // Column::make('DEPARTMENT', 'department')
            //     ->makeInputRange(),

            // Column::make('DEPARTMENT', 'department')
            //     ->makeInputRange(),

            Column::make('DEPARTMENT DESCRIPTION', 'department_description')
                ->sortable()
                ->searchable(),

            Column::make('DEPARTMENT SHORT', 'department_short')
                ->sortable()
                ->searchable(),

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
     * PowerGrid Department Action Buttons.
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
                ->openModal('edit-department', ["department" => 'department']),

        //    Button::make('destroy', 'Delete')
        //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
        //        ->route('department.destroy', ['department' => 'id'])
        //        ->method('delete')
        ];
    }

    public function header(): array
    {
        return [
            Button::add('add')
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
              </svg>')
                ->class('block bg-slate-50 text-slate-500 border border-slate-300 rounded py-1.5 px-3 leading-tight
                focus:outline-none focus:bg-white focus:border-slate-600 dark:border-slate-500 dark:bg-slate-700
                2xl:dark:placeholder-slate-300 dark:text-slate-200 dark:text-slate-300')
                ->openModal('add-department', []),

            Button::add(''),
                
            //...
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
     * PowerGrid Department Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($department) => $department->id === 1)
                ->hide(),
        ];
    }
    */
}
