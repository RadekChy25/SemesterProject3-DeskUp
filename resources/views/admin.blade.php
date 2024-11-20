@extends('layout')

<x-user>
    <x-slot:left>
        <h3>Register now.</h3>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('admin') }}" method="POST">
                @csrf
                <x-login>
                    <x-slot:heading>
                        <div class="flex items-center justify-between">
                            <label for="code" class="block text-sm font-medium text-black">Code</label>
                        </div>
                        <div class="mt-2">
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
            <p class="block w-full font-medium rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">Username: {{ $user->name }}</p>
            <button ></button>
        @endforeach
    </x-slot:right>
</x-user>