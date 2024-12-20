<!-- Modal Templates -->
<div id="presetsModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="bg-white p-8 rounded-lg w-full max-w-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-xl text-black font-semibold">Presets</h2>
            <button onclick="closeModal('presetsModal')" aria-label="Close modal"  class="text-gray-500 font-bold hover:text-red-700 transition-colors duration-200" >
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
                    placeholder="Set between 68-132 cm" min="68" max="132" required>
            </div>
            
            <!-- Standing Height -->
            <div class="mb-4">
                <label for="standingHeight" class="block text-sm font-medium text-gray-700">Optimal standing height:</label>
                <input id="standingHeight" name="standingHeight" type="number" 
                    class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md text-gray-800 text-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Set between 68-132 cm" min="68" max="132" required >
            </div>
        </form>

        <!-- Action Buttons -->
        <div class="flex justify-end">
            <button onclick="closeModal('presetsModal')" 
                class="mr-2 bg-red-500 px-4 py-2 rounded-md hover:bg-red-600">
                Cancel
            </button>
            <button onclick="submitHeights()"  type="submit" form="presetsForm"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
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