<div class="border-b-4 border-amber-500 rounded-md">

    <x-card title="Download Reports">
        <p class="text-gray-600">

            <x-errors class="mb-3" />


        <div class="gap-3 flex">
            <div class="w-1/2">
                <x-select 
                searchable="false"
                placeholder="Month" 
                :options="$getmonth"
                option-label="month"
                option-value="value"
                wire:model="month" />
            </div>
            <div class="w-1/2">
                <x-select 
                searchable="false"
                placeholder="Year" 
                :options="$getyear"
                option-label="year"
                option-value="year"
                wire:model="year" />
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button wire:click="$emit('closeModal')" label="Close" />
                <x-button wire:click="download" primary label="Download" />
            </div>
        </x-slot>

    
        </p>
    </x-card>

</div>
