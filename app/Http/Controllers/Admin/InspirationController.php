<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InpirationAddRequest;
use App\Http\Requests\Admin\InspirationUpdateRequest;
use App\Models\Category;
use App\Models\Inspiration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InspirationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $inspirationView = 'admin.inspirations.';
    public function index()
    {
        $inspirations = Inspiration::get();
        return view($this->inspirationView . 'index', [
            'inspirations' => $inspirations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->inspirationView . 'create', [
            'categories' => Category::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InpirationAddRequest $request)
    {
        $data = $request->validated();

        $inspiration = new Inspiration();

        $inspiration->name = $data['name'];
        $inspiration->category_id = $data['category_id'];
        $inspiration->slug = Str::slug($data['name']);
        $inspiration->tags = json_encode($data['tags']);
        $inspiration->short_description = $data['short_description'];
        $inspiration->notes = $data['notes'];

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
            $imageFile->move('images/inspirations', $imageName);
            $inspiration->image = 'images/inspirations/' . $imageName;
        }

        $inspiration->save();

        return redirect()->route('admin.inspirations.index')
            ->with('success', 'Inspiration added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inspiration = Inspiration::with('category')->findOrFail($id);
        return view($this->inspirationView . 'show', compact('inspiration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inspiration = Inspiration::findOrFail($id);
        $categories = Category::all();

        return view($this->inspirationView . 'edit', compact('inspiration', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InspirationUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $inspiration = Inspiration::findOrFail($id);

        $inspiration->name = $data['name'];
        $inspiration->category_id = $data['category_id'];
        $inspiration->slug = $data['slug'];
        $inspiration->short_description = $data['short_description'];
        $inspiration->notes = $data['notes'] ?? null;
        $inspiration->tags = isset($data['tags']) ? json_encode($data['tags']) : null;

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
            $imageFile->move('images/inspirations', $imageName);
            $inspiration->image = 'images/inspirations/' . $imageName;
        }

        $inspiration->save();

        return redirect()->route('admin.inspirations.index')
            ->with('success', 'Inspiration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inspiration = Inspiration::findOrFail($id);

        $inspiration->delete();

        return redirect()->route('admin.inspirations.index')
            ->with('success', 'Inspiration deleted successfully.');
    }
}
