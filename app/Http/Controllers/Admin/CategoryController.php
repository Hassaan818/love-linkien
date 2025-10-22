<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryAddRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $categoryView = 'admin.categories.';
    public function index()
    {
        $categories = Category::get();
        return view($this->categoryView . 'index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->categoryView . 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryAddRequest $request)
    {
        $data = $request->validated();

        $category = new Category();
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']);
        $category->description = $validatedData['description'] ?? null;

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
            $imageFile->move('images/categories', $imageName);
            $category->image = 'images/categories/' . $imageName;
        }

        $category->save();
        return redirect()->route('admin.categories.index')->with('message', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::where('id', $id)->first();
        return view($this->categoryView . 'show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::where('id', $id)->first();
        return view($this->categoryView . 'edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = Category::where('id', $id)->first();
        $validatedData = $request->validated();

        $category->name = $validatedData['name'];
        $category->slug = $validatedData['slug'];
        $category->description = $validatedData['description'] ?? null;

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
            $imageFile->move('images/categories', $imageName);
            $category->image = 'images/categories/' . $imageName;
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('message', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::where('id', $id)->first();
        $category->delete();

        return redirect()->route('admin.categories.index')->with('message', 'Category and relations deleted');
    }
}
