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
                    <input  use step="0.1" name="height" type="number" 
                        class="w-20 px-3 py-4 ml-2 border rounded-md text-black text-lg flex-1" 
                        placeholder="Set between 68-132 cm." min="68" max="132" required>
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




@endsection