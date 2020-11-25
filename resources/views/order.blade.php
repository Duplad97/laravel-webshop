@extends('layouts.app')

@section('title', 'Rendelés adatlap')

@section('content')
    <div class="container">
            <h1 class="text-center">Rendelés adatlap</h1>
            @if (isset($order))
                <div class="jumbotron">

                    <h5 class="mb-4">Rendelő neve: {{ $order->user->name }}</h5>
                    <h5 class="mb-4">Rendelő e-mail címe: {{ $order->user->email }}</h5>

                    <h5 class="mb-4">Rendelés dátuma: {{ $order->received_on }}</h5>

                    <h5 class="mb-2">Cím: {{ $order->address }}</h5>

                    <h5 class="mb-2">Fizetési mód: @if ($order->payment_method === 'CASH') {{ __('Készpénz') }}
                    @else
                    {{ __('Kártya') }}
                    @endif</h5>

                    @if ($order->comment)
                        <h5 class="mb-2">Megjegyzés:</h5>
                        <p>{{ $order->comment }}</p>
                    @endif

                    <h5 class="mt-5">Rendelt termékek:</h5>

                    @php($fullPrice = 0)
                    @foreach ($order->orderedItems as $orderedItem)
                        @php($item = $orderedItem->item)
                        @php($item['quantity'] = $orderedItem['quantity'])
                        @php($fullPrice += $item['quantity']*$item['price'])
                        <p class="mt-0 mb-0" @if ($item->trashed()) style="color: red !important; text-decoration: line-through !important;" @endif>{{ $item->name }} {{ $item->quantity }} db</p>
                    @endforeach

                    <h5 class="mt-5">Összeg: {{ $fullPrice }} €</h5>

                    @if ($order->status === "RECEIVED")
                        <div class="d-flex justify-content-center mt-5">
                            <form action="{{ route('accept.order', ['id' => $order->id]) }}" method="POST"enctype="multipart/form-data">
                            @csrf
                                <button type="submit" class="btn btn-success mr-5">Elfogadás</button>
                            </form>
                            <form action="{{ route('reject.order', ['id' => $order->id]) }}" method="POST"enctype="multipart/form-data">
                            @csrf
                                <button type="submit" class="btn btn-danger mr-5">Elutasítás</button>
                            </form>
                        </div>
                    @elseif($order->status === "REJECTED")
                        <div class="d-flex justify-content-center mt-5">
                            <h5 style="font-weight: bold !important; color: red !important;">ELUTASÍTVA<h5>
                        </div>
                    @else
                        <div class="d-flex justify-content-center mt-5">
                            <h5 style="font-weight: bold !important; color: green !important;">ELFOGADVA<h5>
                        </div>
                    @endif

                </div>
                @else
                    <p class="text-center">Nincs ilyen rendelés</p>
                @endif
            </div>
    </div>

@endsection
