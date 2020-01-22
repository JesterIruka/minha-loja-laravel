<!doctype html>
<html lang="pt-BR">
<head>
    <title>DVL</title>

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand">DVL</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav text-right">
                    <li class="nav-item @if (request()->is('/')) active @endif">
                        <a class="nav-link" href="{{route('index')}}">Início <span class="sr-only">(Atual)</span></a>
                    </li>
                    <li class="nav-item @if (request()->is('categories*')) active @endif">
                        <a class="nav-link" href="{{route('categories')}}">Produtos</a>
                    </li>
                    <li class="nav-item @if (request()->is('ratings')) active @endif">
                        <a class="nav-link" href="{{route('ratings.index')}}">Avaliações</a>
                    </li>
                </ul>
                <div class="text-right ml-auto">
                    <a class="p-0 nav-link @if (!request()->is('cart')) text-white-50 @else text-white @endif"
                       href="/cart">Carrinho <span class="badge badge-light">{{count(session()->get('cart', []))}}</span></a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-2">
        @include('flash::message')
        @yield('content')
    </main>

    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    @yield('script')
</body>
</html>
