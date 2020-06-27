@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">

                <div class="row">
                    @foreach ($products as $product)

                        <div class="card col-md-4 col-sm-6 p-2" style="width: 18rem;">
                            <img class="card-img-top mt-2" style="border-radius: 10px" src={{'images/420_'.$product->productImages[0]->name}} alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->price }}</p>
                                <a href="{{"/products/".$product->id}}" class="btn btn-primary">More info</a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
