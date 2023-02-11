<div class="h-full overflow-auto space-y-2 soft-scrollbar scroll-smooth bg-gray-50 rounded-md">



    @foreach ($notifications as $notification)
    @switch($notification->notification_type)
        @case(0)
            @if ($notification->user_id == $user->id)
                <div wire:click='$emit("openModal", "view-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                    class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                    <div class=" inline-flex items-center justify-between w-full">
                        <div class="inline-flex items-center">
                            <h3 class="text-sm font-semibold flex items-center gap-1">
                                <x-icon name="paper-airplane" class="w-5 h-5" /> Placed <span
                                    class="font-bold">#{{ $notification->receipt_id }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                        </p>
                    </div>
                    <p class="mt-1 text-sm">
                        Your Request is Placed.
                    </p>
                </div>
            @endif
        @break

        @case(1)
            @if ($notification->user_id == $user->id)
                <div wire:click='$emit("openModal", "view-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                    class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                    <div class=" inline-flex items-center justify-between w-full">
                        <div class="inline-flex items-center">
                            <h3 class="text-sm font-semibold flex items-center gap-1">
                                <x-icon name="check-circle" solid class="w-5 h-5" />Approved <span
                                    class="font-bold">#{{ $notification->receipt_id }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                        </p>
                    </div>
                    <p class="mt-1 text-sm">
                        Your Request Approved (Chair).
                    </p>
                </div>
            @endif
        @break

        @case(2)
            @if ($notification->user_id == $user->id)
                <div wire:click='$emit("openModal", "view-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                    class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                    <div class=" inline-flex items-center justify-between w-full">
                        <div class="inline-flex items-center">
                            <h3 class="text-sm font-semibold flex items-center gap-1">
                                <x-icon name="check-circle" solid class="w-5 h-5" />Approved <span
                                    class="font-bold">#{{ $notification->receipt_id }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                        </p>
                    </div>
                    <p class="mt-1 text-sm">
                        Your Request Approved (Dean).
                    </p>
                </div>
            @endif
        @break

        @case(3)
            @if ($notification->user_id == $user->id)
                <div wire:click='$emit("openModal", "view-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                    class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                    <div class=" inline-flex items-center justify-between w-full">
                        <div class="inline-flex items-center">
                            <h3 class="text-sm font-semibold flex items-center gap-1">
                                <x-icon name="check-circle" solid class="w-5 h-5" />Approved <span
                                    class="font-bold">#{{ $notification->receipt_id }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                        </p>
                    </div>
                    <p class="mt-1 text-sm">
                        Your Request Approved (Supply).
                    </p>
                </div>
            @endif
        @break

        @case(4)
            @if ($notification->user_id == $user->id)
                <div wire:click='$emit("openModal", "view-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                    class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                    <div class=" inline-flex items-center justify-between w-full">
                        <div class="inline-flex items-center">
                            <h3 class="text-sm font-semibold flex items-center gap-1">
                                <x-icon name="shopping-bag" solid class="w-5 h-5" /> Pick Up <span
                                    class="font-bold">#{{ $notification->receipt_id }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                        </p>
                    </div>
                    <p class="mt-1 text-sm">
                        Your Request is Ready for Pickup.
                    </p>
                </div>
            @endif
        @break

        @case(8)
        @if ($notification->user_id == $user->id)
            <div wire:click='$emit("openModal", "view-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                <div class=" inline-flex items-center justify-between w-full">
                    <div class="inline-flex items-center">
                        <h3 class="text-sm font-semibold flex items-center gap-1">
                            <x-icon name="check-circle" solid class="w-5 h-5" />Approved <span
                                class="font-bold">#{{ $notification->receipt_id }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                        </p>
                    </div>
                    <p class="mt-1 text-sm">
                        Your Request Approved (CED).
                    </p>
                </div>
            @endif
        @break

        @case(5)
            @if ($notification->user_id == $user->id)
                <div wire:click='$emit("openModal", "view-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                    class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-red-500 hover:bg-gray-800 hover:text-white">
                    <div class=" inline-flex items-center justify-between w-full">
                        <div class="inline-flex items-center">
                            <h3 class="text-sm font-semibold flex items-center gap-1 text-red-500">
                                <x-icon name="x-circle" solid class="w-5 h-5" /> Canceled <span
                                    class="font-bold">#{{ $notification->receipt_id }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                        </p>
                    </div>
                    <p class="mt-1 text-sm">
                        Your Request is Canceled.
                    </p>
                </div>
            @endif
        @break

        @case(6)
            @if ($notification->user_id == $user->id)
                <div wire:click='$emit("openModal", "view-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                    class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-emerald-500 hover:bg-gray-800 hover:text-white">
                    <div class=" inline-flex items-center justify-between w-full">
                        <div class="inline-flex items-center">
                            <h3 class="text-sm font-semibold flex items-center gap-1 text-emerald-500">
                                <x-icon name="check-circle" solid class="w-5 h-5" /> Done <span
                                    class="font-bold">#{{ $notification->receipt_id }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                        </p>
                    </div>
                    <p class="mt-1 text-sm">
                        Yay! Request Received.
                    </p>
                </div>
            @endif
        @break

        @case(10)
            @if ($notification->user_id == $user->id)
                <div wire:click='$emit("openModal", "view-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                    class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-emerald-500 hover:bg-gray-800 hover:text-white">
                    <div class=" inline-flex items-center justify-between w-full">
                        <div class="inline-flex items-center">
                            <h3 class="text-sm font-semibold flex items-center gap-1 text-emerald-500">
                                <x-icon name="check-circle" solid class="w-5 h-5" /> PPMP <span
                                    class="font-bold">#{{ $notification->receipt_id }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                        </p>
                    </div>
                    <p class="mt-1 text-sm">
                        Project Procurement Management Plan
                    </p>
                </div>
            @endif
        @break

        @case(100)
            <div wire:click='$emit("openModal", "edit-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                <div class=" inline-flex items-center justify-between w-full">
                    <div class="inline-flex items-center">
                        <h3 class="text-sm font-semibold flex items-center gap-1">
                            <x-icon name="inbox" class="w-5 h-5" />Approval <span
                                class="font-bold">#{{ $notification->receipt_id }}</span>
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500">
                        {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                    </p>
                </div>
                <p class="mt-1 text-sm">
                    Request Approval by <span class="font-bold">{{ App\Models\User::find($notification->user_id)->firstname." ".App\Models\User::find($notification->user_id)->lastname  }}</span>
                </p>
            </div>
        @break

        @case(102)
            <div wire:click='$emit("openModal", "edit-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                <div class=" inline-flex items-center justify-between w-full">
                    <div class="inline-flex items-center">
                        <h3 class="text-sm font-semibold flex items-center gap-1">
                            <x-icon name="inbox" class="w-5 h-5" />Approval <span
                                class="font-bold">#{{ $notification->receipt_id }}</span>
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500">
                        {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                    </p>
                </div>
                <p class="mt-1 text-sm">
                    Request Approval by <span class="font-bold">{{ App\Models\User::find($notification->user_id)->firstname." ".App\Models\User::find($notification->user_id)->lastname  }}</span>
                </p>
            </div>
        @break

        @case(103)
            <div wire:click='$emit("openModal", "edit-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                <div class=" inline-flex items-center justify-between w-full">
                    <div class="inline-flex items-center">
                        <h3 class="text-sm font-semibold flex items-center gap-1">
                            <x-icon name="inbox" class="w-5 h-5" />Approval <span
                                class="font-bold">#{{ $notification->receipt_id }}</span>
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500">
                        {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                    </p>
                </div>
                <p class="mt-1 text-sm">
                    Request Approval by <span class="font-bold">{{ App\Models\User::find($notification->user_id)->firstname." ".App\Models\User::find($notification->user_id)->lastname  }}</span>
                </p>
            </div>
        @break

        @case(105)
            <div wire:click='$emit("openModal", "edit-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
                class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
                <div class=" inline-flex items-center justify-between w-full">
                    <div class="inline-flex items-center">
                        <h3 class="text-sm font-semibold flex items-center gap-1">
                            <x-icon name="inbox" class="w-5 h-5" />Approval <span
                                class="font-bold">#{{ $notification->receipt_id }}</span>
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500">
                        {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                    </p>
                </div>
                <p class="mt-1 text-sm">
                    Request Approval by <span class="font-bold">{{ App\Models\User::find($notification->user_id)->firstname." ".App\Models\User::find($notification->user_id)->lastname  }}</span>
                </p>
            </div>
        @break

        @case(110)
        <div wire:click='$emit("openModal", "edit-request", {{ json_encode(['request' => $notification->receipt_id]) }})'
            class="grid-cols-1 px-4 py-3 bg-gray-100 rounded-lg shadow w-full border-b-2 border-gray-800 hover:bg-gray-800 hover:text-white">
            <div class=" inline-flex items-center justify-between w-full">
                <div class="inline-flex items-center">
                    <h3 class="text-sm font-semibold flex items-center gap-1">
                        <x-icon name="inbox" class="w-5 h-5" />PPMP <span
                            class="font-bold">#{{ $notification->receipt_id }}</span>
                    </h3>
                </div>
                <p class="text-xs text-gray-500">
                    {{Carbon\Carbon::parse($notification->timecreated)->diffForHumans()}}
                </p>
            </div>
            <p class="mt-1 text-sm">
                Request by <span class="font-bold">{{ App\Models\User::find($notification->user_id)->firstname." ".App\Models\User::find($notification->user_id)->lastname  }}</span>
            </p>
        </div>
    @break

    @endswitch
@endforeach


</div>
