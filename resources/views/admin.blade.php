@extends('layout')

<x-user>
    <x-slot:left>
        <h2 class="text-center text-2xl font-semibold mt-3">Register new user</h2>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('register')}}" name="register" method="POST">
                @csrf
                <x-login>
                    <x-slot:heading>
                        <div class="flex items-center justify-between">
                            <label for="code" class="block text-sm font-medium text-black">Code</label>
                        </div>
                        <div>
                            <input type="text" id="code" name="code" placeholder="Code" class="block w-full font-medium rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                        </div>
                    </x-slot:heading>
                    Sign up
                </x-login>
            </form>
        </div>
    </x-slot:left>
    <x-slot:right>
        @foreach ($users as $user)
            <form class="flex flex-row m-3" action="{{route('delete')}}" name="delete" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <p class="basis-5/6 block w-full font-medium rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">{{ $user->name }}</p>
                <button class="basis-1/6 ml-3 bg-red-400 font-medium rounded-md border-0 shadow-sm ring-1 ring-inset ring-red-400 hover:shadow-lg hover:bg-red-500 active:shadow-inner active:origin-bottom">Delete</button>
            </form>
        @endforeach
    </x-slot:right>
</x-user>