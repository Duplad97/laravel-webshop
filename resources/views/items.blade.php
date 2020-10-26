@extends('layouts.app')

@section('title', 'Menü')

@section('content')
    <div class="container">
        <h3>Termékek</h1>

        @if (session()->has('post_added'))
            @if (session()->get('post_added') == true)
                <div class="alert alert-success mb-3" role="alert">
                    Sikeresen hozzáadtál egy új terméket!
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
                        <p class="card-text">Kattints részletekért.</p>
                        </div>
                    </div>
                </div>
            @empty
                <p>Még nincsenek termékek</p>
            @endforelse
        </div>

    </div>

@endsection
