@extends('layout')

    <x-user>
        <x-slot:left>
            <h1 class="text-center text-2xl font-semibold mb-4">Control Panel</h1>
            <p class="text-center mb-6">Here you can adjust height of your desk.</p>
            
            <div class="flex justify-center space-x-4">
                <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                    <i class="fas fa-arrow-up"></i>
                </button>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                    <i class="fas fa-arrow-down"></i>
                </button>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                    STAND UP
                </button>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                    SIT DOWN
                </button>
            </div>

            <div class="mt-4 flex justify-center items-center space-x-2">
                <button class="bg-blue-500 text-white px-10 py-4 text-lg rounded-md hover:bg-blue-700 flex-1" >
                    CUSTOM
                </button>
                <input type="number" class="w-20 px-4 py-4 border rounded-md text-black text-lg flex-1" placeholder="Set between 60-240 cm." min="60" max="240">
            </div>
        </x-slot:left>
        <x-slot:right>
            <!--h1 class="text-center text-2xl font-semibold mb-4">Bottom Section</h1>
            <p class="text-center mb-6">This is the bottom section of the page.</p-->
            <div class="bg-gray-200 p-8 rounded-md shadow-inner mb-11 text-center">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Time Spent Sitting vs. Standing</h2>
                    <canvas id="sittingStandingChart" class="w-10 h-4"></canvas>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js">
                    const ctx = document.getElementById('sittingStandingChart').getContext('2d');
                    const sittingStandingChart = new Chart(ctx, {
                        type: 'bar', // Type of graph: bar chart
                        data: {
                            labels: ['Sitting', 'Standing'], // Labels for each category
                            datasets: [{
                                label: 'Time (in minutes)',
                                data: [60, 120], // Sample data: 120 minutes sitting, 60 minutes standing
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)',  // Blue for sitting
                                    'rgba(255, 99, 132, 0.2)'   // Red for standing
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',   // Blue border for sitting
                                    'rgba(255, 99, 132, 1)'    // Red border for standing
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            scales: {
                                y: {
                                    beginAtZero: true,  // Ensure the Y-axis starts at zero
                                    title: {
                                        display: true,
                                        text: 'Time (Minutes)'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                            }
                        }
                    });
                </script>
            </div>    
            <!-- Bottom Section -->
            <div class="flex justify-between space-x-4">     
                <div class="flex flex-col space-y-4">
                    <button class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">PRESETS</button>
                </div>
                <div class="flex flex-col space-y-4">
                    <button class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">MODES</button>
                </div>
                <div class="flex flex-col space-y-4">
                    <button class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">AUTO</button>
                </div>
                <div class="flex flex-col space-y-4">
                    <button class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">ACTIVITY</button>
                </div>
            </div>
        </x-slot:right>
    </x-user>