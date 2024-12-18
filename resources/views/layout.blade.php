<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header>
        <h1>Базовый Шаблон</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>Футер сайта</p>
    </footer>
</body>
</html>
