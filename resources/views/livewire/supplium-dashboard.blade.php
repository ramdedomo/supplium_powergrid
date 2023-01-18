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


    <div class="grid grid-cols-2 gap-2">
        <div class="col-span-1 h-72 p-2 bg-gray-50 rounded-md border-2 border-secondary-200">
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-span-1 h-72 p-2 bg-gray-50 rounded-md border-2 border-secondary-200">
            <canvas id="myChart2"></canvas>
        </div>
    </div>


    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
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


        const ctx1 = document.getElementById('myChart2').getContext('2d');
        const myChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
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
    </script>

</div>
