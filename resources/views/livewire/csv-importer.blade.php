<div class="relative z-10" x-data="{
    open: @entangle('open')
}" x-show="open" x-cloak>
    <div class="fixed inset-0"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                <div class="pointer-events-auto w-screen max-w-md">
                    <form wire:submit.prevent="import" enctype="multipart/form-data"
                        class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl">
                        <div class="py-6 px-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium">Import</h2>
                                {{ $model }}
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button"
                                        class="rounded-md text-gray-200 hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white"
                                        wire:click="toggle">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-y-auto overflow-x-hidden">
                            <div class="flex flex-1 flex-col justify-between">
                                <div class="p-4 sm:p-6">
                                    
                                    <div>
                                        <!-- File drop -->
                                        <div class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md"
                                            x-bind:class="{
                                                'border-gray-300': !dropping,
                                                'border-gray-400': dropping
                                            }"
                                            x-on:dragover.prevent="dropping = true"
                                            x-on:dragleave.prevent="dropping = false" x-on:drop="dropping = false"
                                            x-on:drop.prevent="handleDrop($event)" x-data="{
                                                dropping: false,
                                                handleDrop(event) {
                                                    @this.upload('file', event.dataTransfer.files[0])
                                                }
                                            }">

                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="file"
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500">
                                                        <span>Upload a file</span>
                                                        <input id="file" wire:model="file" name="file"
                                                            type="file" class="sr-only">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    CSV file up to 10MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                    @error('file')
                                        <span class="mt-2 text-red-500 font-medium text-sm">{{ $message }}</span>
                                    @enderror

                                    <!-- End file drop -->

                                    <!-- Column selection -->
                                    @if ($headers)
                                        <div class="mt-8">
                                            <h2 class="font-medium">Match columns</h2>
                                            <div class="mt-4 space-y-5">

                                                @foreach ($columnsToMap as $column => $value)
                                                    <div class="grid grid-cols-4 gap-4 items-start">
                                                        <label for="{{ $column }}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 col-span-1">
                                                            {{ $columnLabels[$column] ?? $column  }}
                                                        </label>
                                                        <div class="mt-1 sm:mt-0 sm:col-span-3">

                                                            <x-select
                                                                wire:model.defer="columnsToMap.{{$column}}"
                                                                name="{{ $column }}"
                                                                id="{{ $column }}"
                                                                placeholder="Map"
                                                                :options="$headers"
                                                            />


                                                            @error('columnsToMap.'.$column)
                                                            <span class="mt-2 text-red-500 font-medium text-sm">{{$message}}</span> 
                                                            @enderror
                                                     

                                                        </div>
                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>
                                    @endif


                                    <!-- End file drop -->

                                </div>
                            </div>
                        </div>

                        <div class="flex flex-shrink-0 justify-end px-4 py-4 mt-auto">
                            <x-button amber type="submit" class="{{ $imported ? 'disabled' : '' }}" label="Import" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
