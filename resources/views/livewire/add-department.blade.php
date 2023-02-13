<div class="border-b-4 border-amber-500 rounded-md">

    <x-card title="Add Department">
        <p class="text-gray-600">
            

            <x-errors class="mb-3" />

        <x-input wire:model.defer="department_full" right-icon="user-group" class="mb-3" label="Department"
        placeholder="Ex. College of Computing"  />

        <div class="gap-3 flex">
            <div class="w-3/4">
                <x-input wire:model.defer="department_short" label="Tags"
                placeholder="Ex. Computing" />
            </div>
            <div class="w-1/4 flex justify-center items-center mt-5">
                <x-toggle label="Non-Teach" wire:model.defer="nonteach" />
            </div>
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
