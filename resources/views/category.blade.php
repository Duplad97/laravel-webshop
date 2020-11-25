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
                            <div class="card-body text-center">

                            @if (isset($user) && $user->is_admin && !$item->trashed())
                                <div class="row d-flex justify-content-center mb-4">
                                    <a href="{{ route('edit.item', ['id' => $item->id]) }}" class="mr-4 mt-2">Szerkesztés</a>
                                    <form action="{{ route('delete.item', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link">Törlés</button>
                                    </form>
                                </div>

                            @elseif (isset($user) && $user->is_admin && $item->trashed())
                                <h4 class="card-title">Törölve</h4>
                                <div class="row d-flex justify-content-center mb-4">
                                <form action="{{ route('restore.item', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link">Visszaállítás</button>
                                    </form>
                                </div>
                            @endif

                            <h5 class="card-title">{{ $item->name }}</h5>

                            @if ($item->image_url === null || $item->image_url === '' || $item->image_url === '0')
                                <img class="w-75 h-75 mb-3 img-thumbnail" src="{{ Storage::url('images/placeholder.png') }}">
                            @else
                                <img class="w-75 h-75 mb-2 img-thumbnail" src="{{ Storage::url('images/' . $item->image_url) }}">
                            @endif

                            <h6 class="card-subtitle mb-2 text-muted">Ár: {{ $item->price }} €</h6>

                            <form action="{{ route('add.to.cart', ['itemId' => $item->id]) }}" method="POST" class="text-center">
                            @csrf
                                <fieldset @guest disabled @endguest @if($item->trashed()) disabled @endif>
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
                                        <button type="submit" class="btn btn-primary"  >Kosárba</button>
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
