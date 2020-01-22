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
                <div class="col-6 col-md-3 col-lg-2">
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
                    <tr v-for="v in variations" id="var-@{{v.id}}">
                        <td>@{{v.name}}</td>
                        <td>R$ @{{Number(v.price).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}}</td>
                        <td>@{{parseInt(v.stock)}}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" @click="setCurrentlyEdit(v.id)">Editar</button>
                            <button type="button" class="btn btn-danger btn-sm" @click="destroyVariation(v.id)">Excluir</button>
                        </td>
                    </tr>
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
    <div class="modal fade" id="editar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Editar variação</h1>
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
                    <button onclick="processModal(true)" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
    <script type="text/javascript">

        const vue = new Vue({
            el: 'tbody',
            data: {
                variations: {!! json_encode($product->variations) !!}
            },
            methods: {
                destroyVariation,
                setCurrentlyEdit
            }
        });

        let currentlyEdit = 0;

        function setCurrentlyEdit(id) {
            currentlyEdit = id;
            let v = vue.variations.find((v) => v.id==id);
            let modal = $('#editar');
            modal.find('input[name=name]').val(v.name);
            modal.find('input[name=price]').val(Number(v.price).toLocaleString('pt-BR', {maximumFractionDigits: 2, minimumFractionDigits: 2}));
            modal.find('input[name=stock]').val(parseInt(v.stock));
            modal.modal('show');
        }

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

        function processModal(edit=false) {
            let modal = edit ? $('#editar') : $('#criar');
            let id = currentlyEdit;
            let name = modal.find('input[name=name]').val();
            let price = modal.find('input[name=price]').val().replace('.', '').replace(',', '.');
            let stock = modal.find('input[name=stock]').val().replace('.', '').replace(',', '.');

            if (edit) alterVariation({id,name,price,stock});
            else addVariation({product_id:{{$product->id}},name,price,stock});

            modal.modal('hide');
        }

        function destroyVariation(id) {
            $.post('/admin/variations/'+id+'/destroy').done(function (e) {
                vue.variations = vue.variations.filter((v) => v.id != id);
            }).fail(function (e) {
               console.log(e);
            });
        }
        function addVariation(data) {
            $.post('/admin/variations/add', data).done(function (res) {
                vue.variations.push({id:res.id, name:data.name, price:data.price, stock:data.stock});
            }).fail(function (e) {
                alert(e);
            });
        }

        function alterVariation({id, name, price, stock}) {
            $.ajax({
                url: '/admin/variations/'+id,
                type: 'PUT',
                data: {name,price,stock},
                success: (res) => {
                    if (res.success) {
                        vue.variations = vue.variations.map((v) => {
                            if (v.id == id) return {id,name,price,stock};
                            return v;
                        });
                    }
                }
            });
        }
    </script>
@endsection
