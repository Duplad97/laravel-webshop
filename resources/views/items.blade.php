@extends('layouts.app')

@section('title', 'Menü')

@section('content')
    <div class="container">

        @if (session()->has('category_added'))
            @if (session()->get('category_added') == true)
                <div class="alert alert-success mb-3" role="alert">
                    Kategória sikeresen hozzáadva!
                </div>
            @endif
        @endif


    @if($user && $user->is_admin)
        <div class="text-center my-3">
            <a href="{{ route('new.category') }}" role="button" class="btn btn-primary @guest disabled @endguest" >Új kategória</a>
        </div>

        <div class="text-center my-3">
            <a href="" role="button" class="btn btn-primary @guest disabled @endguest" >Új termék</a>
        </div>

        <hr>
    @endif

        <h3>Kategóriák</h3>

        <div class="row">
            @foreach ($categories as $category)
            <div class="col">
                <span class="badge badge-dark m-2"><a style="color: white !important; font-size: 14px !important;" href="{{ route('category', ['id' => $category->id]) }}">{{ $category->name }}</a></span>
                @if($user && $user->is_admin)
                <form action="{{ route('delete.category', ['id' => $category->id]) }}" method="POST">
                @method('DELETE')
                @csrf
                    <button type="submit" class="btn btn-link">Törlés</button>
                </form>
                @endif
            </div>
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
                            <div class="card-body text-center">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            @if ($item->image_url === null || $item->image_url === '' || $item->image_url === '0')
                                <img class="w-75 mb-3 img-thumbnail" src="{{ Storage::url('images/placeholder.png') }}">
                            @else
                                <img class="w-75 mb-2 img-thumbnail" src="{{ Storage::url('images/' . $item->image_url) }}">
                            @endif
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
