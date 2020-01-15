@extends('layouts.home')

@section('content')
    <div class="row mb-4">
    @foreach ($categories as $index => $category)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h1 class="card-title text-center">{{$category->name}}</h1>
                </div>
                <div class="card-footer text-center">
                    @if ($category->products->count() == 1)
                        <a class="btn btn-primary btn-sm" href="{{route('single', ['id'=>$category->products->first()->id])}}">
                            Ver produto
                        </a>
                    @else
                        <a class="btn btn-primary btn-sm" href="{{route('products', ['category'=>$category->id])}}">
                            Ver produtos
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @if (($index+1) % 3 == 0) </div><div class="row mb-4"> @endif
    @endforeach
    </div>
    <div>
        {{$categories->links()}}
    </div>
@endsection
