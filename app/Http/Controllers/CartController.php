<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddToCartFormRequest;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\Item;
use Auth;

class CartController extends Controller
{
    public function show() {

        $user = Auth::user();

        $orders = $user->orders;

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

        $orders = $user->orders;

        $found = false;
        $foundItem = null;

        foreach ($orders as $order) {
            $orderedItems = $order->orderedItems;

            if ($orderedItems->find($itemId)) {
                $found = true;
                $foundItem = $orderedItems->where('item_id' ,$itemId);
            }
        }

        echo $found;
        echo $foundItem;

        if ($found == false) {
            $data['user_id'] = Auth::id();
            $data['address'] = '';
            $data['status'] = 'CART';
            $data['payment_method'] = 'CASH';

            $order = Order::create($data);

            $itemData = $request->all();
            $itemData['order_id'] = $order['id'];
            $itemData['item_id'] = $itemId;

            OrderedItem::create($itemData);
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
}
