@extends('layouts.panel')

@section('content')
    <form action="{{route('admin.categories.update', ['category'=>$category->id])}}" method="post">
        @csrf
        @method('PUT')
        <h1>Editar Categoria</h1>
        <hr>
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" value="{{$category->name}}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endsection
