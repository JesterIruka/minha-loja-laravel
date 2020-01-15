@extends('layouts.home')

@section('content')
    <div class="row">
    @foreach ($products as $index => $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if ($product->images->count())
                    <img src="{{asset('storage/'.$product->images[0]->path)}}" class="img-fluid" alt="">
                @else
                    <img src="{{asset('assets/img/no-photo.jpg')}}" class="img-fluid" alt="">
                @endif
                <div class="card-body">
                    <h2 class="card-title text-center">{{$product->name}}</h2>
                </div>
                <div class="card-footer text-center">
                    <a href="{{route('single', ['id'=>$product->id])}}" class="btn btn-info">Ver mais</a>
                </div>
            </div>
        </div>
        @if (($index+1) % 3 == 0) </div><div class="row mb-4"> @endif
    @endforeach
    </div>
    <div>
        {{$products->links()}}
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
