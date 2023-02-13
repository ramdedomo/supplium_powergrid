<div class="border-b-4 border-amber-500 rounded-md">
    
        <x-card title="Edit {{$supply_details->supply_name}}">
            <p class="text-gray-600">

                <div class="grid grid-cols-3 gap-3 mb-3">
                    <x-input wire:model.defer="itemname" right-icon="document" class="grid-cols-1" label="Name" placeholder="" />
                    <x-color-picker wire:model.defer="itemcolor" class="grid-cols-1" label="Select Color" placeholder="Select Color" />
                    <x-input wire:model.defer="itemunit" right-icon="archive" class="grid-cols-1" label="Unit" placeholder="Ex. Box, Ream" />
                </div>
           
                <div class="grid grid-cols-4 mb-3 gap-3 p-4 bg-gray-50 border-2 border-gray-200 rounded-lg">
                    <div class="col-span-3">
                        <x-input wire:model="itemphoto" type="file" label="Supply Photo (Optional)"/>
                    </div>
            
                    <div class="flex col-span-1 justify-end">


                    @if ($itemphoto)
                        @php
                            try {
                               $url = $itemphoto->temporaryUrl();
                               $photoStatus = true;
                            }catch (RuntimeException $exception){
                                $photoStatus =  false;
                            }
                        @endphp
                        @if($photoStatus)
                            <div style="background-image: url({{ $itemphoto->temporaryUrl() }})" class="flex items-center justify-center text-xs text-gray-400  border-2 w-full border-gray-200 rounded-md bg-cover bg-center bg-no-repeat">
                                <span wire:click="removephoto" class="bg-amber-500 rounded-md px-2 text-white hover:bg-amber-600 cursor-pointer transition ease-in-out">Remove</span>
                            </div>
                        @else
                            <div  class="flex items-center justify-center text-xs text-gray-400 border-2 w-full border-gray-200 rounded-md bg-cover bg-center bg-no-repeat">
                                Unsupported
                            </div>
                        @endif
                    @else

                        @if(is_null($currentphoto))
                            <div class="flex items-center justify-center text-xs text-gray-400 border-2 w-full border-gray-200 rounded-md bg-cover bg-center bg-no-repeat">
                                No Photo
                            </div>
                        @else
                            <div style="background-image: url({{Storage::url($currentphoto)}})" class="flex items-center justify-center text-xs text-gray-400 border-2 w-full border-gray-200 rounded-md bg-cover bg-center bg-no-repeat">
                                <span wire:click="removephoto" class="bg-amber-500 rounded-md px-2 text-white hover:bg-amber-600 cursor-pointer transition ease-in-out">Remove</span>
                             
                            </div>
                        @endif
      
                    @endif

                    </div>
                </div>
                
                <x-textarea wire:model.defer="itemdescription" label="Description (Optional)" class="mb-3" placeholder="add description here"/>

                <div class="grid grid-cols-3 mb-3 gap-3">
   
                    <x-inputs.number  wire:model.defer="itemstocks" right-icon="archive" label="Stock" />

                    <x-select
                        wire:model.defer="itemcategory"
                        class="w-full"
                        right-icon="collection" 
                        label="Category"
                        placeholder="Select"
                        :options="['Supply', 'Equipments']"
                    />

                    
                    <x-inputs.number wire:model.defer="itemprice" label="Price (PHP)" />
                </div>

                {{-- <div class="col-span-1 sm:col-span-2 cursor-pointer bg-gray-100 rounded-xl shadow-md h-72 flex items-center justify-center">
                    <div class="flex flex-col items-center justify-center">
                        
                        

                    </div>
                </div> --}}

            </p>

     
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
        </x-card>
  


</div>
