<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddToCartFormRequest;
use App\Http\Requests\SendOrderFormRequest;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\Item;
use Auth;

class CartController extends Controller
{
    public function show() {

        $user = Auth::user();

        $orders = $user->orders->where('status', 'CART');

        $items = [];

        $fullPrice = 0;

        foreach ($orders as $order) {
            $orderedItems = $order->orderedItems;
            foreach ($orderedItems as $orderedItem) {
                $item = $orderedItem->item;
                $item['quantity'] = $orderedItem['quantity'];
                array_push($items, $item);
                $fullPrice += $item['quantity']*$item['price'];
            }
        }

        return view('cart', compact('items', 'fullPrice'));
    }

    public function addToCart($itemId, AddToCartFormRequest $request) {

        $user = Auth::user();

        $orders = $user->orders->where('status', 'CART');

        $found = false;
        $foundItem = null;

        foreach ($orders as $order) {
            $orderedItems = $order->orderedItems;

            if (count($orderedItems->where('item_id', $itemId)) !== 0) {
                $found = true;
                $foundItem = $orderedItems->where('item_id' ,$itemId)[0];
            }
        }

        echo $found;
        echo $foundItem;

        if ($found === false) {
            if (count($orders) === 0) {
                $data['user_id'] = Auth::id();
                $data['address'] = '';
                $data['status'] = 'CART';
                $data['payment_method'] = 'CASH';

                $order = Order::create($data);

                $itemData = $request->all();
                $itemData['order_id'] = $order['id'];
                $itemData['item_id'] = $itemId;

                OrderedItem::create($itemData);
            }
            else {
                $orderedItems = $orders->first()->orderedItems;
                $itemData = $request->all();
                $itemData['order_id'] = $orders->first()['id'];
                $itemData['item_id'] = $itemId;

                $orderedItem = OrderedItem::create($itemData);

                $orderedItems->push($orderedItem);

            }

        } else {
            $itemData = $request->all();
            $foundItem->quantity += $itemData['quantity'];
            $foundItem->save();
        }

        return redirect()->route('cart')->with('item_added', true);
    }

    public function removeFromCart($itemId) {

        $user = Auth::user();

        $orders = $user->orders;

        $deleteItem = null;
        $deleted = false;

        foreach ($orders as $order) {
            $orderedItems = $order->orderedItems;
            $deleteItem = $orderedItems->where('item_id' , $itemId);
            
            if ($deleteItem->each->delete() && $deleted == false) {
                $order->delete();
                $deleted = true;
            }

        }

        return redirect()->route('cart');
    }

    public function sendOrder(SendOrderFormRequest $request) {

        $user = Auth::user();

        $userCart = $user->orders->where('status', 'CART');
        $orderData = $request->all();

        if (count($userCart) > 0) {
            foreach ($userCart as $order) {
                $order->address = $orderData['address'];

                if ($orderData['comment']) $order->comment = $orderData['comment'];

                $order->payment_method = $orderData['payment_method'];
                $order->status = 'RECEIVED';

                $order->save();
            }
        }

        return redirect()->route('main')->with('order_received', true);
    }
}
