<div>
    <x-modal wire:model.defer="simpleModal" align="center">
        <x-card title="Consent Terms">
            <p class="text-gray-600">
                Lorem Ipsum...
            </p>
     
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="I Agree" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
    
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
