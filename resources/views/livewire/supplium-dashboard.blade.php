<div>
    <x-modal wire:model.defer="simpleModal" align="center">
        <x-card title="Consent Terms">
            <p class="text-gray-600">
                Lorem Ipsum...
            </p>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="I Agree" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    <div>
        <div class="p-2 bg-gray-800 rounded-lg mb-2 flex items-center font-bold text-white border-b-4 border-amber-500">
            <x-icon name="view-list" class="w-5 h-5 mr-2" /> Dashboard
        </div>
    </div>



    <div class="grid grid-cols-2 gap-2 mt-4">
        <div class="col-span-1 h-72 p-2 border-b-4 border-b-gray-800 rounded-md bg-gray-100">
            <canvas id="no_of_request"></canvas>
        </div>
        <div class="col-span-1 h-72 p-2 border-b-4 border-b-gray-800 rounded-md bg-gray-100">
            <canvas id="equipment_vs_supply"></canvas>
        </div>
    </div>

    
    <div class="h-72 p-2 bg-gray-100 rounded-md  border-b-4 border-b-gray-800 mt-2">
        <canvas id="department_request"></canvas>
    </div>

    <div class="mt-2">
        <div class="p-2 bg-gray-100 rounded-lg mb-2 flex justify-end font-bold text-gray-800">
            <x-button href="{{route('reports')}}" flat label="Report & Analysis"  right-icon="arrow-circle-right" />
        </div>
    </div>


    <script>
                const ctx = document.getElementById('no_of_request').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($table1_labels),
                        datasets: [{
                            tension: 0.1,
                            label: '# of Request',
                            data: @json($table1_data),
                            backgroundColor: [
                                'rgba(30, 30, 30, 0.2)'
                            ],
                            borderColor: [
                                'rgba(30, 30, 30, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        layout: {
                            padding: 20
                        },
                        plugins: {
                            legend: {
                                align: 'end',
                            },
                            title: {
                                display: true,
                                text: '📈 No of Request - Day',
                                align: 'end',
                                position: 'bottom',
                                padding: {
                                    top: 20,
                                    bottom: 10
                                }
                            },

                        },
                        scales: {
                            y: {
                                ticks: {
                                precision:0
                                },
                                beginAtZero: true
                            },

                
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                const ctx1 = document.getElementById('equipment_vs_supply').getContext('2d');
                const myChart1 = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: ['Supply', 'Equipments'],
                        datasets: [{
                            borderRadius: 5,
                            label: '# of Request',
                            data: @json($table2_data),
                            backgroundColor: [
                                'rgba(30, 30, 30, 0.2)'
                            ],
                            borderColor: [
                                'rgba(30, 30, 30, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        layout: {
                            padding: 20
                        },
                        plugins: {
                            legend: {
                                align: 'end',
                            },
                            title: {
                                display: true,
                                text: '📈 No of Request - Category',
                                align: 'end',
                                position: 'bottom',
                                padding: {
                                    top: 20,
                                    bottom: 10
                                }
                            },

                        },

                        indexAxis: 'y',

                        scales: {
                            x:{
                                ticks: {
                                precision:0
                                },
                            },
                            y: {
                                beginAtZero: true
                            }
                        },
                        // plugins: {
                        //     legend: {
                        //         display: false, // by default it's top
                        //     },
                        // },
                        // ticks: {
                        //     precision: 0
                        // },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });


                const ctx2 = document.getElementById('department_request').getContext('2d');
                const myChart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: @json($table3_labels),
                        datasets: [{
                            borderRadius: 5,
                            label: '# of Request',
                            data: @json($table3_data),
                            backgroundColor: [
                                'rgba(30, 30, 30, 0.2)'
                            ],
                            borderColor: [
                                'rgba(30, 30, 30, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        layout: {
                            padding: 20
                        },
                        plugins: {
                            legend: {
                                align: 'end',
                            },
                            title: {
                                display: true,
                                text: '📈 No of Request - Department',
                                align: 'end',
                                position: 'bottom',
                                padding: {
                                    top: 20,
                                    bottom: 10
                                }
                            },

                        },


                        scales: {
                            y: {
                                ticks: {
                                precision:0
                                },
                                beginAtZero: true
                            }
                        },
                        // plugins: {
                        //     legend: {
                        //         display: false, // by default it's top
                        //     },
                        // },
                        // ticks: {
                        //     precision: 0
                        // },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
                

    
    </script>

</div>
