<div class="border-b-4 border-amber-500 rounded-md">


    <x-card title="{{ $userdetails->firstname . ' ' . $userdetails->lastname }}">
        <p class="text-gray-600">

            @if(Auth::user()->user_type == 1)
            <div class="shadow border w-full text-center justify-center font-mono text-xs p-2 rounded-md text-gray-500 bg-gray-100 mb-3">
                <span class="font-bold text-emerald-500">Note:</span>  If you selected a <span class="font-bold">Non-Teaching Department </span>you must select<span class="font-bold"> <span class="text-emerald-500">Head</span>  or <span class="text-emerald-500">User/Instructor</span>  on UserType</span>. When <span class="font-bold">Teaching Department </span>is selected you must select<span class="font-bold"> <span class="text-emerald-500">Dean</span>, <span class="text-emerald-500">Chairman</span> or <span class="text-emerald-500">User/Instructor</span> on UserType</span>.
            </div>
            @endif

             <x-errors class="mb-3" />

        <div class="grid grid-cols-2 gap-3">
            <x-input wire:model.defer="userfirstname" right-icon="identification" class="mb-3 grid-cols-1" label="Firstname"
                placeholder="" />
            <x-input wire:model.defer="userlastname" right-icon="identification" class="mb-3 grid-cols-1"
                label="Lastname" placeholder="" />
        </div>

        @if($userdetails->user_type == 5)
        <div class="mb-3 flex items-center p-4 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-amber-50">
            <svg class="flex-shrink-0 w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm text-amber-500">
            Note: Since this account is the <b>CED</b> account you cannot change <b>UserType</b>. If incorrect you  may go to <b>Supply Office</b> to request changes.
            </div>
        </div>
        @endif

                
        @if($userdetails->user_type == 1)
        <div class="mb-3 flex items-center p-4 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-amber-50">
            <svg class="flex-shrink-0 w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm text-amber-500">
            Note: Since this account is the <b>Admin (Supply Office)</b> account you cannot change <b>UserType</b>.
            </div>
        </div>
        @endif

        @if(
        ($userdetails->user_type == 2 || 
        $userdetails->user_type == 3 ||
        $userdetails->user_type == 4) && 
        (Auth::user()->user_type == 2 ||
        Auth::user()->user_type == 3 ||
        Auth::user()->user_type == 4)
        )
        <div class="mb-3 flex items-center p-4 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-amber-50">
            <svg class="flex-shrink-0 w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm text-amber-500">
            Note: If <b>Department or UserType</b> is incorrect you  may go to <b>Supply Office</b> to request changes.
            </div>
        </div>
        @endif


            @if($usertype != 5)
                @if($userdetails->user_type != 1 && Auth::user()->user_type == 1)
                   <span>
                        <x-select class="mb-3" wire:model="department" right-icon="user-group" label="Department"
                        placeholder="Department" :options='$department_' option-label="department_short"
                        option-value="department" option-description="nonteaching" hide-empty-message>
                            <x-slot name="afterOptions"
                                class="bg-gray-50 border-t-2 border-gray-200 p-2 flex justify-center gap-2">
                                <x-button wire:click="$emit('openModal', 'add-department')" primary flat full>
                                    <x-icon name="plus-circle" class="w-5 h-5" solid />
                                </x-button>

                                <x-button href="/departments" x-on:click="close" primary flat full>
                                    <x-icon name="cog" class="w-5 h-5" solid />
                                </x-button>
                            </x-slot>
                        </x-select>
                   </span>


                @else
                    @if($userdetails->user_type != 1)
                    <x-input wire:model="department_.department" right-icon="user-group" class="mb-3"
                    label="Department" disabled />
                    @endif

                @endif
            @endif

        {{-- <x-select wire:model="usertype" class="w-full mb-3" right-icon="collection" label="User Type"
            placeholder="Select" :options="['User', 'Dean', 'Chair']" /> --}}

        <div class="grid grid-cols-2 gap-3">
            <x-input wire:model.defer="email" right-icon="at-symbol" class="grid-cols-1" label="Email"
                placeholder="" />

                @if($userdetails->user_type == 1)
                <x-input disabled icon="collection" placeholder="Supply Administrator" label="User Type" />
                @else

                    @if(Auth::user()->id == $userdetails->id)
                    <x-select disabled wire:model="usertype" class="grid-cols-1" right-icon="collection" label="User Type"
                    placeholder="Select" :options='$usertype_' option-label="role" option-value="user_type" />
                    @else
                    <x-select wire:model="usertype" class="grid-cols-1" right-icon="collection" label="User Type"
                    placeholder="Select" :options='$usertype_' option-label="role" option-value="user_type" />
                    @endif

                @endif

       


        </div>



        <hr class="my-3">



        <x-button class="w-full" wire:click="changepassword" icon="cog" label="Change Password"
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
                    })" />

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
