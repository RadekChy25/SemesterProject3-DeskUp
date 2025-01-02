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

            @session('desk_id')
                @if($value==='no_desk') 
                    <p class="mb-6 text-red-600 text-center">
                        You have no desk selected. Log out and select a desk to use these features.
                    </p>
                @else
                    <p class="text-center mb-6">Here you can adjust height of your desk.</p>
                @endif 
            @endsession
            
            <!-- Adjust Height Buttons -->
            <div class="flex justify-center space-x-4">
                <form action="{{route('moveDesk')}}" method='POST' class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1" 
                    @session('desk_id')@if($value==='no_desk') disabled @endif @endsession>
                        <i class="fas fa-arrow-up"></i>
                    </button>
                    <input type="hidden" name="heightChange" value=5>
                </form>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <form action="{{route('moveDesk')}}" method='POST' class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1"
                    @session('desk_id')@if($value==='no_desk') disabled @endif @endsession>
                        <i class="fas fa-arrow-down"></i>
                    </button>
                    <input type="hidden" name="heightChange" value=-5>
                </form>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <form action="{{route('standUp')}}" method="POST" class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1"
                    @session('desk_id')@if($value==='no_desk') disabled @endif @endsession>
                        STAND UP
                    </button>
                </form>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <form action="{{route('sitDown')}}" method="POST" class="flex flex-1">
                    @csrf
                    <button class="bg-blue-500 text-white px-20 py-4 text-lg rounded-md hover:bg-blue-700 flex-1"
                    id="sitDownButton"
                    @session('desk_id')@if($value==='no_desk') disabled @endif @endsession>
                        SIT DOWN
                    </button>
                </form>
            </div>

            <div class="mt-4 flex justify-between items-center space-x-2">
                <form action="{{route('changeHeight')}}" method='POST' class="flex flex-1">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-9 py-4 mr-2 text-lg rounded-md hover:bg-blue-700 flex-1" 
                    @session('desk_id')@if($value==='no_desk') disabled @endif @endsession>
                        CUSTOM
                    </button>
                    <input  use step="0.1" name="height" type="number" 
                        class="w-20 px-3 py-4 ml-2 border rounded-md text-black text-lg flex-1" 
                        placeholder="Set between 68-132 cm." min="68" max="132" required
                        @session('desk_id')@if($value==='no_desk') disabled @endif @endsession>
                </form>
            </div>
        </x-slot:left>

        <!-- Right Side Section -->
        <x-slot:right>
            <x-graph>
                <x-slot:sittime>{{$sittime}}</x-slot:sittime>
                <x-slot:standtime>{{$standtime}}</x-slot:standtime>
            </x-graph>
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

    <x-presetsModal></x-presetsModal>


    <div id="standUpModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/3 relative">
            <!-- Close button placed at the top-left corner -->
            <button onclick="closeModal('standUpModal')" aria-label="Close modal" class="absolute top-2 right-2 text-gray-500 font-bold hover:text-red-700 transition-colors duration-200">
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
                <button type="button" onclick="closeModal('standUpModal')" class="bg-red-500 text-white px-10 py-3 text-medium rounded-md ml-2 hover:bg-red-700 w-1/2">
                    Ignore
                </button>
            </form>
        </div>
    </div>

    <div id="sitDownModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/3 relative">
            <!-- Close button placed at the top-left corner -->
            <button onclick="closeModal('sitDownModal')" aria-label="Close modal" class="absolute top-2 right-2 text-gray-500 font-bold hover:text-red-700 transition-colors duration-200">
                ✖
            </button>
            <br>
            <h2 class="text-xl font-bold text-center text-black mb-4">Health Alert !</h2>
            <p class="text-center text-black mb-4">You have been standing for too long. Switch to sitting position to keep good posture.</p>
            
            <br>
            <form action="{{route('sitDown')}}" method="POST" class="flex justify-between">
                @csrf
                <!-- Switch to Sitting Position Button -->
                <button class="bg-green-500 text-white px-10 py-3 text-medium rounded-md mr-2 hover:bg-green-700 w-1/2">
                    Sit Down
                </button>
                
                <!-- Ignore Button -->
                <button type="button" onclick="closeModal('stiDownModal')" class="bg-red-500 text-white px-10 py-3 text-medium rounded-md ml-2 hover:bg-red-700 w-1/2">
                    Ignore
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', 
            function() 
            {
                sitMonitor();
                standMonitor();
            }
        );

        async function sitMonitor()
        {
            sitTimeJS = @session('sitTime') {{session('sitTime')}} @endsession;
            sit_stand_logout_state = @session('sit_stand_logout_state') {{session('sit_stand_logout_state')}} @endsession;

            while(1)
            {
                if ((sit_stand_logout_state == 1) && (Date.now() - sitTimeJS > 10))
                {
                    setBuzzer(3000);

                    document.getElementById('standUpModal').classList.remove('hidden');
                    
                    fetch("http://192.168.1.107/buzzer/off");
                    return true;
                }
            }
        }

        async function standMonitor()
        {
            standTimeJS = @session('standTime') {{session('standTime')}} @endsession
            sit_stand_logout_state = @session('sit_stand_logout_state') {{session('sit_stand_logout_state')}} @endsession;

            while(1)
            {
                if (sit_stand_logout_state == 2 && Date.now() - standTimeJS > 10)
                {
                    setBuzzer(3000);

                    document.getElementById('sitDownModal').classList.remove('hidden');
                    
                    fetch("http://192.168.1.107/buzzer/off");
                    return true;
                }
            }
        }

        async function setBuzzer(time)
        {
            
            fetch("http://192.168.1.107/buzzer/off");
            fetch("http://192.168.1.107/buzzer/on");
            setTimeout(function(){fetch("http://192.168.1.107/buzzer/off");}, time);
            return;
        }
    </script>

@endsection