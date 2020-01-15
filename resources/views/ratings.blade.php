@extends('layouts.home')

@section('content')
    <div class="row mb-4">
    @foreach ($ratings as $index => $rating)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h1 class="card-title text-center">{{$rating->name}}</h1>
                    <div class="text-center">
                        @for ($x = 0; $x < max(1, $rating->stars); $x++)
                            <i class="fa fa-star"></i>
                        @endfor
                    </div>
                    <hr>
                    <div class="text-center">
                        <p>{{$rating->review}}</p>
                    </div>
                </div>
            </div>
        </div>
        @if (($index+1) % 3 == 0) </div><div class="row mb-4"> @endif
    @endforeach
    </div>
    <div>
        {{$ratings->links()}}
    </div>
@endsection
