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
    <!-- Main Content -->
    <div class="container mx-auto p-4 flex justify-center mt-6">
        <div class="w-full max-w-4xl bg-white p-6 rounded-lg shadow-lg text-black">
            <h1 class="text-center text-2xl font-semibold mb-6">Frequently Asked Questions</h1>
            <div class="space-y-4">

                <!-- FAQ Item 1 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq1')">
                        <span>What is DeskUp?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq1" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        DeskUp is an adjustable desk system that allows you to switch between sitting and standing positions effortlessly. It promotes a healthier working style.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq2')">
                        <span>How do I adjust the desk height?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq2" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        You can adjust the desk height using the control panel on the DeskUp app or the physical buttons on the desk. The desk allows you to customize the height between 60 cm and 240 cm.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq3')">
                        <span>What are the benefits of standing desks?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq3" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        Standing desks can help improve posture, increase energy levels, and reduce the risk of back pain. They also encourage more movement during the workday, which benefits overall health.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq4')">
                        <span>Can I save custom height presets?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq4" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        Yes, DeskUp allows you to save sitting and standing height presets. Use the "Presets" feature in the control panel to set and save your preferred heights.
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq5')">
                        <span>Does DeskUp track my activity?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq5" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        Yes, DeskUp includes an activity tracker to monitor how much time you spend sitting and standing, helping you maintain a balanced work routine.
                    </div>
                <div class="flex justify-center mt-6">
                    <form action="{{ route('ui') }}" method="GET">
                        <button href="ui" class="w-full justify-center items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="">
                            Go back
                        </button>
                    </form>
                    
            </div>
            </div>
    </div>

    <script>
        function toggleFaq(faqId) {
            const faq = document.getElementById(faqId);
            if (faq.classList.contains('hidden')) {
                faq.classList.remove('hidden');
            } else {
                faq.classList.add('hidden');
            }
        }
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
