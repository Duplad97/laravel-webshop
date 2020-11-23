@extends('layouts.app')

@section('title', 'Rendelések')

@section('content')
    <div class="container">
            <h1 class="text-center">Rendelések</h1>
            <div class="row">
            @forelse ($orders as $order)
                    <div class="col-12 col-lg-4 mb-2">
                        <div class="card">
                            <div class="card-body">

                            <h5 class="card-title">Státusz: @if ($order->status === 'RECEIVED') {{ __('Beérkezett') }}
                            @elseif ($order->status === 'REJECTED')
                            {{ __('Elutasítva') }}
                            @else
                            {{ __('Elfogadva') }}
                            @endif</h5>

                            <h6 class="card-subtitle mb-2">Cím: {{ $order->address }}</h6>

                            <h6 class="card-subtitle mb-2">Fizetési mód: @if ($order->payment_method === 'CASH') {{ __('Készpénz') }}
                            @else
                            {{ __('Kártya') }}
                            @endif</h6>

                            @if ($order->comment)
                                <h6 class="card-subtitle mb-2">Megjegyzés:</h6>
                                <p class="card-text">{{ $order->comment }}</p>
                            @endif

                            <h6 class="card-subtitle mt-5">Rendelt termékek:</h6>

                            @php($fullPrice = 0)
                            @foreach ($order->orderedItems as $orderedItem)
                                @php($item = $orderedItem->item)
                                @php($item['quantity'] = $orderedItem['quantity'])
                                @php($fullPrice += $item['quantity']*$item['price'])
                                <p class="card-text mt-0 mb-0" @if ($item->trashed()) style="color: red !important; text-decoration: line-through !important;" @endif>{{ $item->name }} {{ $item->quantity }} db</p>
                            @endforeach

                            <h6 class="card-subtitle mt-5">Összeg: {{ $fullPrice }} €</h6>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Még nincsenek rendelések</p>
                @endforelse
            </div>
    </div>

@endsection
