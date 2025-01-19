<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;

class ProductController extends Controller
{
    public function indexAdmin()
    {
        $products = Product::All();

        return view('admin.products.index', compact('products'));
    }

    // Admin: Menambahkan produk
    public function create()
    {
        $categories = Category::all();  // Mengambil semua kategori dari tabel 'category'
        return view('admin.products.create', compact('categories')); // Mengirim data kategori ke view
    }

    // Admin: Menyimpan produk
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'url_image' => 'required|url|max:255',
            'id_category' => 'required|exists:category,id',
            'price' => 'required|integer|min:0', // Validasi harga sebagai integer
        ], [
            'name.required' => 'Product name is required',
            'description.required' => 'Product description is required',
            'stock.required' => 'Stock is required',
            'stock.integer' => 'Stock must be a whole number',
            'stock.min' => 'Stock cannot be negative',
            'url_image.required' => 'Image URL is required',
            'url_image.url' => 'Please enter a valid URL',
            'id_category.required' => 'Category is required',
            'id_category.exists' => 'Selected category is invalid',
            'price.required' => 'Price is required',
            'price.integer' => 'Price must be a valid whole number',
            'price.min' => 'Price cannot be negative',
        ]);

        // Cek apakah kategori valid
        $category = Category::find($validated['id_category']);
        if (!$category) {
            return back()->withInput()->with('error', 'Selected category is invalid.');
        }

        try {
            // Menambahkan produk baru dengan data yang sudah tervalidasi
            Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'stock' => $validated['stock'],
                'url_image' => $validated['url_image'],
                'id_category' => $validated['id_category'],
                'price' => $validated['price'],
            ]);

            // Redirect dengan pesan sukses
            return redirect()->route('admin.products')
                ->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            // Tangani error jika terjadi exception
            return back()->withInput()
                ->with('error', 'Failed to add product. Please try again.');
        }
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->id_category = $request->input('category_id');
        $product->url_image = $request->input('url_image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // Soft delete the product

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }


    // Customer: Menampilkan semua produk untuk customer
    public function indexCustomer(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('id_category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();
        $categories = Category::all();

        return view('customer.products.index', compact('products', 'categories'));
    }

    // Customer: Menampilkan detail produk untuk customer
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Check if product is in user's wishlist menggunakan relasi
        $inWishlist = auth()->user()->wishlists()->where('product_id', $id)->exists();

        return view('customer.products.show', compact('product', 'inWishlist'));
    }
}
