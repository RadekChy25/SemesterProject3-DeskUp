@extends('layout')

@section('content')

<x-navbar></x-navbar>
    <x-user>
        <x-slot:left>
            <h2 class="text-center text-2xl font-semibold mt-3">Register new user</h2>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-4" action="{{ route('register') }}" name="register" method="POST">
                    @csrf
                    <x-login>
                        <x-slot:heading>
                        <div class="flex items-center justify-between">
                                <label for="re-type" class="block text-sm font-medium text-black">Confirm Password</label>
                            </div>
                            <div class="mt-2">
                            <input id="re-password" name="re-password" type="password"  autocomplete="re-password" required minlength="1" maxlength="10" class="block w-full rounded-md border-0 py-1.5 pl-2 text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            </div>
                            <div class="flex items-center justify-between">
                                <label for="code" class="block text-sm font-medium text-black">Admin Code</label>
                            </div>
                            <div class=" mt-2">
                                <input type="text" id="code" name="code" placeholder="Type special code to create new admin account" minlength="5" maxlength="5" class="block w-full font-medium rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
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
            </div>
            <x-modes></x-modes>
        </x-slot:bottom>
    </x-user>
@endsection
