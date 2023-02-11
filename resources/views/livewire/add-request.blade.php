<div class="border-b-4 border-amber-500 rounded-md">

    <x-card title="PPMP - Select Items">
        <p class="text-gray-600">

            <x-errors class="mb-3" />

                        
            <div class="mb-2">
                <x-select
                multiselect
                    class="col-span-2 w-full"
                    label="Select Item"
                    placeholder="Select Item"
                    :options='$supplies'
                    option-label="supply_name"
                    option-value="id"
                    option-description="supplytype"
                    wire:model="supply"
                />
            </div>
  
            <button class="w-full outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-sm px-4 py-2     border text-slate-500 hover:bg-slate-100 ring-slate-200
            dark:ring-slate-600 dark:border-slate-500 dark:hover:bg-slate-700
            dark:ring-offset-slate-800 dark:text-slate-400" wire:click='$emit("openModal", "add-request-qty", {{ json_encode(["supplies" => $supply]) }})'>Set Quantity</button>
      


        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button wire:click="$emit('closeModal')" label="Close" />
            </div>
        </x-slot>

    
        </p>
    </x-card>

</div>
