<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-blue-500 text-white font-sans">
    <div class="min-h-full">
        @yield('content')
    </div>
    <nav class="bg-blue-700 p-4">
        <div class="container mx-auto flex justify-between">
            <a href="/ui">
            <img src="{{ asset('images/logo-deskUp.png') }}" alt="DeskUp Logo" class="h-8 w-35">
            </a>
            <div class="flex space-x-4 relative">
                <!-- User Dropdown -->
                <div class="relative">
                    <a href="#" id="user-icon" class="text-white"><i class="fas fa-user"></i></a>
                    <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white text-black rounded-md shadow-md hidden">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                        <!-- Logout Form -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <!-- Logout button to submit the form -->
                            <button type="submit" class="block px-4 py-2 hover:bg-blue-400 w-full text-left rounded-md">Logout</button>
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
