@extends('layout')

@section('content')
    <body class="bg-blue-500">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto" src="{{ asset('images/logo.png') }}" alt="Your Company">
                <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-white">Sign in to your account</h2>
            </div>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <x-login>
                        Sign in
                    </x-login>
                </form>
            </div>
        </div>
    </body>
@endsection