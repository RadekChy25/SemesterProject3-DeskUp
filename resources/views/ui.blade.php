@extends('layout')

@section('content')

    <x-navbar>
    </x-navbar>

    <x-user>
        <x-slot:left>
            <h1 class="text-center text-2xl font-semibold mb-4">Control Panel</h1>
            
            @session('feedback')
                <p class="bg-green-500 mt-5 text-white px-7 py-2 text-lg rounded-md hover:bg-green-300 flex-1 text-center">
                    @if (@isset($value->position_mm))
                        Desk height changed to {{$value->position_mm/10}} cms
                    @else
                        {{$value}}
                    @endif
                </p>
            @endsession

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
                <form action="{{route('standUp')}}" method="POST" class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                        STAND UP
                    </button>
                </form>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <form action="{{route('sitDown')}}" method="POST" class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">
                        SIT DOWN
                    </button>
                </form>
            </div>

            <div class="mt-4 flex justify-between items-center space-x-2">
                <form action="{{route('changeHeight')}}" method='POST' class="flex flex-1">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-9 py-4 mr-2 text-lg rounded-md hover:bg-blue-700 flex-1" >
                        CUSTOM
                    </button>
                    <input  use step="0.1" name="height" type="number" class="w-20 px-3 py-4 ml-2 border rounded-md text-black text-lg flex-1" placeholder="Set between 68-132 cm." min="68" max="132">
                </form>
            </div>
        </x-slot:left>

        <!-- Right Side Section -->
        <x-slot:right>
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
                            @if(@isset($sittime)&&@isset($standtime))
                                data: [{{$sittime}}, {{$standtime}}],
                            @endif 
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
        </x-slot:right>
        <x-slot:bottom>
        </x-slot:bottom>
    </x-user>

    <!-- Modal Templates -->
    <div id="presetsModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="bg-white p-8 rounded-lg w-full max-w-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-xl font-semibold">Presets</h2>
            <button onclick="closeModal('presetsModal')" aria-label="Close modal" class="text-gray-500 hover:text-gray-700">
                ✖
            </button>
        </div>
        <h1 class="text-gray-800 font-large  mb-5">Set your height to calculate optimal desk heights and set your presets.</h1>
        
        <form action="{{route('setpresets')}}" method="POST" id="presetsForm">
            @csrf

            <div class="mb-4">
                <label for="userHeight" class="block text-sm font-medium text-gray-700">Your Height (cm):</label>
                <input id="userHeight" name="userHeight" type="number"
                    class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md text-gray-800 text-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Enter your height in cm" min="100" max="220" oninput="calculateHeights()">
            </div>
            <!-- Sitting Height -->
            <div class="mb-4">
                <label for="sittingHeight" class="block text-sm font-medium text-gray-700">Optimal sitting height:</label>
                <input id="sittingHeight" name="sittingHeight" type="number" 
                    class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md text-gray-800 text-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Set between 68-132 cm" min="68" max="132">
                <input type="hidden" name="name" value="sitting">
            </div>
            
            <!-- Standing Height -->
            <div class="mb-4">
                <label for="standingHeight" class="block text-sm font-medium text-gray-700">Optimal standing height:</label>
                <input id="standingHeight" name="standingHeight" type="number" 
                    class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md text-gray-800 text-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Set between 68-132 cm" min="68" max="132">
                <input type="hidden" name="name" value="standing">
            </div>
        </form>

        <!-- Action Buttons -->
        <div class="flex justify-end">
            <button onclick="closeModal('presetsModal')" 
                class="mr-2 bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">
                Cancel
            </button>
            <button onclick="submitHeights()"  type="submit" form="presetsForm"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Save
            </button>
        </div>
    </div>
</div>

<script>
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
    document.getElementById('activityBtn').addEventListener('click', function() {
        openModal('activityModal');
    });

    // Calculate Heights
    function calculateHeights() {
        const deskMin = 68; // Minimum desk height
        const deskMax = 132; // Maximum desk height
        const userHeight = parseFloat(document.getElementById('userHeight').value);

        if (!isNaN(userHeight) && userHeight > 0) {
            // Calculate suggested sitting and standing desk heights
            let sittingHeight = (userHeight * 0.39).toFixed(1);
            let standingHeight = (userHeight * 0.63).toFixed(1);

            // Apply constraints for sitting and standing heights
            sittingHeight = Math.max(sittingHeight, deskMin).toFixed(1);
            standingHeight = Math.min(Math.max(standingHeight, deskMin), deskMax).toFixed(1);

            // Set the values in the form
            document.getElementById('sittingHeight').value = sittingHeight;
            document.getElementById('standingHeight').value = standingHeight;
        } else {
            alert("Please enter a valid positive numeric value for height.");
        }
    }

    function submitHeights() {
    const sittingHeight = parseFloat(document.getElementById('sittingHeight').value);
    const standingHeight = parseFloat(document.getElementById('standingHeight').value);

    // Check if either value is empty
    if (!sittingHeight || !standingHeight) {
        alert('Please fill in both heights.');
        return;
    }

    // Prevent saving if sittingHeight > standingHeight
    if (sittingHeight > standingHeight) {
        alert('Sitting Height cannot be greater than Standing Height.');
        return;
    }

    // Ensure values are within range
    if (sittingHeight < 68 || sittingHeight > 132 || standingHeight < 68 || standingHeight > 132) {
        alert('Heights must be between 68 and 132 cm.');
        return;
    }

    // If all validations pass, save the heights
    alert(`Sitting height: ${sittingHeight} cm, Standing height: ${standingHeight} cm`);
    closeModal('presetsModal');
}
</script>



@endsection