<div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/3 relative">
        <!-- Close button placed at the top-left corner -->
        <button onclick="closeModal('modal')" aria-label="Close modal" class="absolute top-2 right-2 text-gray-500 font-bold hover:text-red-700 transition-colors duration-200">
            ✖
        </button>
        <br>
        <h2 class="text-xl font-bold text-center text-black mb-4">Health Alert !</h2>
        <p class="text-center text-black mb-4">You have been sitting for too long. Switch to standing position to keep good posture.</p>
        
        <br>
        <form action="{{route('standUp')}}" method="POST" class="flex justify-between">
            @csrf
            <!-- Switch to Standing Position Button -->
            <button class="bg-green-500 text-white px-10 py-3 text-medium rounded-md mr-2 hover:bg-green-700 w-1/2">
                Stand Up
            </button>
            
            <!-- Ignore Button -->
            <button type="button" onclick="closeModal('modal')" class="bg-red-500 text-white px-10 py-3 text-medium rounded-md ml-2 hover:bg-red-700 w-1/2">
                Ignore
            </button>
        </form>
    </div>
</div>

<script>
    const modalIcon = document.getElementById('modal-icon');
    const modal = document.getElementById('modal');

    modalIcon.addEventListener('click', function (event) {
        event.preventDefault();
        modal.classList.toggle('hidden');
    });
</script>    