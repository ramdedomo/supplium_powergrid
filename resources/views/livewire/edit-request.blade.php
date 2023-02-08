<div class="border-b-4 border-amber-500 rounded-md p-5 font-mono">



    <div class="flow-root" wire:ignore>
        <ul>
            @foreach ($requests as $item)
            <li class="flex p-3 bg-gray-100 mb-2 rounded-md border-b-2 border-gray-300">
                <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                    <img src="{{Storage::url($item['supply_photo'])}}"
                    class="cursor-pointer h-full w-full object-cover object-center">
                </div>

                <div class="ml-4 flex flex-1 flex-col">
                    <div>
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <h3>
                                <span>{{$item['supply_name']}} (Qty: {{$item->quantity}})</span>
                            </h3>
                            <span class="ml-4 "></span></span>
                        </div>
                        <div>
                            <p class="mt-1 text-sm text-gray-500">{{$item['supply_type']}}</p>
                        </div>
                     
                    </div>
                </div>
                
            </li>
            @endforeach
    
        </ul>
    </div>

    @if($receipt->is_supply == 1)

        @if(Auth::user()->user_type == 1 && $receipt->supply_status == 0)
            <div class="my-3">
                <x-button wire:click="accept" amber class="w-full mb-2" label="Confirm Request" />
                <x-button wire:click="cancel" class="w-full mb-2" outline label="Cancel" />
            </div>
        @endif

        <hr class="my-3">

        @if($receipt->supply_status == 4)
        <div class="bg-green-200 outline-1 text-green-800 outline-green-400 text-center outline rounded-md justify-center mb-3 p-3">
            <div class="flex items-center justify-center">
                <x-icon name="information-circle" class="w-5 h-5 mr-3" /> 
                Request is Ready to Pickup by&nbsp;<span class="font-bold">{{$user->firstname. " " . $user->lastname}} #{{$receipt->id}}</span>.
            </div>
        </div>
        @endif
        
        @if(!is_null($receipt->done_at))
        <div class="bg-green-200 outline-1 text-green-800 outline-green-400 text-center outline rounded-md justify-center mb-3 p-3">
            <div class="flex items-center justify-center">
                <x-icon name="information-circle" class="w-5 h-5 mr-3" /> 
                Request is Completed.
            </div>
        </div>
        @endif


        @if($receipt->supply_status == 7)
        <div class="bg-red-200 outline-1 text-red-800 outline-red-400 text-center outline rounded-md justify-center mb-3 p-3">
            <div class="flex items-center justify-center">
                <x-icon name="information-circle" class="w-5 h-5 mr-3" /> 
                Request is Canceled.
            </div>
        </div>
        @endif

        <div class="p-3 bg-gray-100 rounded-md mb-3 border-b-2 border-gray-800">
            <div class="flex justify-between">
                Request No: 
                <span class="font-bold">#{{$receipt->id}}</span> 
            </div>

            <div class="flex justify-between">
                Requested By: 
                <span class="font-bold">{{$user->firstname. " " . $user->lastname}}</span> 
            </div>
        </div>

        <div class="p-3 bg-gray-100 rounded-md mb-3 border-b-2 border-gray-800">
            <div class="flex justify-between">
                Placed At: 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->created_at), 'M/d h:i A') }}</span>
            </div>

            @if(!is_null($receipt->supply_at))
            <div class="flex justify-between">
                Supply Office (Approved): 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->supply_at), 'M/d h:i A') }}</span>
            </div>
            @endif

            @if(!is_null($receipt->done_at))
            <div class="flex justify-between">
                Request Done: 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->done_at), 'M/d h:i A') }}</span>
            </div>
            @endif

            @if(!is_null($receipt->canceled_at))
            <div class="flex justify-between">
                Canceled At: 
                <span class="font-bold "> {{ date_format(Carbon\Carbon::parse($receipt->canceled_at), 'M/d h:i A') }}</span>
            </div>
            @endif
        </div>

          {{-- !is_null($receipt->supply_at) &&  --}}
          @if($receipt->supply_status == 4)
          <x-button wire:click="accept" icon="check" green outline class="w-full mb-5" label="Request Done" />
          @endif

        
        @if($receipt->supply_status == 7)
        <div class="grid-cols-1 text-center text-sm bg-red-500 text-white px-2 py-1 rounded-full"> Canceled</div>
        @else
        <div class="grid grid-cols-4 mb-3 gap-3 p-1 border-2 rounded-full">
            <div
                class="grid-cols-1 text-center text-sm flex items-center justify-center @if (is_null($receipt->created_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full">
                <x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> Placed</div>
            <div
                class="grid-cols-1 text-center text-sm flex items-center justify-center @if (is_null($receipt->supply_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full">
                <x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> Supply Office</div>
            <div
                class="grid-cols-1 text-center text-sm flex items-center justify-center @if (is_null($receipt->supply_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full">
                <x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> Pick Up</div>
            <div
                class="grid-cols-1 text-center text-sm flex items-center justify-center @if (is_null($receipt->done_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full">
                <x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> Done</div>
        </div>
        @endif


       
    @else

        @if(Auth::user()->user_type == 5 && $receipt->supply_status == 2)
        <div class="my-3">
            <x-button wire:click="accept" amber class="w-full mb-2" label="Accept Request (CED)" />
            <x-button wire:click="cancel" class="w-full mb-2" outline label="Cancel" />
        </div>
        @endif

        @if(Auth::user()->user_type == 2 && $receipt->supply_status == 1)
        <div class="my-3">
            <x-button wire:click="accept" amber class="w-full mb-2" label="Accept Request (Dean)" />
            <x-button wire:click="cancel" class="w-full mb-2" outline label="Cancel" />
        </div>
        @endif

        @if(Auth::user()->user_type == 3 && $receipt->supply_status == 0)
        <div class="my-3">
            <x-button wire:click="accept" amber class="w-full mb-2" label="Accept Request (Chair)" />
            <x-button wire:click="cancel" class="w-full mb-2" outline label="Cancel" />
        </div>
        @endif


        <hr class="my-3">

        @if($receipt->supply_status == 4)
        <div class="bg-green-200 outline-1 text-green-800 outline-green-400 text-center outline rounded-md justify-center mb-3 p-3">
            <div class="flex items-center justify-center">
                <x-icon name="information-circle" class="w-5 h-5 mr-3" /> 
                Request is Ready to Pickup by&nbsp;<span class="font-bold">{{$user->firstname. " " . $user->lastname}} #{{$receipt->id}}</span>.
            </div>
        </div>
        @endif

        @if(!is_null($receipt->done_at))
        <div class="bg-green-200 outline-1 text-green-800 outline-green-400 text-center outline rounded-md justify-center mb-3 p-3">
            <div class="flex items-center justify-center">
                <x-icon name="information-circle" class="w-5 h-5 mr-3" /> 
                Request is Completed.
            </div>
        </div>
        @endif

        @if($receipt->supply_status == 7)
        <div class="bg-red-200 outline-1 text-red-800 outline-red-400 text-center outline rounded-md justify-center mb-3 p-3">
            <div class="flex items-center justify-center">
                <x-icon name="information-circle" class="w-5 h-5 mr-3" /> 
                Request is Canceled.
            </div>
        </div>
        @endif


        <div class="p-3 bg-gray-100 rounded-md mb-3 border-b-2 border-gray-800">
            <div class="flex justify-between">
                Request No: 
                <span class="font-bold">#{{$receipt->id}}</span> 
            </div>

            <div class="flex justify-between">
                Requested By: 
                <span class="font-bold">{{$user->firstname. " " . $user->lastname}}</span> 
            </div>
        </div>

        <div class="p-3 bg-gray-100 rounded-md mb-3 border-b-2 border-gray-800">
            <div class="flex justify-between">
                Placed At: 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->created_at), 'M/d h:i A') }}</span>
            </div>

            {{-- @if(!is_null($receipt->accepted_at))
            <div class="flex justify-between">
                Accepted At: 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->accepted_at), 'M/d h:i A') }}</span>
            </div>
            @endif --}}
            
            @if(!is_null($receipt->chair_at))
            <div class="flex justify-between">
                Chair (Approved): 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->chair_at), 'M/d h:i A') }}</span>
            </div>
            @endif

            @if(!is_null($receipt->dean_at))
            <div class="flex justify-between">
                Dean (Approved): 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->dean_at), 'M/d h:i A') }}</span>
            </div>
            @endif

            @if(!is_null($receipt->ced_at))
            <div class="flex justify-between">
                CED (Approved): 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->ced_at), 'M/d h:i A') }}</span>
            </div>
            @endif


            @if(!is_null($receipt->done_at))
            <div class="flex justify-between">
                Request Done: 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->done_at), 'M/d h:i A') }}</span>
            </div>
            @endif
            
            {{-- @if(!is_null($receipt->supply_at))
            <div class="flex justify-between">
                Supply Office (Approved): 
                <span class="font-bold"> {{ date_format(Carbon\Carbon::parse($receipt->supply_at), 'M/d h:i A') }}</span>
            </div>
            @endif --}}

            @if(!is_null($receipt->canceled_at))
            <div class="flex justify-between">
                Canceled At: 
                <span class="font-bold "> {{ date_format(Carbon\Carbon::parse($receipt->canceled_at), 'M/d h:i A') }}</span>
            </div>
            @endif
        </div>
        
        {{-- !is_null($receipt->supply_at) &&  --}}
        @if($receipt->supply_status == 4)
            <x-button wire:click="accept" icon="check" green outline class="w-full mb-5" label="Request Done" />
        @endif

        
        @if($receipt->supply_status == 7)
        <div class="grid-cols-1 text-center text-sm bg-red-500 text-white px-2 py-1 rounded-full"> Canceled</div>
        @else
        <div class="grid grid-cols-6 mb-3 gap-3 p-1 border-2 rounded-full">
            <div class="grid-cols-1 text-center text-sm flex items-center justify-center @if(is_null($receipt->created_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full"><x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> Placed</div>
            {{-- <div class="grid-cols-1 text-center text-sm @if(is_null($receipt->accepted_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full">Accepted</div> --}}
            <div class="grid-cols-1 text-center text-sm flex items-center justify-center @if(is_null($receipt->chair_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full"> <x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> Chair</div>
            <div class="grid-cols-1 text-center text-sm flex items-center justify-center @if(is_null($receipt->dean_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full"> <x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> Dean</div>
            <div class="grid-cols-1 text-center text-sm flex items-center justify-center @if(is_null($receipt->ced_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full"> <x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> CED</div>
            <div class="grid-cols-1 text-center text-sm flex items-center justify-center @if(is_null($receipt->ced_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full"> <x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> Pick</div>
            <div class="grid-cols-1 text-center text-sm flex items-center justify-center @if(is_null($receipt->done_at)) bg-gray-100 text-gray-400 @else bg-amber-500 text-white @endif px-2 py-1 rounded-full"> <x-icon name="check-circle" class="w-3 h-3 mr-2" solid /> Done</div>
        </div>
        @endif

  

    @endif
    {{-- @if(Auth::user()->user_type == 1 && $receipt->supply_status == 0)
    <div class="my-3">
        <x-button wire:click="accept" amber class="w-full mb-2" icon="check" label="Accept Request" />
        <x-button wire:click="cancel" class="w-full mb-2" outline label="Cancel" />
    </div>
    @endif --}}

    {{-- @if(Auth::user()->user_type == 1 && $receipt->supply_status == 3)
    <div class="my-3">
        <x-button wire:click="accept" amber class="w-full mb-2" label="Accept Request (Supply)" />
        <x-button wire:click="cancel" class="w-full mb-2" outline label="Cancel" />
    </div>
    @endif --}}

    <div class="mt-3 bg-gray-100 rounded-md p-2 h-72 overflow-auto soft-scrollbar scroll-smooth border-2 border-secondary-300">


        @foreach ($messages as $message)

            @switch($message->message_type)
                @case(0)
                    <div class="flex @if(Auth::user()->id == $message->user_id) justify-end @else justify-start @endif p-2 text-start">
                        <div class="w-3/5 rounded-md border-b-2 shadow-md border-amber-500 bg-gray-50 p-3 hover:bg-white transition ease-in-out">
                        <div class="font-bold">
                            {{$message->firstname . ' ' . $message->lastname}}
                        </div>
                        <div class="text-amber-500">
                        Request <span class="font-bold">#{{$receipt->id}}</span> Placed!
                        </div>
                    
                        <div class="mt-2 text-xs font-bold border-t-2 pt-2 border-gray-100">{{ date_format(Carbon\Carbon::parse($message->created_at), 'M/d h:i A') }}</div>
                        </div>
                    </div>
                    @break

                @case(1)
                    <div class="flex @if(Auth::user()->id == $message->user_id) justify-end @else justify-start @endif p-2 text-start">
                        <div class="w-3/5 rounded-md border-b-2 shadow-md border-amber-500 bg-gray-50 p-3 hover:bg-white transition ease-in-out">
                        <div class="font-bold">
                            {{$message->firstname . ' ' . $message->lastname}} - Chair
                        </div>
                        <div class="text-amber-500">
                        Request <span class="font-bold">#{{$receipt->id}}</span> Approved (Chair).
                        </div>
                    
                        <div class="mt-2 text-xs font-bold border-t-2 pt-2 border-gray-100">{{ date_format(Carbon\Carbon::parse($message->created_at), 'M/d h:i A') }}</div>
                        </div>
                    </div>
                    @break
            
                @case(2)
                    <div class="flex @if(Auth::user()->id == $message->user_id) justify-end @else justify-start @endif p-2 text-start">
                        <div class="w-3/5 rounded-md border-b-2 shadow-md border-amber-500 bg-gray-50 p-3 hover:bg-white transition ease-in-out">
                        <div class="font-bold">
                            {{$message->firstname . ' ' . $message->lastname}} - Dean
                        </div>
                        <div class="text-amber-500">
                        Request <span class="font-bold">#{{$receipt->id}}</span> Approved (Dean).
                        </div>
                    
                        <div class="mt-2 text-xs font-bold border-t-2 pt-2 border-gray-100">{{ date_format(Carbon\Carbon::parse($message->created_at), 'M/d h:i A') }}</div>
                        </div>
                    </div>
                    @break
                    
                @case(3)
                    <div class="flex @if(Auth::user()->id == $message->user_id) justify-end @else justify-start @endif p-2 text-start">
                        <div class="w-3/5 rounded-md border-b-2 shadow-md border-amber-500 bg-gray-50 p-3 hover:bg-white transition ease-in-out">
                        <div class="font-bold">
                            {{$message->firstname . ' ' . $message->lastname}} - Supply Office
                        </div>
                        <div class="text-amber-500">
                        Request <span class="font-bold">#{{$receipt->id}}</span> Approved (Supply).
                        </div>
                    
                        <div class="mt-2 text-xs font-bold border-t-2 pt-2 border-gray-100">{{ date_format(Carbon\Carbon::parse($message->created_at), 'M/d h:i A') }}</div>
                        </div>
                    </div>
                    @break

                @case(4)
                    <div class="flex @if(Auth::user()->id == $message->user_id) justify-end @else justify-start @endif p-2 text-start">
                        <div class="w-3/5 rounded-md border-b-2 shadow-md border-amber-500 bg-gray-50 p-3 hover:bg-white transition ease-in-out">
                        <div class="font-bold">
                            {{$message->firstname . ' ' . $message->lastname}}
                        </div>
                        <div class="text-amber-500">
                        Request <span class="font-bold">#{{$receipt->id}}</span> Ready for Pickup!
                        </div>
                    
                        <div class="mt-2 text-xs font-bold border-t-2 pt-2 border-gray-100">{{ date_format(Carbon\Carbon::parse($message->created_at), 'M/d h:i A') }}</div>
                        </div>
                    </div>
                    @break
                    
                @case(5)
                    <div class="flex @if(Auth::user()->id == $message->user_id) justify-end @else justify-start @endif p-2 text-start">
                        <div class="w-3/5 rounded-md border-b-2 shadow-md border-red-500 bg-gray-50 p-3 hover:bg-white transition ease-in-out">
                        <div class="font-bold">
                            {{$message->firstname . ' ' . $message->lastname}}
                        </div>
                        <div class="text-red-500">
                        Request <span class="font-bold">#{{$receipt->id}}</span> Canceled.
                        </div>
                    
                        <div class="mt-2 text-xs font-bold border-t-2 pt-2 border-gray-100">{{ date_format(Carbon\Carbon::parse($message->created_at), 'M/d h:i A') }}</div>
                        </div>
                    </div>
                    @break

                @case(6)
                    <div class="flex @if(Auth::user()->id == $message->user_id) justify-end @else justify-start @endif p-2 text-start">
                        <div class="w-3/5 rounded-md border-b-2 shadow-md border-emerald-500 bg-gray-50 p-3 hover:bg-white transition ease-in-out">
                        <div class="font-bold">
                            {{$message->firstname . ' ' . $message->lastname}}
                        </div>
                        <div class="text-emerald-500">
                        Request <span class="font-bold">#{{$receipt->id}}</span> Done!
                        </div>
                    
                        <div class="mt-2 text-xs font-bold border-t-2 pt-2 border-gray-100">{{ date_format(Carbon\Carbon::parse($message->created_at), 'M/d h:i A') }}</div>
                    </div>
                    </div>
                    @break

                @case(7)
                    <div class="flex @if(Auth::user()->id == $message->user_id) justify-end @else justify-start @endif p-2 text-start">
                        <div class="w-3/5 rounded-md border-b-2 shadow-md border-gray-500 bg-gray-50 p-3 hover:bg-white transition ease-in-out">
                        <div class="font-bold">
                            {{$message->firstname . ' ' . $message->lastname}}
                        </div>
                        <div>
                        {{$message->message}}
                        </div>
                    
                        <div class="mt-2 text-xs font-bold border-t-2 pt-2 border-gray-100">{{ date_format(Carbon\Carbon::parse($message->created_at), 'M/d h:i A') }}</div>
                    </div>
                    </div>
                    @break

                    
                    
            @endswitch


        @endforeach

    </div>


    <div class="mt-2">
        <x-input placeholder="Message" wire:model="message_content">
            <x-slot name="append">
                <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                    <x-button
                        wire:click="send_message"
                        class="h-full rounded-r-md"
                        icon="paper-airplane"
                        primary
                        flat
                        squared
                    />
                </div>
            </x-slot>
        </x-input>
    </div>

   

  

</div>
