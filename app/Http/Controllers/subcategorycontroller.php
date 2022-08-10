<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller {
    function index() {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.subcategory.index', [
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }
    function store(Request $request) {

        if (Subcategory::where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()) {
            return back()->with('exist', 'subcategory already exist in this category');
        } else {

            Subcategory::insert([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
            ]);
            return back();
        }
    }
}
