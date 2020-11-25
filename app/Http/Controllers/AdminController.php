<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Requests\ItemFormRequest;
use App\Models\Order;

use Storage;
use Auth;

class AdminController extends Controller
{

    //CATEGORIES
    public function newCategory() {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $items = Item::all();

            return view('category-form', compact('items'));
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function editCategory($id) {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $items = Item::all();
            $category = Category::find($id);

            if ($category === null) {
                return view('category-form', compact('items'));
            }
            else {
                $categoryItems = json_decode($category->items);
                return view('category-form', compact('category', 'items', 'categoryItems'));
            }
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function storeCategory(CategoryFormRequest $request) {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $data = $request->all();

            $category = Category::create($data);
            $category->items()->attach($data['items']);

            return redirect()->route('menu')->with('category_added', true);
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function updateCategory($id, CategoryFormRequest $request) {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $data = $request->all();

            $category = Category::find($id);

            $category->name = $data['name'];
            $category->items()->detach();

            $category->items()->attach($data['items']);

            $category->save();

            return redirect()->route('menu')->with('category_updated', true);
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function deleteCategory($id) {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $category = Category::find($id);
            $category->delete();

            return redirect()->route('menu')->with('category_deleted', true);
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }


    //ITEMS
    public function newItem() {
        $user = Auth::user();

        if ($user && $user->is_admin) {

            $categories = Item::all();

            return view('item-form', compact('categories'));
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function editItem($id) {
        $user = Auth::user();

        if ($user && $user->is_admin) {

            $categories = Category::all();
            $item = Item::find($id);

            if ($item === null) {
                return view('item-form', compact('categories'));
            }
            else {
                $itemCategories = json_decode($item->categories);
                return view('item-form', compact('item', 'categories', 'itemCategories'));
            }
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function storeItem(ItemFormRequest $request) {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $hashName = $file->hashName();
                Storage::disk('public')->put('images/'.$hashName, file_get_contents($file));
                $data['image_url'] = $hashName;
            }

            $item = Item::create($data);
            
            foreach ($data['categories'] as $categoryId) {
                $category = Category::find($categoryId);
                $category->items()->attach($item->id);
            }

            return redirect()->route('menu')->with('item_added', true);
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function updateItem($id, ItemFormRequest $request) {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $data = $request->all();

            $item = Item::find($id);

            $item->name = $data['name'];
            $item->description = $data['description'];
            $item->price = $data['price'];

            $categories = Category::all();
            foreach ($categories as $category) {
                $category->items()->detach($item->id);
            }

            foreach ($data['categories'] as $categoryId) {
                $category = Category::find($categoryId);
                $category->items()->attach($item->id);
            }

            $item->save();

            return redirect()->route('menu')->with('item_updated', true);
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function deleteItem($id) {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $item = Item::find($id);
            $item->delete();

            return redirect()->route('menu')->with('item_deleted', true);
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function restoreItem($id) {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $item = Item::withTrashed()->find($id);
            $item->restore();

            return redirect()->route('menu')->with('item_restored', true);
        }
        else {
            return redirect()->route('menu')->with('unauthorized', true);
        }
    }

    public function receivedOrders() {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $orders = Order::all()->where('status', 'RECEIVED');
            return view('received-orders', compact('orders'));
        }
        else {
            return redirect()->route('main')->with('unauthorized', true);
        }
    }

    public function processedOrders() {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $orders = Order::all()->filter(function($order) {
                return $order->status === 'REJECTED' || $order->status === 'ACCEPTED';
            });
            return view('processed-orders', compact('orders'));
        }
        else {
            return redirect()->route('main')->with('unauthorized', true);
        }
    }

    public function showOrder($id) {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            $order = Order::find($id);

            if ($order) {
                return view('order', compact('order'));
            }
            else {
                return view('order');
            }
        }
        else {
            return redirect()->route('main')->with('unauthorized', true);
        }
    }

    public function acceptOrder($id) {
        $order = Order::find($id);
        $user = Auth::user();

        if ($user && $user->is_admin && $order) {

            $order->status = 'ACCEPTED';
            $order->processed_on = date('Y-m-d');

            $order->save();

            return view('order', compact('order'));
        }
        else {
            return redirect()->route('main')->with('unauthorized', true);
        }
    }

    public function rejectOrder($id) {
        $order = Order::find($id);
        $user = Auth::user();

        if ($user && $user->is_admin && $order) {

            $order->status = 'REJECTED';
            $order->processed_on = date('Y-m-d');

            $order->save();

            return view('order', compact('order'));
        }
        else {
            return redirect()->route('main')->with('unauthorized', true);
        }
    }
}
