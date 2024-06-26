<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Storage;
use Auth;

class ItemController extends Controller
{
    public function showAll()
    {
        $categories = Category::all();
        $user = Auth::user();

        return view('items', compact('categories', 'user'));
    }

    public function show($id) {
        $category = Category::find($id);

        if ($category === null) {
            return view('category');
        }
        else {
            $user = Auth::user();
            if ($user && $user->is_admin) {
                $items = $category->items()->withTrashed()->get();
            }
            else {
                $items = $category->items;
            }
            return view('category', compact('category', 'items', 'user'));
        }
    }
}
