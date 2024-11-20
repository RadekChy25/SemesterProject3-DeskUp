
        <div>
            <label for="name" class="block text-sm font-medium text-black">User Name</label>
            <div class="mt-2">
                <input id="name" name="name" type="text" autocomplete="name" required class="block w-full font-medium rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-black">Password</label>
                <div class="text-sm">
                    <a href="#" class="font-semibold text-black hover:text-indigo-500">Forgot password?</a>
                </div>
            </div>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 pl-2 text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            </div>
        </div>
        @isset($heading)
            {{ $heading }}
        @endisset

        <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                {{ $slot }}
            </button>
        </div>