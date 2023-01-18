<div class="border-b-4 border-amber-500 rounded-md">


    <x-card title="{{$userdetails->firstname . ' ' . $userdetails->lastname}}">
        <p class="text-gray-600">


            <div class="grid grid-cols-2 gap-3">
                <x-input wire:model.defer="userfirstname" right-icon="identification" class="mb-3 grid-cols-1" label="Firstname" placeholder="" />
                <x-input wire:model.defer="userlastname" right-icon="identification" class="mb-3 grid-cols-1" label="Lastname" placeholder="" />
            </div>


            <x-select
            wire:model="usertype"
            class="w-full mb-3"
            right-icon="collection"
            label="User Type"
            placeholder="Select"
            :options='$usertype_' 
            option-label="role"
            option-value="user_type"
            />

            {{-- <x-select wire:model="usertype" class="w-full mb-3" right-icon="collection" label="User Type"
            placeholder="Select" :options="['User', 'Dean', 'Chair']" /> --}}
      
            <div class="grid grid-cols-2 gap-3">
                <x-input wire:model.defer="email" right-icon="at-symbol" class="grid-cols-1" label="Email" placeholder="" />
         
                @if(Auth::user()->user_type == 1)
                    <x-select 
                    wire:model="department"
                    class="grid-cols-1"
                    right-icon="user-group" 
                    label="Department"
                    placeholder="Department" 
                    :options='$department_'
                    option-label="department_short"
                    option-value="department"
                    />
                @else
                    <x-input wire:model="department_.department" right-icon="" class="grid-cols-1" label="Department" disabled/>
                @endif

            </div>
             

         
                 <hr class="my-3">

                 <x-errors class="mb-3"/>
                   
                <x-button 
                    class="w-full"
                    wire:click="changepassword"
                    icon="cog"
                    label="Change Password"
                    x-on:click="$wireui.confirmDialog({
                        id: 'changepassword',
                        icon: 'question',
                        accept: {
                            label: 'Save',
                            execute: () => {
                                @this.newpassword = document.getElementById('newpassword').value
                                @this.saved()
                            }
                        },
                        reject: {
                            label: 'Cancel',
                        }
                    })"
                />

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
