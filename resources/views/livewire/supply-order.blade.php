<div class="border-b-4 border-amber-500 rounded-md">
    
    <x-card title="Request {{$supply_name}}">
        <p class="text-gray-600">

            <div class="mb-3 grid grid-cols-3 gap-2">
                <div class="col-span-2">
                    <x-inputs.number  min="0" max="{{$supply_stocks}}" wire:model.defer="quantity" right-icon="archive" label="Quantity" />
                </div>
                <div>
                    <x-input right-icon="archive" label="Available Stock" value="{{$supply_stocks}}" disabled />
                </div>
             
            </div>
        </p>

 
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                
                <div>
                    <x-button wire:click="$emit('closeModal')" label="Close" />
                </div>
                
                <div>
                    <x-button icon="shopping-bag" wire:click="cart" primary label="To Bag" />
                    <x-button icon="paper-airplane" wire:click="request" primary label="Request" />
                </div>

            </div>
        </x-slot>
    </x-card>



</div>
