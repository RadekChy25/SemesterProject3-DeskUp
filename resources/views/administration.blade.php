<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/administration.css') }}" />
    <title>DeskUp</title>
</head>
<body>
    <h2>Register new users into the system</h2>
    <div class="layout reg">
        <form action="">
            <div class="name">
                <label for="name">Name:</label><br>
                <input type="text" id="name">
            </div>
            <div class="password">
                <label for="password">Password:</label><br>
                <input type="text" id="password">
            </div>
            <div>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
    <div class="layout use">
        <div class="users">
            <ol>
                <li class="user">User</li>
            </ol>
        </div>
        
        <div class="cleaning">
            <button class="cleaningmode"></button>
        </div>
    </div>
</body>
</html>