<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restauration</title>
</head>
<body>
<nav>
        <ul>
            <li><a href="{{ route('register') }}">Inscription</a></li>
            <li><a href="{{ route('login') }}">Connexion</a></li>
        </ul>
    </nav>
    @yield('content')
</body>
</html>