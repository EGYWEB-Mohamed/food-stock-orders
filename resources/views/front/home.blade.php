@extends('layouts.main')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ Artesaos\SEOTools\Facades\SEOTools::getTitle(true)}}
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-5 g-4">
                @forelse($products as $product)
                    <div class="col">
                        <div class="card">
                            <h5 class="card-title text-center">{{ $product->name }}</h5>
                            <img src="https://via.placeholder.com/360x360.png" class="img-thumbnail">
                            <div class="card-body">
                                <table class="table table-bordered text-center">
                                    <tr>
                                        <td colspan="2">Ingredients</td>
                                    </tr>
                                    @foreach($product->ingredients as $ingredient)
                                        <tr>
                                            <td>{{ $ingredient->name }}</td>
                                            <td class="text-success">{{ $ingredient->pivot->grams_quantity }} G</td>
                                        </tr>
                                    @endforeach
                                </table>
                                <form action="{{ route('checkout',$product->id) }}" method="post">
                                    @csrf
                                    <button class="btn btn-success btn-block btn-sm w-100">
                                        ( {{ $product->getPrice() }} ) - Order Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>

        </div>
    </div>
@endsection
