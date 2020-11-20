<?php

namespace App\Http\Controllers;

use Auth;

class OrderController extends Controller
{
    public function show() {

        $user = Auth::user();
        $orders = $user->orders->filter(function($order) {
            return $order->status === 'RECEIVED' || $order->status === 'REJECTED' || $order->status === 'ACCEPTED';
        });

        return view('orders', compact('orders'));
    }
}