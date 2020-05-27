<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ Config::get('app.name') }} @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/site/favicon.ico') }}">
    <link rel="icon" href="{{ asset('img/site/favicon.ico') }}">
</head>
<body>
    <header>
        <h1 class="sitename"><a href="{{ url('/') }}">{{ Config::get('app.name') }}</a></h1>
        <nav class="navbar">
            <ul>
                <li><a href="{{ url('contacts/add') }}" title="Add new contact"><i class="fa fa-3x fa-plus"></i></a></li>
                <li><a href="#" title="Settings"><i class="fa fa-3x fa-cog"></i></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    <footer>© 2019 Alan Dours</footer>
    <script src="{{ asset('js/index.js') }}" type="module"></script>
</body>
</html>