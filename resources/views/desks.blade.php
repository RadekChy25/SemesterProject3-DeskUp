@extends('layout')

@section('content')
    <x-navbar>
    </x-navbar>

    <div class="container mx-auto p-4 flex space-x-8" id="desk_div">
        @foreach ($desks as $desk)
            <div class="w-1/6 bg-white p-6 rounded-lg shadow-lg text-black">
                <h2>Desk:{{ dd([DeskController::getDeskInfo($desk)]) }}</h2>
            </div>
        @endforeach
    </div>
@endsection