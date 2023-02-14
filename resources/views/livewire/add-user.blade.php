<div class="border-b-4 border-amber-500 rounded-md">

    <x-card title="Add User">
        <p class="text-gray-600">

            

            @if(Auth::user()->user_type == 1)
            <div class="shadow border w-full text-center justify-center font-mono text-xs p-2 rounded-md text-gray-500 bg-gray-100 mb-3">
                <span class="font-bold text-emerald-500">Note:</span>  If you selected a <span class="font-bold">Non-Teaching Department </span>you must select<span class="font-bold"> <span class="text-emerald-500">Head</span>  or <span class="text-emerald-500">User/Instructor</span>  on UserType</span>. When <span class="font-bold">Teaching Department </span>is selected you must select<span class="font-bold"> <span class="text-emerald-500">Dean</span>, <span class="text-emerald-500">Chairman</span> or <span class="text-emerald-500">User/Instructor</span> on UserType</span>.
            </div>
            @endif


            <x-errors class="mb-3" />

        <div class="gap-3 grid grid-cols-2">
            <x-input wire:model.defer="userfirstname" right-icon="identification" class="mb-3 grid-cols-1" label="Firstname"
                placeholder="" />
            <x-input wire:model.defer="userlastname" right-icon="identification" class="mb-3 grid-cols-1" label="Lastname"
                placeholder="" />
        </div>


        {{-- @if(!is_null($department) && App\Models\Department::find($department)->nonteaching)
        Head, User
        @endif --}}
   

        <div class="flex justify-center mb-3">
        @if(Auth::user()->user_type == 1)

            @if($usertype != 5)
                <x-select class="w-full"
                wire:model="department" 
                right-icon="user-group" 
                label="Department"
                placeholder="Department" 
                :options='$department_'
                option-label="department_short"
                option-value="department"
                option-description="nonteaching"
                hide-empty-message
                >
                    <x-slot name="afterOptions" class="bg-gray-50 border-t-2 border-gray-200 p-2 flex justify-center gap-2">
                        <x-button
                        wire:click="$emit('openModal', 'add-department')"
                        primary
                        flat
                        full>
                        <x-icon name="plus-circle" class="w-5 h-5" solid />
                    </x-button>

                        <x-button
                            href="/departments"
                            x-on:click="close"
                            primary
                            flat
                            full>
                            <x-icon name="cog" class="w-5 h-5" solid />
                        </x-button>
                    </x-slot>
                </x-select>
            @else
                <span class="flex w-full justify-center font-mono text-xs p-2 rounded-md text-gray-500 bg-gray-100">
                <b>Department Picker Removed</b>&nbsp;-&nbsp;Campus Executive Director do not require Department.
                </span>
            @endif
      

        @else
        <div class="w-full">
            <x-input wire:model="department_.department" right-icon="user-group" label="Department" disabled/>
        </div>
          
        @endif
        </div>


        <div class="grid grid-cols-2 gap-3 mb-3 items-center">

            <x-input wire:model.defer="email" right-icon="at-symbol" class="grid-cols-1" label="Email" placeholder="" />

            <x-select
            wire:model="usertype"
            class="grid-cols-1"
            right-icon="collection"
            label="User Type"
            placeholder="Select"
            :options='$usertype_' 
            option-label="role"
            option-value="user_type"
            />


        </div>


        <hr class="my-3">

        <x-inputs.password id='password' wire:model='password' label="Enter Password:" placeholder="Password" />

        <div class="flex justify-between mt-3">
            <x-button x-on:click="pw_copytoClipboard()" icon="clipboard" label="Copy Password" />
            <x-button x-on:click="pw_genPassword()" label="Generate Random" />
        </div>

        </p>


        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button wire:click="$emit('closeModal')" label="Close" />
                <x-button wire:click="add" primary label="Add" />
            </div>
        </x-slot>

        

    </x-card>

</div>
