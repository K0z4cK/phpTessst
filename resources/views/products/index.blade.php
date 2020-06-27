@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-12">

            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>

        <div class="col-sm-12">

            <h1 class="display-3">Продукти</h1>
            <div>
                <a style="margin: 19px;" href="{{ route('products.create')}}" class="btn btn-primary">Додати продукт</a>
            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Категорія</td>
                    <td>Ціна</td>
                    <td>Кількість</td>
                    <td colspan=2>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <a href="{{ route('products.show', $product->id)}}">
                                <img src="/images/105_{{$product->productImages[0]->name}}" width="150">
                            </a>

                        </td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->category->name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->count}}</td>
                        <td>
                            <a href="{{ route('products.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('products.destroy', $product->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="display: flex; justify-content: center; margin-top: 25px">
                {!! $products->links() !!}
            </div>
            <div>
            </div>
@endsection
