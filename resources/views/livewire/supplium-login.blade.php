<div>
    
    <div class="h-screen flex justify-center items-center">
        <div>
            <div class="text-center p-2 my-3 space-y-5">
                <span>
                    <span class="text-2xl font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">PSU-URDANETA CAMPUS</span>
                    <div class="text-xs font-mono">Supply Inventory System</div>
                </span>

                <p>Welcome back! please login to continue.</p>
            </div>


            <form wire:submit.prevent="submit">
                
                @if (Session::has('message'))
                <div class="flex mb-2 justify-center items-start gap-x-3 rounded-lg border dark:border-0 shadow-soft bg-gray-100  p-3">
                    {{ Session::get('message') }}
                </div>
                @endif
              
            <x-errors class="mb-2" />

                
                <div class="bg-gray-100 p-3 rounded-lg space-y-3">
                    <x-input wire:model="email" name="email" label="Email" placeholder="Email" />
                    <x-inputs.password wire:model="password" label="Password" placeholder="Password" value="" />
                    <x-button type="submit" class="w-full" warning label="Login" />
                </div>
                
            </form>

            <div class="flex justify-center my-3 text-2xs">
                <span class="text-gray-300"> Powered by <span class="font-bold cursor-pointer hover:text-amber-300" wire:click="$emit('openModal', 'supplium-devs')">Supplium</span>  </span>
            </div>
      

        </div>
    </div>
</div>
