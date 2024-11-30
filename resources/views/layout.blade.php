<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-blue-500 text-white font-sans">
    <div class="min-h-full">
        @yield('content')
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button href="logout" class="block px-4 py-2 hover:bg-blue-400 flex w-full">Logout</button>
    </form>   
</body>
</html>
