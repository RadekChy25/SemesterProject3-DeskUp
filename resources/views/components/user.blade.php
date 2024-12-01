
    <!-- Website Main Section -->
    <div class="container mx-auto p-4 flex space-x-8 mt-6">
        
        <!-- Left Side Section -->
        <div class="w-1/2 bg-white p-6 rounded-lg shadow-lg text-black">
            {{ $left }}
        </div>


        <!-- Right Side Section -->
        <div class="w-1/2 bg-white p-6 rounded-lg shadow-lg text-black">
            {{ $right }}
        </div>

        <!-- Bottom Section -->
    </div>
    <div class="container mx-auto p-4 flex space-x-8 ">
            <!-- Bottom Section -->
    <div class="mt-auto w-full">
        {{ $bottom }}
    </div>
    </div>
    
    <div id="modesModal" class="modal hidden text-black fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-8 rounded-lg w-1/2">
        <h2 class="text-xl font-semibold mb-4">Modes</h2>
        <p style="padding-bottom: 5%;">Select a mode for your desk:</p>

        <!-- Mode selection checkboxes -->
        <div class="mb-4">
            <!-- Mode 1 with start hour, duration, and desk height -->
            <label class="flex items-center mb-2">
                <input type="checkbox" id="mode1Checkbox" class="mode-checkbox mr-2">
                <span class="mode-btn bg-blue-500 text-white px-4 py-2 rounded-md w-full">Cleaning Mode</span>
            </label>
            <div class="flex items-center mb-4 pl-8">
                <label for="mode1StartHour" class="mr-2">Start Hour:</label>
                <input type="time" id="mode1StartHour" class="mr-4">
                <label for="mode1Duration" class="mr-2">Duration (minutes):</label>
                <input type="number" id="mode1Duration" min="1" max="1440" class="w-16 mr-4">
                <label for="mode1Height" class="mr-2">Desk Height (cm):</label>
                <input type="number" id="mode1Height" min="60" max="240" class="w-16">
            </div>

            <!-- Mode 2 with start hour, duration, and desk height -->
            <label class="flex items-center mb-2">
                <input type="checkbox" id="mode2Checkbox" class="mode-checkbox mr-2">
                <span class="mode-btn bg-green-500 text-white px-4 py-2 rounded-md w-full">Some Fancy Mode</span>
            </label>
            <div class="flex items-center mb-4 pl-8">
                <label for="mode2StartHour" class="mr-2">Start Hour:</label>
                <input type="time" id="mode2StartHour" class="mr-4">
                <label for="mode2Duration" class="mr-2">Duration (minutes):</label>
                <input type="number" id="mode2Duration" min="1" max="1440" class="w-16 mr-4">
                <label for="mode2Height" class="mr-2">Desk Height (cm):</label>
                <input type="number" id="mode2Height" min="60" max="240" class="w-16">
            </div>

            <!-- Mode 3 with start hour, duration, and desk height -->
            <label class="flex items-center">
                <input type="checkbox" id="mode3Checkbox" class="mode-checkbox mr-2">
                <span class="mode-btn bg-red-500 text-white px-4 py-2 rounded-md w-full">Disco Mode</span>
            </label>
            <div class="flex items-center pl-8">
                <label for="mode3StartHour" class="mr-2">Start Hour:</label>
                <input type="time" id="mode3StartHour" class="mr-2">
                <label for="mode3Duration" class="mr-2">Duration (minutes):</label>
                <input type="number" id="mode3Duration" min="1" max="1440" class="w-16 mr-4">
                <label for="mode3Height" class="mr-2">Desk Height (cm):</label>
                <input type="number" id="mode3Height" min="60" max="240" class="w-16">
            </div>
        </div>
        <div class="flex justify-end space-x-4">
            <button onclick="saveSettings()" class="bg-blue-500 text-white px-6 py-2 rounded-md">Save</button>
            <button onclick="closeModal('modesModal')" class="bg-gray-500 text-white px-6 py-2 rounded-md">Cancel</button>
        </div>
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
        document.getElementById('modesBtn').addEventListener('click', function() {
            openModal('modesModal');
        });
    </script>

