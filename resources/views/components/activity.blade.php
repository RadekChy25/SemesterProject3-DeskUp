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
<body class="bg-blue-500 text-white font-sans min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-blue-700 p-4">
        <div class="container mx-auto flex justify-between">
            <a href="/ui">
            <img src="{{ asset('images/logo-deskUp.png') }}" alt="DeskUp Logo" class="h-8 w-35" > 
            <a>
            <div class="flex space-x-4 relative">
                <!-- User Dropdown -->
                <div class="relative">
                    <a href="#" id="user-icon" class="text-white"><i class="fas fa-user"></i></a>
                    <div id="user-dropdown" 
                         class="absolute right-0 mt-2 w-48 bg-white text-black rounded shadow-md hidden">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button href="logout" class="block px-4 py-2 hover:bg-blue-400 flex w-full">Logout</button>
                        </form>                        
                    </div>
                </div>
                    <form action="{{ route('faq') }}" method="GET">
                            @csrf
                            <button href="faq" class="text-white"><i class="fas fa-question-circle"></i></button>
                        </form>
                <a href="#" class="text-white"><i class="fas fa-cog"></i></a>
            </div>
        </div>
    </nav>

    <!-- Main Content Section -->
    <div class="container mx-auto p-4 flex flex-col space-y-6">

        <!-- Page Header -->
        <header class="text-center mb-6">
            <p class="text-lg">Visualize your sitting vs. standing time effortlessly.</p>
        </header>

        <!-- Chart Section: Horizontal Layout with Flexbox -->
        <div class="flex flex-row space-x-6">

            <!-- First Chart (Sitting vs Standing) -->
            <div class="bg-white text-black p-6 rounded-lg shadow-lg w-1/3">
                <div class="bg-gray-200 p-4 rounded-md shadow-inner">
                    <h2 class="text-xl font-semibold mb-4 text-center">Time Spent Sitting vs. Standing</h2>
                    <div class="relative h-64 w-full">
                        <canvas id="sittingStandingChart" class="h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Second Chart (Activity Trend Over Time) -->
            <div class="bg-white text-black p-6 rounded-lg shadow-lg w-1/3">
                <div class="bg-gray-200 p-4 rounded-md shadow-inner">
                    <h2 class="text-xl font-semibold mb-4 text-center">Activity Trend Over Time</h2>
                    <div class="relative h-64 w-full">
                        <canvas id="activityTrendChart" class="h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Third Chart (Sitting vs Standing Percentage) -->
            <div class="bg-white text-black p-6 rounded-lg shadow-lg w-1/3">
                <div class="bg-gray-200 p-4 rounded-md shadow-inner">
                    <h2 class="text-xl font-semibold mb-4 text-center">Percentage of Sitting vs. Standing</h2>
                    <div class="relative h-64 w-full">
                        <canvas id="sittingStandingPieChart" class="h-full"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Chart.js Script -->
    <script>
        // Initialize Bar Chart: Sitting vs Standing
        const ctx1 = document.getElementById('sittingStandingChart').getContext('2d');
        const sittingStandingChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Sitting', 'Standing'],
                datasets: [{
                    label: 'Time (in minutes)',
                    data: [60, 120],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
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

        // Initialize Line Chart: Activity Trend Over Time
        const ctx2 = document.getElementById('activityTrendChart').getContext('2d');
        const activityTrendChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                datasets: [{
                    label: 'Sitting (minutes)',
                    data: [60, 70, 90, 80, 75],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: false,
                    tension: 0.1
                }, {
                    label: 'Standing (minutes)',
                    data: [120, 110, 90, 100, 95],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
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

        // Initialize Pie Chart: Sitting vs Standing Percentage
        const ctx3 = document.getElementById('sittingStandingPieChart').getContext('2d');
        const sittingStandingPieChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Sitting', 'Standing'],
                datasets: [{
                    label: 'Percentage',
                    data: [60, 40],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    </script>

</body>
</html>
