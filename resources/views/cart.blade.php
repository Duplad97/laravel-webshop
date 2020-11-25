@extends('layouts.app')

@section('title', 'Kosár')

@section('content')
    <div class="container">
    @csrf
        <h3>Kosár</h1>

        @if (session()->has('item_added'))
            @if (session()->get('item_added') == true)
                <div class="alert alert-success mb-3" role="alert">
                    Termék hozzáadva a kosárhoz!
                </div>
            @endif
        @endif

        <div class="row">
            @forelse ($items as $item)
                <div class="col-12 col-lg-4 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Ár: {{ $item->price }} €</h6>
                            <p class="card-text">Mennyiség: {{ $item->quantity }} db</p>
                            <p class="card-text">Összesen: {{ $item->quantity*$item->price }} €</p>
                            <div class="text-center">
                                <form action="{{ route('remove.from.cart', ['itemId' => $item->id]) }}" method="POST" class="text-center">
                            @method('DELETE')
                            @csrf
                                    <div class="text-center my-3">
                                        <button type="submit" class="btn btn-primary">Törlés</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Még nincsenek termékek a kosárban.</p>
            @endforelse
        </div>
        <hr/>

        @if (count($items) > 0)
        <h4 class="mt-5 mb-3 text-center">Összesen fizetendő: {{ $fullPrice }} €</h4>

        <div class="d-flex justify-content-center">

        <form class="w-50" action="{{ route('send.order') }}" method="POST" enctype="multipart/form-data">
        @csrf
                <div class="form-group">
                    <label for="address">Szállítási cím</label><label style="color: red !important;">*</label>
                    <input type="text" class="form-control" id="address" name="address">
                </div>
                @error('address')
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('address') }}</strong>
                    </div>
                @enderror

                <div class="form-group">
                    <label for="comment">Megjegyzés</label>
                    <br>
                    <textarea class="form-control z-depth-1" id="comment" name="comment" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <label>Fizetési mód</label><label style="color: red !important;">*</label>
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="cash" name="payment_method" value="CASH" checked>
                        <label class="custom-control-label" for="cash">Készpénz</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="card" name="payment_method" value="CARD">
                        <label class="custom-control-label" for="card">Kártya</label>
                    </div>
                </div>

                @if ($errors->has('payment_method'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('payment_method') }}</strong>
                    </div>
                @endif

                <div class="text-center my-3">
                    <button type="submit" class="btn btn-primary">Rendelés leadása</button>
                </div>
        </form>
        @endif
        </div>

    </div>

@endsection
