<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;

class MainController extends Controller
{
    public function index() {
        $user_count = User::count();
        $category_count = Category::count();
        $item_count = Item::count();

        return view('main', compact('user_count', 'category_count', 'item_count'));
    }
}
