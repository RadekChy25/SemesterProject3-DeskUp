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
                <button id="presetButton" class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700">PRESETS</button>
                <button id="modesButton" class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700">MODES</button>
                <button id="autoButton" class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700">AUTO</button>
                <button id="activityButton" class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700">ACTIVITY</button>
            </div>
        </div>
    </div>
    <!-- Modals Modals Modals Modals Modals Modals Modals Modals Modals Modals Modals Modals-->
    <!-- Presets Modal -->
    <div id="presetModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 text-black">
        <h2 class="text-2xl font-semibold mb-6 text-center">Set Your Presets</h2>
        
        <!-- Sitting Height -->
        <div class="mb-6">
            <label for="sittingHeight" class="block text-lg font-medium mb-2">Sitting Height:</label>
            <input type="number" id="sittingHeight" 
                   class="w-full px-4 py-2 border rounded-md text-black text-lg" 
                   placeholder="Set between 60-240 cm" 
                   min="60" max="240">
            <p class="text-sm text-gray-600 mt-1">Enter a value in centimeters for sitting height.</p>
        </div>

        <!-- Standing Height -->
        <div class="mb-6">
            <label for="standingHeight" class="block text-lg font-medium mb-2">Standing Height:</label>
            <input type="number" id="standingHeight" 
                   class="w-full px-4 py-2 border rounded-md text-black text-lg" 
                   placeholder="Set between 60-240 cm" 
                   min="60" max="240">
            <p class="text-sm text-gray-600 mt-1">Enter a value in centimeters for standing height.</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4">
            <button id="savePreset" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Save
            </button>
            <button id="closePresetModal" 
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700">
                Close
            </button>
        </div>
    </div>
</div>


    <!-- Modes Modal -->
    <div id="modesModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 text-black">
            <h2 class="text-xl font-semibold mb-4">Modes</h2>
            <p>Switch between modes here.</p>
            <button id="closeModesModal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Close</button>
        </div>
    </div>

    <!-- Auto Modal -->
    <div id="autoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 text-black">
            <h2 class="text-xl font-semibold mb-4">Auto</h2>
            <p>Enable auto adjustments here.</p>
            <button id="closeAutoModal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Close</button>
        </div>
    </div>

    <!-- Activity Modal -->
    <div id="activityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 text-black">
            <h2 class="text-xl font-semibold mb-4">Activity</h2>
            <p>Track your activity here.</p>
            <button id="closeActivityModal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Close</button>
        </div>
    </div>

    <!-- Modal Script -->
    <<script>
    // Helper function to toggle modal visibility
    const toggleModal = (modalId, action) => {
        const modal = document.getElementById(modalId);
        if (action === 'show') {
            modal.classList.remove('hidden');
        } else if (action === 'hide') {
            modal.classList.add('hidden');
        }
    };

    // Attach event listeners after the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', () => {
        // Preset Button and Modal
        const presetButton = document.getElementById('presetButton');
        const presetModal = document.getElementById('presetModal');
        const closePresetModal = document.getElementById('closePresetModal');

        presetButton.addEventListener('click', () => toggleModal('presetModal', 'show'));
        closePresetModal.addEventListener('click', () => toggleModal('presetModal', 'hide'));

        // Modes Button and Modal
        const modesButton = document.getElementById('modesButton');
        const modesModal = document.getElementById('modesModal');
        const closeModesModal = document.getElementById('closeModesModal');

        modesButton.addEventListener('click', () => toggleModal('modesModal', 'show'));
        closeModesModal.addEventListener('click', () => toggleModal('modesModal', 'hide'));

        // Auto Button and Modal
        const autoButton = document.getElementById('autoButton');
        const autoModal = document.getElementById('autoModal');
        const closeAutoModal = document.getElementById('closeAutoModal');

        autoButton.addEventListener('click', () => toggleModal('autoModal', 'show'));
        closeAutoModal.addEventListener('click', () => toggleModal('autoModal', 'hide'));

        // Activity Button and Modal
        const activityButton = document.getElementById('activityButton');
        const activityModal = document.getElementById('activityModal');
        const closeActivityModal = document.getElementById('closeActivityModal');

        activityButton.addEventListener('click', () => toggleModal('activityModal', 'show'));
        closeActivityModal.addEventListener('click', () => toggleModal('activityModal', 'hide'));
    });
</script>

