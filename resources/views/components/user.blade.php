 
<body class="bg-blue-500 text-white font-sans">

    <!-- Navbar -->
    <nav class="bg-blue-700 p-4">
    <div class="container mx-auto flex justify-between">
        <a href="#" class="text-white font-bold">DeskUp</a>
        <div class="flex space-x-4">
            <a href="#" class="text-white">I1</a>
            <a href="#" class="text-white">I2</a>
            <a href="#" class="text-white">I3</a>
        </div>
    </div>
</nav>

    <!-- Website Main Section -->
    <div class="container mx-auto p-4 flex space-x-8 mt-6">
        
        <!-- Left Side Section -->
        <div class="w-1/2 bg-white p-6 rounded-lg shadow-lg text-black">
            <h1 class="text-center text-2xl font-semibold mb-4">Top Section</h1>
            <p class="text-center mb-6">This is the top section of the page.</p>
            {{ $left }}
        </div>


        <!-- Right Side Section -->
        <div class="w-1/2 bg-white p-6 rounded-lg shadow-lg text-black">
            <h1 class="text-center text-2xl font-semibold mb-4">Bottom Section</h1>
            <p class="text-center mb-6">This is the bottom section of the page.</p>
            {{ $right }}
        </div>
    </div>

