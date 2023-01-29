<div>

    <div>
        <div class="p-2 bg-gray-800 rounded-lg mb-2 flex items-center font-bold text-white border-b-4 border-amber-500">
            <x-icon name="shopping-bag" class="w-5 h-5 mr-2" /> Bag
        </div>
    </div>


    <div class="grid gap-2 md:grid-cols-1 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="mt-8">
    
                <div class="flow-root">
                    <ul role="list" class="-my-6">

    
                        @if($supplies->isEmpty())
                            <div class=" bg-gray-100 border-b-4 border-gray-800 p-24 justify-center items-center font-mono rounded-md text-gray-400 flex">
                                <span>Wow Such Empty </span> 
                                <x-icon name="emoji-happy" class=" ml-2 w-5 h-5" />
                            </div>
                        @endif

                        @foreach ($supplies as $supply)
                            <li class="flex p-6 bg-gray-100 mb-2 rounded-md">
                                <div wire:click="$emit('openModal', 'supply-order-add', {{ json_encode(["supply" => $supply->supply_id]) }})" class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 hover:scale-105 transition ease-in-out">
                                    <img src="https://tailwindui.com/img/ecommerce-images/shopping-cart-page-04-product-02.jpg"
                                        alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt."
                                        class="cursor-pointer h-full w-full object-cover object-center">
                                </div>
    
                                <div class="ml-4 flex flex-1 flex-col">
                                    <div>
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <h3>
                                                <span>{{$supply->supply_name}}</span>
                                            </h3>
                                            <span class="ml-4"><x-checkbox id="checkbox" value="{{$supply->supply_name}},{{$supply->quantity}},{{($supply->supply_type == 0) ? 'Supply' : 'Equipment' }},{{$supply->id}}"  wire:model="check"  /></span>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">{{($supply->supply_type == 0) ? 'Supply' : 'Equipment' }}</p>
                                    </div>
                                    <div class="flex flex-1 items-end justify-between">
                                        <div class="flex items-center">
                                            <span class="font-mono">Qty: <span class=" font-bold">{{$supply->quantity}}</span></span>
                                    
                                        </div>
    
                                        <div>
                                            <x-button class="px-2" wire:click="remove({{$supply->id}})" icon="trash" label="Remove"/>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
    
            <div class="mt-10">
                {{ $supplies->links() }}
            </div>
        </div>
        <div class="lg:col-span-1 mt-2">
            <div class="bg-gray-100 border-b-4 w-full border-gray-800 p-6 rounded-md mb-2 font-mono">
                <div>
                    <div class="flex flex-col">
                      <h1 class="text-gray-800 text-xl font-medium mb-2">Summary</h1>
                      <p class="text-gray-600 text-xs">Date: {{Carbon\Carbon::now()}}</p>
                    </div>
                    <hr class="my-4">
                    <div>

                        @if(empty($check))
                            <div class="bg-gray-200 rounded-md p-3 text-center">
                                ...
                            </div>
                        @endif

                        @foreach ($check as $item)
                          <div class="flex justify-between items-center">
                            <span class="font-medium text-base">{{explode(',', $item)[0]}}</span><span class="text-base font-medium">
                                {{explode(',', $item)[2]}}
                            </span>
                          </div>
                          <div class="mb-4 flex justify-between items-center">
                            <span>*Quantity:</span><span class="">{{explode(',', $item)[1]}}</span>
                          </div>
                        @endforeach
   
                      <hr class="my-4">


                    </div>
                  </div>
            </div>

            <div>
                @if(!empty($check)) 
                <x-button wire:click="sendrequest" class="w-full" icon="paper-airplane" label="Request" />
                @else

                @endif
        
            </div>
       
        </div>
    </div>

 




</div>
