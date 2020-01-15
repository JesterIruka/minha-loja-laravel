@extends('layouts.panel')

@section('content')
    <div class="text-right mb-2">
        <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#criar">Criar Categoria</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @if ($categories->count())
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td class="text-nowrap">
                                <div class="btn-group">
                                    <a class="btn btn-primary btn-sm" href="{{route('admin.categories.edit', ['category'=>$category->id])}}">EDITAR</a>
                                    <form action="{{route('admin.categories.destroy', ['category'=>$category->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">EXCLUIR</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <td colspan="3">Nenhuma categoria encontrada!</td>
                @endif
            </tbody>
        </table>
    </div>
    <div>
        {{$categories->links()}}
    </div>

    <div class="modal fade" id="criar">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('admin.categories.store')}}" method="post">
                    @csrf
                    <div class="modal-header text-center">
                        <h1>Criar Categoria</h1>
                    </div>
                    <div class="modal-body">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary mr-auto" data-dismiss="modal">FECHAR</button>
                        <button type="submit" class="btn btn-primary">CRIAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
