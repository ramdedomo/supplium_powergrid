<div class="border-b-4 border-amber-500 rounded-md">
    <div class="p-5">

        <span class="flex justify-center p-4 bg-amber-50 rounded-md mb-3 border-2 border-amber-300">
            <span
                class="text-3xl font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">Supplium</span>
                <img width="35px" src="{{ asset('images/HeadSupplium.png') }}" alt="">
        </span>
        


        @foreach ($developers as $dev)
        <div class="flex justify-between bg-gray-100 rounded-md px-2 py-1 mb-2">
            <div>
                {{$dev['role']}}
            </div>
            <div class="font-bold">
                {{$dev['name']}}
            </div>
        </div>
        @endforeach

        <hr class="mt-5">

        <div class="mt-5 text-xs flex justify-between">
            <div>
                Supplium - Supply Inventory System {{Carbon\Carbon::now()->year}}
            </div>
            <div>
                System Integration and Architecture
            </div>
        </div>
    </div>
  
</div>
