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
            <div class="flex space-x-4 relative">
                <a href="#" id="user-icon" class="text-white"><i class="fas fa-user"></i></a>
                <a href="#" class="text-white"><i class="fas fa-question-circle"></i></a>
                <a href="#" class="text-white"><i class="fas fa-cog"></i></a>
                <!-- User List Dropdown -->
                <div id="user-list-container" style="display: none; position: absolute; top: 100%; left: 0; background-color: white; border: 1px solid #ddd; padding: 10px; width: 150px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                    <ul style="list-style-type: none; padding: 0; margin: 0;">
                        <!-- Profile Button -->
                        <li>
                            <button onclick="goToProfile();" class="w-full text-left px-4 py-2 text-black hover:bg-blue-500 rounded-md">
                                Profile
                            </button>
                        </li>
                        <!-- Settings Button -->
                        <li>
                            <button onclick="goToSettings();" class="w-full text-left px-4 py-2 text-black hover:bg-blue-500 rounded-md">
                                Settings
                            </button>
                        </li>
                        <!-- Logout Button -->
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-black hover:bg-blue-500 rounded-md">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>               
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
                <form action="{{route('moveDesk')}}" method='POST' class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                    <input type="hidden" name="heightChange" value=5>
                </form>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <form action="{{route('moveDesk')}}" method='POST' class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                        <i class="fas fa-arrow-down"></i>
                    </button>
                    <input type="hidden" name="heightChange" value=-5>
                </form>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <form action="{{route('changeHeight')}}" method="POST" class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                        STAND UP
                    </button>
                    <input type="hidden" name="height" value=200>
                </form>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <form action="{{route('changeHeight')}}" method="POST" class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                        SIT DOWN
                    </button>
                    <input type="hidden" name="height" value=60>
                </form>
            </div>

            <div class="mt-4 flex justify-center items-center space-x-2">
                <form action="{{route('changeHeight')}}" method='POST' class="flex flex-1">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-10 py-4 text-lg rounded-md hover:bg-blue-700 flex-1" >
                        CUSTOM
                    </button>
                    <input name="height" type="number" class="w-20 px-4 py-4 border rounded-md text-black text-lg flex-1" placeholder="Set between 60-240 cm." min="60" max="240">
                </form>
            </div>
            @session('feedback')
                <p class="bg-green-500 mt-5 text-white px-7 py-2 text-lg rounded-md hover:bg-green-300 flex-1 text-center">
                    Desk height changed to {{$value->position_mm/10}} cms
                </p>
            @endsession
        </div>

        <!-- Right Side Section -->
        <div class="w-1/2 bg-white p-6 rounded-lg shadow-lg text-black">
            <div class="bg-gray-200 p-8 rounded-md shadow-inner mb-11 text-center">
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

            <!-- Buttons Section -->
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
        </div>
    </div>

    <script>
  document.getElementById('user-icon').addEventListener('click', function(event) {
    event.preventDefault();  // Prevent default action (like link navigation)

    var userList = document.getElementById('user-list-container');
    
    // Toggle the dropdown visibility with transition effect
    if (userList.style.display === 'none' || userList.style.display === '') {
        userList.style.display = 'block';
        userList.style.opacity = '1';
        userList.style.visibility = 'visible';
    } else {
        userList.style.opacity = '0';
        userList.style.visibility = 'hidden';
        // Add a delay to remove the display:none after fade-out effect
        setTimeout(function() {
            userList.style.display = 'none';
        }, 300);  // Timeout should match the duration of the transition
    }
});

    </script>

</body>
</html>
