<div id="modesModal" class="modal hidden text-black fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                        <div class="bg-white p-8 rounded-lg w-1/2">
                            <h2 class="text-xl font-semibold mb-4">Modes</h2>
                            <p style="padding-bottom: 5%;">Select a mode for your desk:</p>
                    
                            <!-- Mode selection checkboxes -->
                            <div class="mb-4">
                                <!-- Mode 1 with start hour, duration, and desk height -->
                                <form action="{{route('setmodes')}}", method="POST" id="setModesForm">
                                    @csrf
                                    <label class="flex items-center mb-2">
                                        <input type="checkbox" id="mode1Checkbox" class="mode-checkbox mr-2" name="cleanCheckbox" 
                                        @if(@isset($cleaningmode)&&$cleaningmode->is_active) checked @endif>
                                        <span class="mode-btn bg-blue-500 text-white px-4 py-2 rounded-md w-full">Cleaning Mode</span>
                                    </label>
                                    <div class="flex items-center mb-4 pl-8">
                                        <label for="mode1StartHour" class="mr-2">Start Hour:</label>
                                        <input type="time" id="mode1StartHour" class="mr-4" name="cleanStartHour" 
                                        @if(@isset($cleaningmode)) value="{{$cleaningmode->start_time}}" @endif>
                                        <label for="mode1Duration" class="mr-2">Duration (minutes):</label>
                                        <input type="number" id="mode1Duration" min="1" max="1440" class="w-16 mr-4" name="cleanDuration"
                                        @if(@isset($cleaningmode)) value="{{$cleaningmode->duration}}" @endif>
                                        <label for="mode1Height" class="mr-2">Desk Height (cm):</label>
                                        <input type="number" id="mode1Height" min="68" max="132" class="w-16" name="cleanHeight"
                                        @if(@isset($cleaningmode)) value="{{$cleaningmode->height}}" @endif>
                                    </div>

                                    <!-- Mode 2 with start hour, duration, and desk height -->
                                    <label class="flex items-center mb-2">
                                        <input type="checkbox" id="mode2Checkbox" class="mode-checkbox mr-2" name="fancyCheckbox" 
                                        @if(@isset($fancymode)&&$fancymode->is_active) checked @endif>
                                        <span class="mode-btn bg-green-500 text-white px-4 py-2 rounded-md w-full">Fancy Mode</span>
                                    </label>
                                    <div class="flex items-center mb-4 pl-8">
                                        <label for="mode2StartHour" class="mr-2">Start Hour:</label>
                                        <input type="time" id="mode2StartHour" class="mr-4" name="fancyStartHour"
                                        @if(@isset($fancymode)) value="{{$fancymode->start_time}}" @endif>
                                        <label for="mode2Duration" class="mr-2">Duration (minutes):</label>
                                        <input type="number" id="mode2Duration" min="1" max="1440" class="w-16 mr-4" name="fancyDuration"
                                        @if(@isset($fancymode)) value="{{$fancymode->duration}}" @endif>
                                        <label for="mode2Height" class="mr-2">Desk Height (cm):</label>
                                        <input type="number" id="mode2Height" min="68" max="132" class="w-16" name="fancyHeight"
                                        @if(@isset($fancymode)) value="{{$fancymode->height}}" @endif>
                                    </div>

                                    <!-- Mode 3 with start hour, duration, and desk height -->
                                    <label class="flex items-center">
                                        <input type="checkbox" id="mode3Checkbox" class="mode-checkbox mr-2" name="discoCheckbox"
                                        @if(@isset($discomode)&&$discomode->is_active) checked @endif>
                                        <span class="mode-btn bg-red-500 text-white px-4 py-2 rounded-md w-full">Disco Mode</span>
                                    </label>
                                    <div class="flex items-center pl-8">
                                        <label for="mode3StartHour" class="mr-2">Start Hour:</label>
                                        <input type="time" id="mode3StartHour" class="mr-2" name="discoStartHour"
                                        @if(@isset($discomode)) value="{{$discomode->start_time}}" @endif>
                                        <label for="mode3Duration" class="mr-2">Duration (minutes):</label>
                                        <input type="number" id="mode3Duration" min="1" max="1440" class="w-16 mr-4" name="discoDuration"
                                        @if(@isset($discomode)) value="{{$discomode->duration}}" @endif>
                                        <label for="mode3Height" class="mr-2">Desk Height (cm):</label>
                                        <input type="number" id="mode3Height" min="68" max="132" class="w-16" name="discoHeight"
                                        @if(@isset($discomode)) value="{{$discomode->height}}" @endif>
                                    </div>
                                </form>
                            </div>
                            <div class="flex justify-end space-x-4">
                                <button type="submit" form="setModesForm" class="bg-blue-500 text-white px-6 py-2 rounded-md" >Save</button>
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