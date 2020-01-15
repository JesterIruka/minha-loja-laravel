<!doctype html>
<html lang="pt-BR">
<head>
    <title>ADMIN</title>

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
        @auth
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand">DVL</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav text-right">
                    <li class="nav-item @if (request()->is('admin/dashboard')) active @endif">
                        <a class="nav-link" href="/admin/dashboard">Dashboard <span class="sr-only">(Atual)</span></a>
                    </li>
                    <li class="nav-item @if (request()->is('admin/categories*')) active @endif">
                        <a class="nav-link" href="/admin/categories">Categorias</a>
                    </li>
                    <li class="nav-item @if (request()->is('admin/products*')) active @endif">
                        <a class="nav-link" href="/admin/products">Produtos</a>
                    </li>
                    <li class="nav-item @if (request()->is('admin/sales*')) active @endif">
                        <a class="nav-link" href="/admin/sales">Vendas</a>
                    </li>
                    <li class="nav-item @if (request()->is('admin/users*')) active @endif">
                        <a class="nav-link" href="/admin/users">Usuários</a>
                    </li>
                </ul>
                <div class="form-inline float-right ml-auto">
                    <form method="post" action="{{route('logout')}}">
                        @csrf
                        <button class="btn btn-danger btn-sm">Sair</button>
                    </form>
                </div>
            </div>
        </nav>
        @endauth
    </header>

    <main class="container my-2">
        @include('flash::message')
        @yield('content')
    </main>

    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script src="/assets/js/jquery.mask.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    @yield('script')
</body>
</html>
