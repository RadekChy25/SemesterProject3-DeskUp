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

    <!-- Website Main Section -->
    <div class="container mx-auto p-4 flex space-x-8 mt-6">
        
        <!-- Left Side Section -->
        <div class="w-1/2 bg-white p-6 rounded-lg shadow-lg text-black">
            <h1 class="text-center text-2xl font-semibold mb-4">Control Panel</h1>
            <p class="text-center mb-6">Here you can adjust height of your desk.</p>
            
            <!-- Adjust Height Buttons -->
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

            <div class="mt-4 flex justify-between items-center space-x-2">
                <form action="{{route('changeHeight')}}" method='POST' class="flex flex-1">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-9 py-4 mr-2 text-lg rounded-md hover:bg-blue-700 flex-1" >
                        CUSTOM
                    </button>
                    <input name="height" type="number" class="w-20 px-3 py-4 ml-2 border rounded-md text-black text-lg flex-1" placeholder="Set between 60-240 cm." min="60" max="240">
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
                    type: 'bar', 
                    data: {
                        labels: ['Sitting', 'Standing'], 
                        datasets: [{
                            label: 'Time (in minutes)',
                            data: [60, 120], 
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',  
                                'rgba(255, 99, 132, 0.2)'   
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
                        maintainAspectRatio: true,
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
            </script>

            <!-- Buttons Section -->
            <div class="flex justify-between space-x-4">
                <div class="flex w-1/2 flex-col space-y-2">
                    <button id="presetsBtn" class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">PRESETS</button>
                </div>
                <div class="flex w-1/2 flex-col space-y-4">
                    <form action="{{route('activity')}}" method="GET" class="flex flex-1">
                        @csrf
                      <button id="activityBtn" class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">ACTIVITY</button>
                        <input type="hidden" name="height" value=200>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Templates -->
    <div id="presetsModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="bg-white p-8 rounded-lg w-full max-w-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-xl font-semibold">Presets</h2>
            <button onclick="closeModal('presetsModal')" aria-label="Close modal" class="text-gray-500 hover:text-gray-700">
                ✖
            </button>
        </div>
        <h1 class="text-gray-800 font-large  mb-5">Choose a preset option for your desk.</h1>
        
        <!-- Sitting Height -->
        <div class="mb-4">
            <label for="sittingHeight" class="block text-sm font-medium text-gray-700">Select the sitting height:</label>
            <input id="sittingHeight" name="height" type="number" 
                class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md text-gray-800 text-lg focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Set between 60-240 cm" min="60" max="240">
        </div>
        
        <!-- Standing Height -->
        <div class="mb-4">
            <label for="standingHeight" class="block text-sm font-medium text-gray-700">Select the standing height:</label>
            <input id="standingHeight" name="height" type="number" 
                class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md text-gray-800 text-lg focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Set between 60-240 cm" min="60" max="240">
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-end">
            <button onclick="closeModal('presetsModal')" 
                class="mr-2 bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">
                Cancel
            </button>
            <button onclick="submitHeights()" 
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Save
            </button>
        </div>
    </div>
</div>

    <script>
        // Existing script for user dropdown toggle
        // Toggle Dropdown Visibility
        const userIcon = document.getElementById('user-icon');
        const userDropdown = document.getElementById('user-dropdown');

        userIcon.addEventListener('click', function (event) {
            event.preventDefault();
            if (userDropdown.classList.contains('hidden')) {
                userDropdown.classList.remove('hidden');
            } else {
                userDropdown.classList.add('hidden');
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            if (!userIcon.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });

        // Modal open/close functions
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Event listeners to open modals
        document.getElementById('presetsBtn').addEventListener('click', function() {
            openModal('presetsModal');
        });
        document.getElementById('modesBtn').addEventListener('click', function() {
            openModal('modesModal');
        });
        document.getElementById('autoBtn').addEventListener('click', function() {
            openModal('autoModal');
        });
        document.getElementById('activityBtn').addEventListener('click', function() {
            openModal('activityModal');
        });
        // Handle Save Action
        function submitHeights() {
        const sittingHeight = document.getElementById('sittingHeight').value;
        const standingHeight = document.getElementById('standingHeight').value;

        if (!sittingHeight || !standingHeight) {
            alert('Please fill in both heights.');
            return;
        }

        if (sittingHeight < 60 || sittingHeight > 240 || standingHeight < 60 || standingHeight > 240) {
            alert('Heights must be between 60 and 240 cm.');
            return;
        }

        alert(`Sitting height: ${sittingHeight} cm, Standing height: ${standingHeight} cm`);
        closeModal('presetsModal');
    }
    </script>
    
    <style>
    .mode-checkbox {
        transform: scale(1.5); /* Adjust this scale value to your preference */
    }
    </style>

</body>
</html>
