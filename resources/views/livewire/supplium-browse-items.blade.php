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

    <div class="h-full">
        <div class="p-2 bg-gray-800 rounded-lg mb-3 flex items-center font-bold text-white border-b-4 border-amber-500">
            <x-icon name="archive" class="w-5 h-5 mr-2" /> Items
        </div>

        <div class="flex justify-between bg-gray-100 rounded-md p-2">
            <div class="flex gap-2">
                <x-select placeholder="Type" :options="['Supplies', 'Equipments']" wire:model="type" />
                <x-select  placeholder="Sort" :options="['A-Z', 'Z-A', 'Low - High', 'High - Low']" wire:model="sort" />
            </div>
            <div>
                <x-input wire:model="search" class="" placeholder="Search" />
            </div>
        </div>

        @if($supplies->isEmpty())
            <div class="mt-4 text-center p-5 rounded-md border-b-4 border-gray-800 bg-gray-100 text-gray-400">
                Empty
            </div>
        @endif

        <div class="grid grid-cols-4 gap-4 mt-4">
 

            @foreach ($supplies as $supply)
                <a 
                    wire:click="$emit('openModal', 'supply-order', {{ json_encode(['supply' => $supply->id]) }})"
                    class="transition bg-cover bg-center bg-no-repeat ease-in-out hover:scale-105 relative block overflow-hidden rounded-xl border-b-4"
                    style="border-color: {{ $supply->supply_color }}; background-image: url({{Storage::url($supply->supply_photo)}})">
                    <div class="bg-gray-800 bg-opacity-70">
                        <div class="p-5">
                            <span class="font-mono px-2 rounded-full"
                                style="background-color: {{ $supply->supply_color }}">
                                {{ $supply->supply_stocks }}
                            </span>

                        </div>

                        <div class="p-14 text-white relative">
                            <div class="absolute bottom-0 left-0 p-5">
                                <h3 class="text-2xl font-bold">{{ $supply->supply_name }}</h3>
                                <p class="text-sm">{{ $supply->supplyname }}</p>
                            </div>

                        </div>
                    </div>
                </a>
            @endforeach

        </div>

        <div class="mt-5">
            {{ $supplies->links() }}
        </div>

    </div>


    
</div>


{{-- <a href="#" class="relative block overflow-hidden rounded-xl bg-[url(https://images.unsplash.com/photo-1585336261022-680e295ce3fe?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80)] bg-cover bg-center bg-no-repeat">
                <div class="relative bg-black bg-opacity-30p-8 pt-20 text-white">
                    <h3 class="text-2xl font-bold">Pen</h3>
                    <p class="text-sm">Equipment</p>
                </div>
            </a> --}}
