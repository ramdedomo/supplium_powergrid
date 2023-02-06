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
        wire:model="usertype"
        class="w-full mb-3"
        right-icon="collection"
        label="User Type"
        placeholder="Select"
        :options='$usertype_' 
        option-label="role"
        option-value="user_type"
        />

        @if(Auth::user()->user_type == 1)
        <div class="mb-3 flex items-center p-4 border rounded-lg gap-x-3 dark:border-0 shadow-soft bg-amber-50">
            <svg class="flex-shrink-0 w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm text-amber-500">
            Tip: If selected <b>Department</b> is <b>Non-teaching</b> you must select <b>"User" on usertype</b>.
            </div>
        </div>
        @endif

        <div class="grid grid-cols-2 gap-3 mb-3">

            <x-input wire:model.defer="email" right-icon="at-symbol" class="grid-cols-1" label="Email" placeholder="" />

            @if(Auth::user()->user_type == 1)

                @if($usertype != 5)
                    <x-select
                    class="grid-cols-1"
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
                    <x-input right-icon="user-group" class="grid-cols-1" label="Department" disabled/>
                @endif


            {{-- <x-select 
            class="grid-cols-1"
            wire:model.defer="department" 
            right-icon="user-group" 
            label="Department"
            placeholder="Department" 
            :options='$department_'
            option-label="department_short"
            option-value="department"
            /> --}}
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
