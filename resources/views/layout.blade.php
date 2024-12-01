<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-blue-500 text-white font-sans">
    <nav class="bg-blue-700 p-4">
        <div class="container mx-auto flex justify-between">
            <a href="/ui">
                <img src="{{ asset('images/logo-deskUp.png') }}" alt="DeskUp Logo" class="h-8 w-35">
            </a>
            <div class="flex space-x-4 relative">
                <!-- User Dropdown -->
                <div class="relative">
                    <a href="#" id="user-icon" class="text-white"><i class="fas fa-user"></i></a>
                    <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white text-black rounded-md shadow-md hidden">
                        <a href="#" class="block px-4 py-2 font-bold hover:bg-gray-200"> Welcome {{$user->name}} !</a>
                        @if($user->usertype=='admin')
                        <a href="/admin" class="block px-4 py-2 hover:bg-gray-200">Admin View</a>
                        <a href="/ui" class="block px-4 py-2 hover:bg-gray-200">User View</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block px-4 py-2 hover:bg-blue-400 w-full text-left rounded-md">Logout</button>
                        </form>                        
                    </div>                    
                </div>
                <!-- FAQ Button -->
                <form action="{{ route('faq') }}" method="GET">
                    @csrf
                    <button href="faq" class="text-white"><i class="fas fa-question-circle"></i></button>
                </form>
                <a href="#" class="text-white"><i class="fas fa-cog"></i></a>
            </div>
        </div>
    </nav>

    <div class="min-h-full">
        <!-- Main content section injected here from child views -->
        @yield('content')

        <!-- Main Navigation Bar -->
       
    </div>

    <!-- JavaScript for functionality -->
    <script>
        // Dropdown toggle
        const userIcon = document.getElementById('user-icon');
        const userDropdown = document.getElementById('user-dropdown');

        userIcon.addEventListener('click', function (event) {
            event.preventDefault();
            userDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            if (!userIcon.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
