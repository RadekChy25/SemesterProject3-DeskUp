<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-blue-500">
    <div class="min-h-full">
        @yield('content')
    </div>
</body>
</html>
