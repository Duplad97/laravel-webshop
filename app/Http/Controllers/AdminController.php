<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\CategoryFormRequest;

use Storage;
use Auth;

class AdminController extends Controller
{
    public function newCategory() {

        $items = Item::all();

        return view('category-form', compact('items'));
    }

    public function editCategory($id) {
         $category = Category::find($id);

         if ($category === null) {
            return view('category-form');
        }
        else {
            $items = $category->items;
            return view('category-form', compact('category'));
        }
    }

    public function storeCategory(CategoryFormRequest $request) {
        $data = $request->all();

        $category = Category::create($data);
        $category->items()->attach($data['items']);

        return redirect()->route('menu')->with('category_added', true);
    }

    public function deleteCategory($id) {
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('menu');
    }
}
