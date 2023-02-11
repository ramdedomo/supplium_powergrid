<div class="border-b-4 border-amber-500 rounded-md">

    <x-card title="PPMP - Enter Quantity">
        <p class="text-gray-600">

            <x-errors class="mb-3" />

            @if(empty($supplies[0]))
                <div class="mb-3 flex items-center p-4 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-gray-50">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-gray-500">
                    Tip: Please Select <b>Items</b> on the <b>Previous Selection</b>.
                    </div>
                </div>
            @else


            @if(!is_null($supplies_details_supply))
            <div class="mb-3 flex items-center px-4 py-2 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-gray-100">
                <div class="text-sm text-gray-600 font-bold">
                    Supplies
                    </div>
                </div>


                @foreach($supplies_details_supply as $details)
                <div class="flex justify-between  px-4 py-2 mb-3 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-gray-50 items-center">
                        <div>
                            {{$details['supply_name']}}
                        </div>
                        <div>
                            <x-inputs.number min="1" placeholder="Quantity" wire:model="qty.{{$details['id']}}"/>
                        </div>
                    </div>
                @endforeach
            @endif

            @if(!is_null($supplies_details_equipment))   
                <div class="mb-3 flex items-center px-4 py-2 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-gray-100">
                    <div class="text-sm text-gray-600 font-bold">
                    Equipments
                    </div>
                </div>

                @foreach($supplies_details_equipment as $details)
                <div class="flex justify-between px-4 py-2  mb-3 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-gray-50 items-center">
                        <div>
                            {{$details['supply_name']}}
                        </div>
                        <div>
                            <x-inputs.number min="1" placeholder="Quantity" wire:model="qty.{{$details['id']}}"/>
                        </div>
                    </div>
                @endforeach
            @endif

            @endif
  
  
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button wire:click="$emit('closeModal')" label="Go Back" />
                @if(empty($supplies[0]))
                <x-button disabled primary label="Confirm" />
                @else
                <x-button wire:click="add" primary label="Confirm" />
                @endif
            </div>
        </x-slot>

    
        </p>
    </x-card>

</div>
