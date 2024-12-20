@extends('layout')

@section('content')

    <x-navbar>
    </x-navbar>
    
    <x-user>
        <x-slot:left>
            <h2 class="text-center text-2xl font-semibold mt-3">Register new user</h2>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="{{ route('register') }}" name="register" method="POST">
                    @csrf
                    <x-login>
                        <x-slot:heading>
                            <div class="flex items-center justify-between">
                                <label for="code" class="block text-sm font-medium text-black">Code</label>
                            </div>
                            <div class=" mt-2">
                                <input type="text" id="code" name="code" placeholder="Code" class="block w-full font-medium rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            </div>
                        </x-slot:heading>
                        Register
                    </x-login>
                </form>
            </div>
        </x-slot:left>
        
        <x-slot:right>
            @foreach ($users as $user)
                <form class="flex flex-row m-3" action="{{ route('deletePreset') }}" name="delete" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                        @if ($user->usertype == 'admin')
                            <p class="basis-5/6 block w-full font-medium rounded-md border-0 py-1.5 pl-2 text-red-600 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">{{ $user->name }} - admin</p>
                        @else
                            <p class="basis-5/6 block w-full font-medium rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">{{ $user->name }}</p>
                        @endif
                        <button class="basis-1/6 ml-3 bg-red-400 font-medium rounded-md border-0 shadow-sm ring-1 ring-inset ring-red-400 hover:shadow-lg hover:bg-red-500 active:shadow-inner active:origin-bottom">Delete</button>
                </form>
            @endforeach
        </x-slot:right>
        

        <!-- Add the buttons section as a bottom slot -->
        <x-slot:bottom>
            <div class="w-full bg-white p-6 rounded-lg shadow-lg text-black">
                <!-- Buttons Section -->
                    <div class="flex flex-col space-y-4">
                        <button id="modesBtn" class="bg-blue-500 text-white px-8 py-4 text-lg rounded-md hover:bg-blue-700 flex-1">MODES</button>
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
        </x-slot:bottom>
    </x-user>
@endsection
