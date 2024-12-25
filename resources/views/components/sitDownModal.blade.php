<div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/3 relative">
        <!-- Close button placed at the top-left corner -->
        <button onclick="closeModal()" aria-label="Close modal" class="absolute top-2 right-2 text-gray-500 font-bold hover:text-red-700 transition-colors duration-200">
            ✖
        </button>
        <br>
        <h2 class="text-xl font-bold text-center text-black mb-4">Health Alert !</h2>
        <p class="text-center text-black mb-4">You have been standing for too long. Switch to sitting position to keep good posture.</p>
        
        <br>
        <form action="{{ route('sitDown') }}" method="POST" class="flex justify-between">
            @csrf
            <!-- Switch to Sitting Position Button -->
            <button class="bg-green-500 text-white px-10 py-3 text-medium rounded-md mr-2 hover:bg-green-700 w-1/2">
                Sit Down
            </button>
            
            <!-- Ignore Button -->
            <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-10 py-3 text-medium rounded-md ml-2 hover:bg-red-700 w-1/2">
                Ignore
            </button>
        </form>
    </div>
</div>

<script>
    // Get the active session time from the Blade template variables
    // Modal element
    const modal = document.getElementById('modal');

    // Function to close the modal
    function closeModal() {
        modal.classList.add('hidden'); // Hides the modal by adding the 'hidden' class
    }

    // Check if any of the active sessions exceed 10 seconds
    if (activeStandtime > 10 || activeSittime > 10) {
        // Show the modal
        modal.classList.remove('hidden');
    }
</script>
