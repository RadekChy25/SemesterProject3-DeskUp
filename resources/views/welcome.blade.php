<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeskUp</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>  
<body class="bg-blue-500 text-white font-sans">

    <!-- Navbar -->
    <nav class="bg-blue-700 p-4">
        <div class="container mx-auto flex justify-between">
            <img src="{{ asset('images/logo-deskUp.png') }}" alt="DeskUp Logo" class="h-8 w-35">
            <div class="flex space-x-4">
                <a href="#" class="text-white"><i class="fas fa-user"></i></a>
                <a href="#" class="text-white"><i class="fas fa-question-circle"></i></a>
                <a href="#" class="text-white"><i class="fas fa-cog"></i></a>
            </div>
        </div>
    </nav>

    <!-- Website Main Section -->
    <div class="container mx-auto p-4 flex space-x-8 mt-6">
        
        <!-- Left Side Section -->
        <div class="w-1/2 bg-white p-6 rounded-lg shadow-lg text-black">
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
        </div>

        <!-- Right Side Section -->
        <div class="w-1/2 bg-white p-6 rounded-lg shadow-lg text-black">
            <!--h1 class="text-center text-2xl font-semibold mb-4">Bottom Section</h1>
            <p class="text-center mb-6">This is the bottom section of the page.</p-->
            <div class="bg-gray-200 p-4 rounded-md shadow-inner mb-6 text-center">
            <div class="bg-gray-200 p-4 rounded-md shadow-inner mb-6 text-center">
                <h2 class="text-xl font-semibold mb-4">Time Spent Sitting vs. Standing</h2>
                <canvas id="sittingStandingChart" class="w-10 h-4"></canvas>
                    </div>
                        <script>
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

            <!-- Buttons Section -->
            <div class="flex justify-between space-x-4">
                <!-- Left Buttons -->
                <div class="flex flex-col space-y-4">
                    <button class="bg-blue-500 text-white px-6 py-4 text-lg rounded-md hover:bg-blue-700">INFO</button>
                    <button class="bg-blue-500 text-white px-6 py-4 text-lg rounded-md hover:bg-blue-700">PRESETS</button>
                    <button class="bg-blue-500 text-white px-6 py-4 text-lg rounded-md hover:bg-blue-700">MODE</button>
                </div>
                
                <!-- Right Buttons -->
                <div class="flex flex-col space-y-4">
                    <button class="bg-blue-500 text-white px-6 py-4 text-lg rounded-md hover:bg-blue-700">ACTIVITY</button>
                    <button class="bg-blue-500 text-white px-6 py-4 text-lg rounded-md hover:bg-blue-700">AUTO</button>
                    <button class="bg-blue-500 text-white px-6 py-4 text-lg rounded-md hover:bg-blue-700">BLANK</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
