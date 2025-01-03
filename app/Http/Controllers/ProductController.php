<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::join('category', 'product.id_category', '=', 'category.id')
            ->select('product.*', 'category.name as category_name')
            ->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_category' => 'required|exists:category,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'name.required' => 'Product name is required',
            'description.required' => 'Product description is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price cannot be negative',
            'stock.required' => 'Stock is required',
            'stock.integer' => 'Stock must be a whole number',
            'stock.min' => 'Stock cannot be negative',
            'id_category.required' => 'Category is required',
            'id_category.exists' => 'Selected category is invalid',
            'image.required' => 'Product image is required',
            'image.image' => 'File must be an image',
            'image.mimes' => 'Image must be jpeg, png, or jpg format',
            'image.max' => 'Image size cannot exceed 2MB'
        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);
                $validated['image_url'] = 'images/products/' . $imageName;
            }

            Product::create($validated);

            return redirect()->route('admin.products')
                ->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to add product. Please try again.');
        }
    }
}
