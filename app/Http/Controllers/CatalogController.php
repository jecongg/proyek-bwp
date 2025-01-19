<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CatalogController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function catalog(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $category = Category::where('name', $request->category)->first();
            if ($category) {
                $query->where('id_category', $category->id);
            }
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();
        $categories = Category::all();

        return view('catalog', compact('products', 'categories'));
    }

    public function about()
    {
        return view('about');
    }
}
