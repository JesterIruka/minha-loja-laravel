@extends('layouts.panel')

@section('content')
    <form action="{{route('admin.products.update', ['product'=>$product->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h1>Editar Produto</h1>
        <hr>
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" value="{{$product->name}}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Categoria</label>
            <select name="category_id" class="form-control">
                <option value="" disabled selected>Escolha uma Categoria</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}" @if($category->id == $product->category->id) selected @endif>
                        {{$category->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Descrição</label>
            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{$product->description}}</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Imagens</label>
            <input type="file" accept="image/*" name="images[]" class="form-control-file @error('images.*') is-invalid @enderror" multiple>
            @error('images.*')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="row">
            @foreach ($product->images as $img)
                <div class="col-md-2">
                    <img src="{{asset('storage/'.$img->path)}}" class="img-fluid img-thumbnail" id="img-{{$img->id}}">
                    <button type="button" class="btn btn-danger btn-sm btn-block" onclick="removeImage({{$img->id}})">Remover</button>
                </div>
            @endforeach
        </div>
        <div class="text-right">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#criar">Criar variação</button>
        </div>
        <div class="text-center">
            <small>Atualizações de variações são feitas automaticamente</small>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->variations as $var)
                        <tr id="var-{{$var->id}}">
                            <td>{{$var->name}}</td>
                            <td>R$ {{number_format($var->price, 2, ',', '.')}}</td>
                            <td>{{number_format($var->stock, 1, ',', '.')}}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="destroyVariation({{$var->id}})">Excluir</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
    <div class="modal fade" id="criar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Criar variação</h1>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Preço</label>
                        <input type="text" name="price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Estoque</label>
                        <input type="text" name="stock" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="processModal()" class="btn btn-primary">Criar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">

        function removeImage(id) {
            $.post('/admin/products/image/'+id+'/destroy').done((res)=> {
                console.log(res);
                if (res.success) {
                    $('#img-'+id).parent().remove();
                } else {
                    alert('Falha ao remover imagem. (HTTP 500)');
                }
            }).fail(()=> {
                alert('Falha ao remover imagem.');
            });
        }

        $('input[name=price]').mask('000.000.000.000.000,00', {reverse: true});

        function processModal() {
            let modal = $('.modal');
            let name = modal.find('input[name=name]').val();
            let price = modal.find('input[name=price]').val().replace('.', '').replace(',', '.');
            let stock = modal.find('input[name=stock]').val();
            addVariation({product_id:{{$product->id}},name,price,stock});
            modal.modal('hide');
        }

        function destroyVariation(id) {
            $.post('/admin/variations/'+id+'/destroy').done(function (e) {
                $('#var-'+id).remove();
            }).fail(function (e) {
               console.log(e);
            });
        }
        function addVariation(data) {
            $.post('/admin/variations/add', data).done(function (res) {
                let price = Number(data.price);
                let stock = Number(data.stock).toLocaleString('pt-BR', {minimumFractionDigits:1});
                let row = '<tr id="var-'+res.id+'">'+
                '<td>'+data.name+'</td>'+
                '<td>'+price.toLocaleString('pt-BR', {style:'currency',currency:'BRL'})+'</td>'+
                '<td>'+stock+'</td>'+
                '<td><button type="button" class="btn btn-danger btn-sm" onclick="destroyVariation('+res.id+')">Excluir</button></td></tr>';
                $('tbody').append(row);
            }).fail(function (e) {
                alert(e);
            });
        }
    </script>
@endsection
