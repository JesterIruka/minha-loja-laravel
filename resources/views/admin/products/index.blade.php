@extends('layouts.panel')

@section('content')
    <div class="text-right mb-2">
        <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#criar">Criar Produto</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Variações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count())
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->variations->count()}}</td>
                            <td class="text-nowrap">
                                <div class="btn-group">
                                    <a class="btn btn-primary btn-sm" href="{{route('admin.products.edit', ['product'=>$product->id])}}">EDITAR</a>
                                    <form action="{{route('admin.products.destroy', ['product'=>$product->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">EXCLUIR</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <td colspan="3">Nenhum produto encontrado!</td>
                @endif
            </tbody>
        </table>
    </div>
    <div>
        {{$products->links()}}
    </div>

    <div class="modal fade" id="criar">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('admin.products.store')}}" method="post">
                    @csrf
                    <div class="modal-header text-center">
                        <h1>Criar Produto</h1>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Categoria</label>
                            <select name="category_id" class="form-control">
                                <option value="null" disabled selected>Escolha uma Categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
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
