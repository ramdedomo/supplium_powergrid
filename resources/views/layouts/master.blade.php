<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Supplium</title>

  

    @vite('resources/css/app.css')
    @livewireStyles
    @powerGridStyles
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1"></script>
    
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body>

    <x-notifications />
    <x-dialog />

    <x-dialog id="changepassword" title="Change Password" description="Enter new password for this user">
        <x-inputs.password id='newpassword' wire:model='newpassword' label="Enter new Password:"
            placeholder="Password" />

        <div class="flex justify-between mt-3">
            <x-button x-on:click="copytoClipboard()" icon="clipboard" label="Copy" />
            <x-button x-on:click="genPassword()" label="Generate Random" />
        </div>
    </x-dialog>


    <script>
        var newpassword = document.getElementById("newpassword");

        function genPassword() {
            var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            var passwordLength = 12;
            var newpassword = "";
            for (var i = 0; i <= passwordLength; i++) {
                var randomNumber = Math.floor(Math.random() * chars.length);
                newpassword += chars.substring(randomNumber, randomNumber + 1);
            }
            document.getElementById("newpassword").value = newpassword;
        }

        function copytoClipboard() {
            var copyText = document.getElementById("newpassword");
            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value);

            window.$wireui.notify({
                title: 'Copied',
                description: 'The password has been copied',
                icon: 'warning'
            })
        }

        var password = document.getElementById("password");

        function pw_genPassword() {
            var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            var passwordLength = 12;
            var password = "";
            for (var i = 0; i <= passwordLength; i++) {
                var randomNumber = Math.floor(Math.random() * chars.length);
                password += chars.substring(randomNumber, randomNumber + 1);
            }
            document.getElementById("password").value = password;
        }

        function pw_copytoClipboard() {
            var copyText = document.getElementById("password");
            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value);

            window.$wireui.notify({
                title: 'Copied',
                description: 'The password has been copied',
                icon: 'warning'
            })
        }
    </script>

    <div class="md:flex flex-col md:flex-row md:min-h-screen w-full">
        <div @click.away="open = false"
            class="flex flex-col lg:w-1/5 md:w-1/4 bg-white sm:w-full lg:h-screen sticky top-0 text-gray-700 border-r-2 dark-mode:text-gray-200 dark-mode:bg-gray-800 flex-shrink-0"
            x-data="{ open: false }">
            <div class="flex-shrink-0 px-4 py-2 flex flex-row items-center justify-between">

               
                    <div class="flex flex-col space-y-0 w-full p-2">
                    <a href="#" class="rounded-lg flex justify-between w-full">
                        <span class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline font-bold">Supplium</span>
                    </a>
                        <div class="text-xs flex items-center justify-between">
                            <div>Supply Inventory System</div>

                            <div>
                               <a class="font-bold hover:text-amber-500 flex items-center cursor-pointer" onclick="Livewire.emit('openModal', 'supplium-devs')"> <x-icon name="user-group" class="w-3 h-3 mr-1" solid /> The Devs</a>
                            </div>
                        </div>
                    </div>
               

        

                <button class="rounded-lg md:hidden rounded-lg focus:outline-none focus:shadow-outline"
                    @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path x-show="!open" fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div class="mt-2 text-center py-2 font-bold bg-gray-100 border-l-4 border-amber-500">
                @if(Auth::user()->department == 0)
                    @if(Auth::user()->user_type == 5)
                    Campus Executive Director
                    @else
                    Administrator
                    @endif

                @else
                    @php
                        foreach (App\Models\Department::all() as $department) {
                        
                            if($department->department == Auth::user()->department){
                                echo $department->department_description;
                            }
                        }
                    @endphp
                @endif
            </div>

            <nav :class="{ 'block': open, 'hidden': !open }" class="flex-grow md:block md:pb-0 md:overflow-y-auto mt-5">
                <div class="flex flex-col w-full h-full px-4">
                    <span class="mb-5">

                        @if (Auth::user()->user_type == 1)
                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{ route('dashboard') }}">
                                <x-icon name="view-list" class="w-5 h-5 mr-2" /> Dashboard
                            </a>
                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{ route('items') }}">
                                <x-icon name="collection" class="w-5 h-5 mr-2" /> Items
                            </a>
                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('requests')}}">
                                <x-icon name="inbox" class="w-5 h-5 mr-2" /> Requests
                            </a>
                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{ route('users') }}">
                                <x-icon name="users" class="w-5 h-5 mr-2" /> Users
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('departments')}}">
                                <x-icon name="user-group" class="w-5 h-5 mr-2" /> Departments
                            </a>

                            <div class="flex gap-2">
                                <a class="w-1/2 flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('notifications')}}">
                                    <x-icon name="bell" class="w-5 h-5 mr-2" /> Notifications
                                </a>
    
                                <a class="w-1/2 flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('reports')}}">
                                <x-icon name="document-report" class="w-5 h-5 mr-2" /> Report
                             </a>
                            </div>
                        @elseif (Auth::user()->user_type == 5)
                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{ route('dashboard') }}">
                                <x-icon name="view-list" class="w-5 h-5 mr-2" /> Dashboard
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('list')}}">
                                <x-icon name="archive" class="w-5 h-5 mr-2" /> Items
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('requests')}}">
                                <x-icon name="inbox" class="w-5 h-5 mr-2" /> Requests
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('myrequests')}}">
                                <x-icon name="paper-airplane" class="w-5 h-5 mr-2" /> Requested Items
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('bag')}}">
                            <x-icon name="shopping-bag" class="w-5 h-5 mr-2" /> Bag
                        </a>

                        <div class="flex gap-2">
                            <a class="w-1/2 flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('notifications')}}">
                                <x-icon name="bell" class="w-5 h-5 mr-2" /> Notifications
                            </a>

                            <a class="w-1/2 flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('reports')}}">
                            <x-icon name="document-report" class="w-5 h-5 mr-2" /> Report
                         </a>
                        </div>
                        @elseif(Auth::user()->user_type  == 2)
                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{ route('dashboard') }}">
                                <x-icon name="view-list" class="w-5 h-5 mr-2" /> Dashboard
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{ route('users') }}">
                                <x-icon name="users" class="w-5 h-5 mr-2" /> Users
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('list')}}">
                                <x-icon name="archive" class="w-5 h-5 mr-2" /> Items
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('requests')}}">
                                <x-icon name="inbox" class="w-5 h-5 mr-2" /> Requests
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('myrequests')}}">
                                <x-icon name="paper-airplane" class="w-5 h-5 mr-2" /> Requested Items
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('bag')}}">
                            <x-icon name="shopping-bag" class="w-5 h-5 mr-2" /> Bag
                        </a>

                        <div class="flex gap-2">
                            <a class="w-1/2 flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('notifications')}}">
                                <x-icon name="bell" class="w-5 h-5 mr-2" /> Notifications
                            </a>

                            <a class="w-1/2 flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('reports')}}">
                            <x-icon name="document-report" class="w-5 h-5 mr-2" /> Report
                         </a>
                        </div>

                        @elseif(Auth::user()->user_type  == 3)
                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{ route('dashboard') }}">
                                <x-icon name="view-list" class="w-5 h-5 mr-2" /> Dashboard
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{ route('users') }}">
                                <x-icon name="users" class="w-5 h-5 mr-2" /> Users
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('list')}}">
                                <x-icon name="archive" class="w-5 h-5 mr-2" /> Items
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('requests')}}">
                                <x-icon name="inbox" class="w-5 h-5 mr-2" /> Requests
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('myrequests')}}">
                                <x-icon name="paper-airplane" class="w-5 h-5 mr-2" /> Requested Items
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('bag')}}">
                            <x-icon name="shopping-bag" class="w-5 h-5 mr-2" /> Bag
                        </a>

                        <div class="flex gap-2">
                            <a class="w-1/2 flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('notifications')}}">
                                <x-icon name="bell" class="w-5 h-5 mr-2" /> Notifications
                            </a>

                            <a class="w-1/2 flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                            href="{{route('reports')}}">
                            <x-icon name="document-report" class="w-5 h-5 mr-2" /> Report
                         </a>
                        </div>
                        @elseif(Auth::user()->user_type  == 4)
                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('list')}}">
                                <x-icon name="archive" class="w-5 h-5 mr-2" /> Items
                           </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('myrequests')}}">
                                <x-icon name="paper-airplane" class="w-5 h-5 mr-2" /> Requested Items
                            </a>

                            <a class="flex block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800"
                                href="{{route('bag')}}">
                                <x-icon name="shopping-bag" class="w-5 h-5 mr-2" /> Bag
                            </a>

                            <a href="{{route('notifications')}}" class="flex justify-between block px-4 py-2 mt-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-gray-800">
                                <div class="flex">
                                    <x-icon name="bell" class="w-5 h-5 mr-2" /> Notifications
                                </div>

                              
                            </a>
                        @endif
                        



                    </span>

                    <span class="text-xs flex items-center px-2 mb-2">Recent Notifications</span>

                    <livewire:notification/> 

                    <div class="mt-auto">

                        <a class="flex px-4 py-2 mb-2 mt-5 text-sm font-semibold text-gray-800 bg-gray-100 rounded-md hover:text-white  hover:bg-amber-500"
                            href="{{ route('logout') }}">Logout</a>


                        <div href="#"
                            class="bg-gray-800 rounded-md p-2 text-white mb-4 flex space-x-3 border-b-4 border-amber-500 ">
                            <div
                                class="bg-white text-gray-800 font-bold font-sans rounded-md w-10 flex items-center justify-center text-2xl">
                                {{ strtoupper(substr($user_info->firstname, 0, 1)) }}
                            </div>
                            <div class="flex flex-col space-y-0">
                                <span class="font-bold">{{ $user_info->firstname . ' ' . $user_info->lastname }}</span>
                                <span class="text-xs">


                                    @if ($user_info->user_type == 1)
                                        Supply Administrator
                                    @elseif($user_info->user_type == 2)
                                        Dean
                                    @elseif($user_info->user_type == 3)
                                        Chair
                                    @elseif($user_info->user_type == 4)
                                        User
                                    @else
                                        Campus Executive Director
                                    @endif

                                </span>
                            </div>
                        </div>
                    </div>


                </div>
            </nav>




        </div>



        <div class="lg:w-4/5 md:w-3/4 sm:w-full p-4">

            {{ $slot }}
        </div>

    </div>


    @livewireScripts
    @livewire('livewire-ui-modal')
    @wireUiScripts
    @vite(['resources/js/app.js'])
    @powerGridScripts
</body>

</html>
