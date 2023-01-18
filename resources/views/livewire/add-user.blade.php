<div class="border-b-4 border-amber-500 rounded-md">

    <x-card title="Add User">
        <p class="text-gray-600">

            <x-errors class="mb-3" />

        <div class="gap-3 grid grid-cols-2">
            <x-input wire:model.defer="userfirstname" right-icon="identification" class="mb-3 grid-cols-1" label="Firstname"
                placeholder="" />
            <x-input wire:model.defer="userlastname" right-icon="identification" class="mb-3 grid-cols-1" label="Lastname"
                placeholder="" />
        </div>

        <x-select
        wire:model.defer="usertype"
        class="w-full mb-3"
        right-icon="collection"
        label="User Type"
        placeholder="Select"
        :options='$usertype_' 
        option-label="role"
        option-value="user_type"
        />

        <div class="grid grid-cols-2 gap-3 mb-3">

            <x-input wire:model.defer="email" right-icon="at-symbol" class="grid-cols-1" label="Email" placeholder="" />

            @if(Auth::user()->user_type == 1)
            <x-select 
            class="grid-cols-1"
            wire:model.defer="department" 
            right-icon="user-group" 
            label="Department"
            placeholder="Department" 
            :options='$department_'
            option-label="department_short"
            option-value="department"
            />
            @else
            <x-input wire:model="department_.department" right-icon="user-group" class="grid-cols-1" label="Department" disabled/>
            @endif

        </div>


        <hr class="my-3">

        <x-inputs.password id='password' wire:model='password' label="Enter Password:" placeholder="Password" />

        <div class="flex justify-between mt-3">
            <x-button x-on:click="pw_copytoClipboard()" icon="clipboard" label="Copy" />
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
