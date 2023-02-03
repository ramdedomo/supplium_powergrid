<?php

namespace App\Http\Livewire;

use App\Models\Supply;
use App\Models\Requests;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class SupplyReport extends PowerGridComponent
{
    use ActionButton;
    
    protected function getListeners()
    {
        return [
            'pg:datePicker-'   .  $this->tableName  => 'datePikerChanged',
            'pg:editable-'     .  $this->tableName  => 'inputTextChanged',
            'pg:toggleable-'   .  $this->tableName  => 'inputTextChanged',
            'pg:multiSelect-'  .  $this->tableName  => 'multiSelectChanged',
            'pg:toggleColumn-' .  $this->tableName  => 'toggleColumn',
            'pg:eventRefresh-' .  $this->tableName  => '$refresh',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
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
    * @return Builder<\App\Models\Supply>
    */

    public function datasource(): Builder
    {
        $supplies = Supply::join('supply_type', function ($categories) {
                        $categories->on('supply.supply_type', '=', 'supply_type.supply_type');
                    })
                    ->select([
                        'supply.*',
                        'supply_type.supply_name as supply_type',
                    ])
                    ->withcount('requests');
 
        return $supplies;
            //DB::raw('COUNT(issue_subscriptions.issue_id) as followers')
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
            ->addColumn('requests_count')
            ->addColumn('id')
            // ->addColumn('supply_price')
            ->addColumn('supply_type')
            ->addColumn('supply_name')
            ->addColumn('supply_stocks')
            ->addColumn('created_at_formatted', fn (Supply $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (Supply $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'))
            ->addColumn('supply_desc')
            ->addColumn('supply_color');
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

            // Column::make('SUPPLY PRICE', 'supply_price')
            //     ->sortable()
            //     ->searchable(),

            Column::make('TYPE', 'supply_type')
                ->makeBooleanFilter('supply.supply_type', 'Equipments', 'Supply')
                ->searchable(),

            Column::make('NO. OF REQUEST', 'requests_count')
                ->makeInputDatePicker('created_at')
                ->searchable(),

            // Column::make('SUPPLY TYPE', 'supply_type')
            //     ->makeInputRange(),

            Column::make('SUPPLY NAME', 'supply_name')
                ->sortable()
                ->searchable(),

            Column::make('SUPPLY STOCKS', 'supply_stocks')
                ->makeInputRange(),


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
     * PowerGrid Supply Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('supply.edit', ['supply' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('supply.destroy', ['supply' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid Supply Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($supply) => $supply->id === 1)
                ->hide(),
        ];
    }
    */
}
