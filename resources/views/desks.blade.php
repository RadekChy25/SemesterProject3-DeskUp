@extends('layout')

@section('content')
    <x-navbar>
    </x-navbar>
    <h1 class=" font-bold text-white text-6xl text-center my-8">Choose a desk !</h1>
    <div class=" flex flex-row flex-wrap container m-auto p-4 space-x-8" id="desk_div">
        @foreach ($desks as $desk)
        <form action="{{ route('getdeskname') }}" method="post">
            @csrf
            <input type="hidden" name="desk" value="{{ $desk }}">
            <button>
                <div class=" text-center flex-1 w-auto bg-white p-6 rounded-lg shadow-lg text-black mt-4">
                    <h2>Desk:{{ $desk }}</h2>
                </div>
            </button>
        </form>
        @endforeach
    </div>
@endsection