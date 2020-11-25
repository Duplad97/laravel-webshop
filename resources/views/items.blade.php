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

        @if (session()->has('category_updated'))
            @if (session()->get('category_updated') == true)
                <div class="alert alert-success mb-3" role="alert">
                    Kategória frissítve!
                </div>
            @endif
        @endif

        @if (session()->has('category_deleted'))
            @if (session()->get('category_deleted') == true)
                <div class="alert alert-success mb-3" role="alert">
                    Kategória törölve!
                </div>
            @endif
        @endif

        @if (session()->has('item_added'))
            @if (session()->get('item_added') == true)
                <div class="alert alert-success mb-3" role="alert">
                    Termék sikeresen hozzáadva!
                </div>
            @endif
        @endif

        @if (session()->has('item_updated'))
            @if (session()->get('item_updated') == true)
                <div class="alert alert-success mb-3" role="alert">
                    Termék frissítve!
                </div>
            @endif
        @endif

        @if (session()->has('item_deleted'))
            @if (session()->get('item_deleted') == true)
                <div class="alert alert-success mb-3" role="alert">
                    Termék törölve!
                </div>
            @endif
        @endif

        @if (session()->has('item_restored'))
            @if (session()->get('item_restored') == true)
                <div class="alert alert-success mb-3" role="alert">
                    Termék visszaállítva!
                </div>
            @endif
        @endif

        @if (session()->has('unauthorized'))
            @if (session()->get('unauthorized') == true)
                <div class="alert alert-danger mb-3" role="alert">
                    Hozzáférés megtagadva!
                </div>
            @endif
        @endif

    @if(isset($user) && $user->is_admin)
        <div class="text-center my-3">
            <a href="{{ route('new.category') }}" role="button" class="btn btn-primary @guest disabled @endguest" >Új kategória</a>
        </div>

        <div class="text-center my-3">
            <a href="{{ route('new.item') }}" role="button" class="btn btn-primary @guest disabled @endguest" >Új termék</a>
        </div>

        <hr>
    @endif

        <h3>Kategóriák</h3>

        <div class="row d-flex justify-content-around">
            @foreach ($categories as $category)
            <div class="card">
                <span class="badge badge-dark m-2"><a style="color: white !important; font-size: 14px !important;" href="{{ route('category', ['id' => $category->id]) }}">{{ $category->name }}</a></span>
                @if(isset($user) && $user->is_admin)
                <div class="card-body">
                <a class="mt-2" href="{{ route('edit.category', ['id' => $category->id]) }}" >Szerkesztés</a>
                <form action="{{ route('delete.category', ['id' => $category->id]) }}" method="POST">
                @method('DELETE')
                @csrf
                    <button type="submit" class="btn btn-link">Törlés</button>
                </form>
                </div>
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
            @php($categoryItems = (isset($user) && $user->is_admin) ? $category->items()->withTrashed()->get() : $category->items
            )
                @forelse ($categoryItems as $item)
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
                <div class="my-3">
                    <p class="text-center">Még nincsenek termékek ebben a kategóriában</p>
                </div>
                @endforelse
            @endforeach
            </div>
        </div>

    </div>

@endsection
