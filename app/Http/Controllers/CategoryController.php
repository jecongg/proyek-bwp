<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::All();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'url_image' => 'required|url|max:255'
        ], [
            'name.required' => 'Category name is required',
            'description.required' => 'Category description is required',
            'url_image.required' => 'Image URL is required',
            'url_image.url' => 'Please enter a valid URL'
        ]);

        try {
            Category::create($validated);

            return redirect()->route('admin.categories')
                ->with('success', 'Category added successfully');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to add category. Please try again.');
        }
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'url_image' => 'required|url|max:255'
        ], [
            'name.required' => 'Category name is required',
            'description.required' => 'Category description is required',
            'url_image.required' => 'Image URL is required',
            'url_image.url' => 'Please enter a valid URL'
        ]);

        try {
            $category->update($validated);

            return redirect()->route('admin.categories')
                ->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update category. Please try again.');
        }
    }
}
