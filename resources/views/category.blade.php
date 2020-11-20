@extends('layouts.app')

@section('title', 'Menü')

@section('content')
    <div class="container">
        @if (!isset($category))
            <div class="alert alert-danger" role="alert">
                Ez a kategória nem létezik
            </div>
        @else
            <h1 class="text-center text-uppercase">{{ $category->name }}</h1>
            <div class="row">
                @forelse ($items as $item)
                <div class="col-12 col-lg-4 mb-2">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Ár: {{ $item->price }} €</h6>
                            <form action="{{ route('add.to.cart', ['itemId' => $item->id]) }}" method="POST" class="text-center">
                            @csrf

                            @error('quantity')
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                </div>
                            @enderror
                                <fieldset @guest disabled @endguest>
                                    <label for="quantity">Mennyiség</label>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" min="1" max="10"  value="1" width="10"
                                            name='quantity'>
                                        </div>
                                    </div>

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
            </div>
        @endif
    </div>

@endsection
