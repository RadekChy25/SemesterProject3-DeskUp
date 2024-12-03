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
                <a href="#" class="block px-4 py-2 font-bold">Welcome {{ Auth::user()->name }}!</a>
                    @if(Auth::check() && Auth::user()->usertype == 'admin')
                        <a href="/admin" id="admin-view-link" class="block px-4 py-2 hover:bg-blue-400">Admin View</a>
                        <a href="/ui" id="user-view-link" class="block px-4 py-2 hover:bg-blue-400">User View</a>
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