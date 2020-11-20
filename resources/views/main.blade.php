@extends('layouts.app')

@section('title', 'Kezdőlap')

@section('content')
    <div class="container">
    @if (session()->has('order_received'))
        @if (session()->get('order_received') == true)
            <div class="alert alert-success mb-3" role="alert">
                Rendelés sikeresen leadva!
            </div>
        @endif
    @endif

        <div class="jumbotron">
            <h1 class="display-4">Üdv a Webshopban!</h1>
            <hr class="my-4">
            <ul>
                <li>Felhasználók: {{ $user_count }}</li>
                <li>Kategóriák: {{ $category_count }}</li>
                <li>Termékek: {{ $item_count }}</li>
            </ul>
        </div>
    </div>
@endsection
