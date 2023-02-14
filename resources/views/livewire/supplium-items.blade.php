<div>


    <livewire:csv-importer :model="App\Models\Supply::class" 
    :columnsToMap="['supply_type', 'supply_name', 'supply_stocks', 'supply_price']"
    :columnLabels="['supply_type' => 'Type', 'supply_name' => 'Name', 'supply_stocks' => 'Stocks', 'supply_price' => 'Price']"
    />

    <div>
        <div class="p-2 bg-gray-800 rounded-lg mb-2 flex items-center font-bold text-white border-b-4 border-amber-500">
            <div class="flex">
                <x-icon name="collection" class="w-5 h-5 mr-2" /> Items and Supplies
            </div>
        </div>
    
        <div class="p-2 bg-gray-100 rounded-lg  border-b-4 border-gray-800">
            <livewire:supplies/>
        </div>
    </div>
</div>
