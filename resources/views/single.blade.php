@extends('layouts.home')

@section('content')
    <div class="row">
        <div class="col-lg-4 offset-lg-1">
            <div class="h-100">
                @if ($product->images->count())
                    <img src="{{asset('storage/'.$product->images[0]->path)}}" class="img-fluid" alt="">
                @else
                    <img src="{{asset('assets/img/no-photo.jpg')}}" class="img-fluid" alt="">
                @endif
            </div>
        </div>
        <div class="col-lg-6">
            <div><h1>{{$product->name}}</h1></div>
            <form action="{{route('cart.add')}}" method="post">
                @csrf
                <input type="hidden" name="callback" value="{{request()->fullUrl()}}">
                <div class="form-group">
                    <label>Variação</label>
                    <div class="input-group">
                        <select name="id" class="form-control" required>
                            <option value="" selected disabled>Escolha uma variação</option>
                            @foreach($product->variations as $var)
                                @if ($var->stock == 0)
                                    <option disabled>{{$var->name}}   (SEM ESTOQUE)</option>
                                @else
                                    <option data-stock="{{$var->stock}}" data-price="{{$var->price}}" value="{{$var->id}}">{{$var->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <input type="number" name="amount" min="1" max="{{$var->stock}}" value="1" class="form-control">
                        </div>
                    </div>
                    <input type="text" class="form-control" value="" disabled>
                </div>
                <button class="btn btn-success btn-block">Adicionar ao carrinho</button>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            {!!$product->description!!}
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('input[name=amount],select[name=id]').change(function (e) {
            let field = $(this);
            while (!field.hasClass('form-group')) field=field.parent();

            let price = (option = field.find('select option:selected')).data('price');
            let amount = field.find('input[name=amount]').val();
            render(price, amount, field = field.find('input:disabled'))
            field.attr('max', option.data('stock'));
        });

        function render(price, amount, field) {
            let number = Number(price*amount).toLocaleString('pt-BR', {minimumFractionDigits:2, maximumFractionDigits: 2});
            field.val('R$ '+number);
        }
    </script>
@endsection
