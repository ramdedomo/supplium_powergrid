<div class="border-b-4 border-amber-500 rounded-md">

    <x-card title="Edit {{$department->department_short}}">
        <p class="text-gray-600">

            <x-errors class="mb-3" />

            <div class="mb-3 flex items-center p-4 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-amber-50">
                <svg class="flex-shrink-0 w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-amber-500">
                Note: Once there's a user that are linked to a Department you cannot Enable\Disable <b>Non-Teaching</b>.
                </div>
            </div>

        <x-input wire:model.defer="department_full" right-icon="user-group" class="mb-3" label="Department"
            placeholder="" />


        
        
        <div class="gap-3 flex">
            <div class="w-3/4">
                <x-input wire:model.defer="department_short" label="Short Form"
                placeholder="" />
            </div>

            <div class="w-1/4 flex justify-center items-center mt-5">
                @if(!$hasuser)
                    <x-toggle label="Non-Teaching" wire:model.defer="nonteach"/>
                @else
                <div class="text-xs text-center">
                    Users exists. <b>Non-teaching disabled</b>.
                </div>
                    
                @endif
            </div>

        </div>



        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div>
                    <x-button wire:click="delete" label="Delete" />
                </div>
                <div>
                    <x-button wire:click="$emit('closeModal')" label="Close" />
                    <x-button wire:click="update" primary label="Update" />
                </div>
            </div>
        </x-slot>
    
        </p>
    </x-card>

</div>
