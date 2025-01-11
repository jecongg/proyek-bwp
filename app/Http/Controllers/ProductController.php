<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function indexAdmin()
    {
        $products = Product::join('category', 'product.id_category', '=', 'category.id')
            ->select('product.*', 'category.name as category_name')
            ->get();
        return view('admin.products.index', compact('products'));
    }

    // Admin: Menambahkan produk
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Admin: Menyimpan produk
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'url_image' => 'required|url|max:255',
            'id_category' => 'required|exists:categories,id'
        ], [
            'name.required' => 'Product name is required',
            'description.required' => 'Product description is required',
            'stock.required' => 'Stock is required',
            'stock.integer' => 'Stock must be a whole number',
            'stock.min' => 'Stock cannot be negative',
            'url_image.required' => 'Image URL is required',
            'url_image.url' => 'Please enter a valid URL',
            'id_category.required' => 'Category is required',
            'id_category.exists' => 'Selected category is invalid'
        ]);

        try {
            Product::create($validated);

            return redirect()->route('admin.products')
                ->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to add product. Please try again.');
        }
    }

    // Customer: Menampilkan semua produk untuk customer
    public function indexCustomer()
    {
        $products = Product::join('category', 'product.id_category', '=', 'category.id')
            ->select('product.*', 'category.name as category_name')
            ->get();
        return view('customer.products.index', compact('products'));
    }

    // Customer: Menampilkan detail produk untuk customer
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $category = Category::findOrFail($product->id_category);
        return view('customer.products.show', compact('product', 'category'));
    }
}
