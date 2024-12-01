@extends('layout')

@section('content')
<x-navbar>
</x-navbar>

    <!-- Main Content Section -->
    <div class="w-full mx-auto p-4 flex flex-col space-y-6">

        <!-- Page Header -->
        <header class="text-center mb-6">
            <p class="text-lg">Visualize your sitting vs. standing time effortlessly.</p>
        </header>

        <!-- Chart Section: Horizontal Layout with Flexbox -->
        <div class="flex flex-row space-x-6 w-full">

            <!-- First Chart (Sitting vs Standing) -->
            <div class="bg-white text-black p-6 rounded-lg shadow-lg w-1/3">
                <div class="bg-gray-200 p-4 rounded-md shadow-inner">
                    <h2 class="text-xl font-semibold mb-4 text-center">Time Spent Sitting vs. Standing</h2>
                    <div class="relative h-64 w-full">
                        <canvas id="sittingStandingChart" class="h-full w-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Second Chart (Activity Trend Over Time) -->
            <div class="bg-white text-black p-6 rounded-lg shadow-lg w-1/3">
                <div class="bg-gray-200 p-4 rounded-md shadow-inner">
                    <h2 class="text-xl font-semibold mb-4 text-center">Activity Trend Over Time</h2>
                    <div class="relative h-64 w-full">
                        <canvas id="activityTrendChart" class="h-full w-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Third Chart (Sitting vs Standing Percentage) -->
            <div class="bg-white text-black p-6 rounded-lg shadow-lg w-1/3">
                <div class="bg-gray-200 p-4 rounded-md shadow-inner">
                    <h2 class="text-xl font-semibold mb-4 text-center">Percentage of Sitting vs. Standing</h2>
                    <div class="relative h-64 w-full">
                        <canvas id="sittingStandingPieChart" class="h-full w-full"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
<script>
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

@endsection