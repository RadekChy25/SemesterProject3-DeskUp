<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeskUP</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-blue-1000 font-sans">
    <div class="flex min-h-full flex-col justify-center px-24 py-24 lg:px-10">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
          <img class="mx-auto h-auto w-auto" src="{{ asset('images/loginLogo.png') }}" alt="Your Company">
          <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-300 py-2">Sign in to your account</h2>
        </div>
      
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
          <form class="space-y-6" action="#" method="POST">
            <div>
              <label for="email" class="block text-sm/6 font-medium text-gray-300">Email address</label>
              <div class="mt-2">
                <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
              </div>
            </div>
      
            <div>
              <div class="flex items-center justify-between">
                <label for="password" class="block text-sm/6 font-medium text-gray-400">Password</label>
                <div class="text-sm">
                  <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                </div>
              </div>
              <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
              </div>
            </div>
      
            <div>
              <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
            </div>
          </form>
        </div>
      </div>      
</body>
</htm