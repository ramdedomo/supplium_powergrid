<div class="border-b-4 border-amber-500 rounded-md">

    <x-card title="Add Request">
        <p class="text-gray-600">

            <x-errors class="mb-3" />

        <div class="gap-3 flex">
            <x-select
                class="w-2/5"
                label="Select User"
                placeholder="Select User"
                :options='$users'
                option-label="fullname"
                option-value="id"
                option-description="usertype"
                wire:model="user"
            />

            <x-select
                class="w-2/5"
                label="Select Item"
                placeholder="Select Item"
                :options='$supplies'
                option-label="supply_name"
                option-value="id"
                option-description="supplytype"
                wire:model="supply"
            />

            <x-inputs.number min="0" wire:model="qty" label="Qty" />

        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button wire:click="$emit('closeModal')" label="Close" />
                <x-button wire:click="add" primary label="Add" />
            </div>
        </x-slot>

    
        </p>
    </x-card>

</div>
