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
                    
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="desks"  class="block text-sm font-medium {{ request()->is('login') ? 'text-white' : 'text-grey-900' }}">Choose desk:</label>
                        </div>
                        <div class="mt-2">
                            <select name="desks" id="desks" class="block w-full rounded-md border-0 py-1.5 pl-2 text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                <option value="no_desk">No desk</option>
                                @for ($i=0; $i<count($desk_names); $i++)
                                    <option value="{{$desk_ids[$i]}}">{{$desk_names[$i]}}</option>                    
                                @endfor
                            </select>
                        </div>
                    </div>

                    <x-login>
                        Sign in
                    </x-login>
                </form>
            </div>
        </div>
    </body>
@endsection