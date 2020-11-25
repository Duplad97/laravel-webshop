@extends('layouts.app')

@section('title', 'Beérkezett rendelések')

@section('content')
    <div class="container">
            <h1 class="text-center">Beérkezett rendelések</h1>
            <div class="row">
            @forelse ($orders as $order)
                    <div class="col-12 col-lg-4 mb-2">
                        <a href="{{ route('show.order', ['id' => $order->id]) }}" style="text-decoration: none !important;" class="card">
                            <div class="card-body">
                            <h5 class="card-title mb-2">Rendelő: {{ $order->user->name }}</h5>
                            <h6 class="card-subtitle mb-2">Rendelés dátuma: {{ $order->received_on }}</h6>

                            @php($fullPrice = 0)
                            @foreach ($order->orderedItems as $orderedItem)
                                @php($item = $orderedItem->item)
                                @php($item['quantity'] = $orderedItem['quantity'])
                                @php($fullPrice += $item['quantity']*$item['price'])
                            @endforeach
                            <h6 class="card-subtitle mt-5">Összeg: {{ $fullPrice }} €</h6>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-center">Nincsenek feldolgozandó rendelések</p>
                @endforelse
            </div>
    </div>

@endsection
