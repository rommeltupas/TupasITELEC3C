<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.category', compact('categories'));
    
    }

    public function AddCategory(Request $request){


        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->user_id = Auth::id();

        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            // Save the image path in the database
            $category->image_path = $imageName;
        }

        $category->save();

        return redirect()->route('AllCat');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $validatedData['category_name'],
        ]);

        return redirect()->route('AllCat')->with('success', 'Category updated successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('AllCat')->with('success', 'Category deleted successfully.');
    }
}