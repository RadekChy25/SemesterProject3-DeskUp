@extends('layout')

<x-user>
    <x-slot:left>
        <h3>Register now.</h3>
        <x-login>

        </x-login>
    </x-slot:left>
    <x-slot:right>
        @foreach ($users as $user)
            <p class="block w-full font-medium rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">Username: {{ $user->name }}</p>
            <button ></button>
        @endforeach
    </x-slot:right>
</x-user>