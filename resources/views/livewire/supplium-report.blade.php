<div class="font-mono">

    <div class="p-2 bg-gray-800 rounded-lg mb-3 flex items-center font-bold text-white border-b-4 border-amber-500">
        <x-icon name="document-report" class="w-5 h-5 mr-2" /> Reports
    </div>

    <div class="flex justify-between mb-3">
        <div>
            <x-button icon="document-download" wire:click="$emit('openModal', 'download-report')" outline label="Report"
                class=" shadow-sm" />
        </div>


        <div class="flex gap-2 items-center">
            <x-select placeholder="Predict" :options="$getpredict" option-label="year" option-value="year"
                wire:model="predict" />



            @if (is_null($predict))
                <span class="text-gray-200"> | </span>

                <x-select placeholder="Month" :options="$getmonth" option-label="month" option-value="value"
                    wire:model="month" />

                <x-select placeholder="Year" :options="$getyear" option-label="year" option-value="year"
                    wire:model="year" />
            @endif
        </div>

    </div>

    @if (!is_null($predict))
    <div class="py-2 px-3 rounded-md bg-gray-100 border-2 border-gray-200 mt-3 text-gray-800 flex justify-center items-center">
        <x-icon name="document-search" class="w-5 h-5 mr-2" /> Prediction in the year <b>&nbsp;{{$predict}}</b> 
    </div>
    @endif


    <div class="p-1 rounded-md px-3 bg-amber-100 border-2 border-amber-200 mt-3 text-gray-800 flex items-center">
        <x-icon name="collection" class="w-5 h-5 mr-2" /> Supply & Equipments
    </div>
    <!-- component -->
    <div class="flex flex-col  mt-3">
        <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
            <div class="inline-block min-w-full">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                                    Item
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                                    Type
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                                    Price
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                              
                                    <div class="flex">
                                        No. of Request/Quantity
                                        <span x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false"
                                        class="ml-2 h-5 w-5 cursor-pointer" x-data="{ tooltip: false }">
    
                                        <x-icon name="information-circle" class="w-5 h-5 text-amber-400"/>
                                        <div x-show="tooltip"
                                            class="absolute -translate-x-1/2 translate-y-3 transform rounded-md border-2 border-gray-300 w-56 bg-gray-100 py-3 px-5 text-sm text-gray-500">
                                            Quantity Requested in a given Time. <b>&nbsp;(Completed Requests)</b> 
                                    </span>
                                    </div>
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                                    Total Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($supplies as $supply)
                                <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        {{ $supply->supply_name }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        @if ($supply->supply_type == 0)
                                            Supply
                                        @else
                                            Equipments
                                        @endif
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        {{ $supply->supply_price }}.00 PHP
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        {{ $supply->request_count }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        {{ $supply->request_total }}.00 PHP
                                    </td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $supplies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-1 rounded-md px-3 bg-amber-100 border-2 border-amber-200 text-gray-800  mt-5 flex items-center">
        <x-icon name="user-group" class="w-5 h-5 mr-2" /> Departments
    </div>

    <div class="flex flex-col mt-3">
        <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
            <div class="inline-block min-w-full">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                                    Department
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                                    Department Type
                                </th>

                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                                    <div class="flex">
                                        No. of Request (Equipments)
                                        <span x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false"
                                            class="ml-2 h-5 w-5 cursor-pointer" x-data="{ tooltip: false }">
    
                                            <x-icon name="information-circle" class="w-5 h-5 text-amber-400" />
                                            <div x-show="tooltip"
                                                class="absolute -translate-x-1/2 translate-y-3 transform rounded-md border-2 border-gray-300 w-56 bg-gray-100 py-3 px-5 text-sm text-gray-500">
                                                Number of <b> Completed Request (Equipments) </b> it could be Bulk or Individual.</div>
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                                    <div class="flex">
                                        No. of Request (Supply)
                                        <span x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false"
                                        class="ml-2 h-5 w-5 cursor-pointer" x-data="{ tooltip: false }">
    
                                        <x-icon name="information-circle" class="w-5 h-5 text-amber-400"/>
                                        <div x-show="tooltip"
                                            class="absolute -translate-x-1/2 translate-y-3 transform rounded-md border-2 border-gray-300 w-56 bg-gray-100 py-3 px-5 text-sm text-gray-500">
                                            Number of <b> Completed Request (Supply) </b> it could be Bulk or Individual.</div>
                                    </span>
                                    </div>
                       
                                </th>

                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-2 text-left">
                                    Total No. of Request
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($departments as $department)
                                <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        {{ $department->department_description }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        @if ($department->nonteaching == 1)
                                            Non-Teaching
                                        @else
                                            Teaching
                                        @endif
                                    </td>

                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        {{ $department->request_count_equipments }}
                                    </td>

                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        {{ $department->request_count_supply }}
                                    </td>

                                    <td class="text-sm text-gray-900 font-light px-6 py-2 whitespace-nowrap">
                                        {{ $department->request_count }}
                                    </td>


                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $departments->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
