@extends('layouts.app')

@section('title', 'Menü')

@section('content')
    <div class="container">
        <h3>Kategóriák</h3>

        <div class="row">
            @foreach ($categories as $category)
                <span class="badge badge-dark m-2"><a style="color: white !important;" href="{{ route('category', ['id' => $category->id]) }}">{{ $category->name }}</a></span>
            @endforeach
        </div>

        <hr>

        <h3>Termékek</h3>

        <div class="row">
            @foreach ($categories as $category)
            <div class="row mt-2 w-100">
            <h4 class="w-100 text-center font-weight-bold text-uppercase">{{ $category->name }}</h4>
            <br>
                @forelse ($category->items as $item)
                    <div class="col-12 col-lg-4 mb-2">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Ár: {{ $item->price }} €</h6>
                            <form action="{{ route('add.to.cart', ['itemId' => $item->id]) }}" method="POST" class="text-center">
                            @csrf
                                <fieldset @guest disabled @endguest>
                                    <label for="quantity">Mennyiség</label>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="1" max="10"  value="1" width="10"
                                            name='quantity'>
                                        </div>
                                    </div>

                                    @error('quantity')
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                </div>
                            @enderror

                                    <div class="text-center my-3">
                                        <button type="submit" class="btn btn-primary">Kosárba</button>
                                    </div>
                                <fieldset>
                            </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Még nincsenek termékek ebben a kategóriában</p>
                @endforelse
            @endforeach
            </div>
        </div>

    </div>

@endsection
