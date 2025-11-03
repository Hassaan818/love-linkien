<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venues = Venue::latest()->paginate(10);
        return view('admin.venues.index', compact('venues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.venues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'featured_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'venue_owner' => 'nullable|string|max:255',
            'venue_location' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('featured_image')) {
            $imageFile = $request->file('featured_image');
            $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
            $imageFile->move('images/venues', $imageName);
            $validated['featured_image'] = 'images/venues/' . $imageName;
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $imageFile = $file;
                $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
                $imageFile->move('images/venues', $imageName);
                $galleryPaths[] = 'images/venues/' . $imageName;
            }
            $validated['gallery'] = json_encode($galleryPaths);
        }

        Venue::create($validated);

        return redirect()->route('admin.venues.index')->with('success', 'Venue added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $venue)
    {
        return view('admin.venues.edit', compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venue $venue)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:venues,slug,' . $venue->id,
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'venue_owner' => 'nullable|string|max:255',
            'venue_location' => 'required|string|max:255',
        ]);

        // Update featured image
        if ($request->hasFile('featured_image')) {
            $imageFile = $request->file('featured_image');
            $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
            $imageFile->move('images/venues', $imageName);
            $validated['featured_image'] = 'images/venues/' . $imageName;
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $imageFile = $file;
                $imageName = time() . '_image.' . $imageFile->getClientOriginalExtension();
                $imageFile->move('images/venues', $imageName);
                $galleryPaths[] = 'images/venues/' . $imageName;
            }
            $validated['gallery'] = json_encode($galleryPaths);
        }

        $venue->update($validated);

        return redirect()->route('admin.venues.index')->with('success', 'Venue updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        $venue->delete();

        return redirect()->route('admin.venues.index')->with('success', 'Venue deleted successfully.');
    }
}
