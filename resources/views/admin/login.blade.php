@extends('layouts.panel')

@section('content')
    <div class="offset-md-3 col-md-6 mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h1>Login</h1>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group text-center">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Lembre de mim</label>
                    </div>
                    <hr>
                    <div class="form-group">
                        <input type="submit" value="Entrar" class="btn btn-primary btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
