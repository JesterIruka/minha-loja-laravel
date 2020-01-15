@extends('layouts.panel')

@section('content')
    <form action="{{route('admin.products.update', ['product'=>$product->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h1>Editar Usuário</h1>
        <hr>
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" value="{{$user->name}}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>E-Mail</label>
            <input type="email" name="email" value="{{$user->email}}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Nova Senha</label>
            <input type="password" name="password" value="" class="form-control @error('email') is-invalid @enderror">
            <small>Deixar este campo vazio significa não mudar a senha atual</small>
            @error('password')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Permissão</label>
            <select name="permission" class="form-control">
                <option value="1" @if($user->role=='1') selected @endif >{{config('store.messages')['roles'][1]}}</option>
                <option value="2" @if($user->role=='2') selected @endif >{{config('store.messages')['roles'][2]}}</option>
                <option value="3" @if($user->role=='3') selected @endif >{{config('store.messages')['roles'][3}}</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endsection
