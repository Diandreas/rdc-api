<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->paginate(12);
        return view('admin.photos.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.photos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image_url' => 'required|url',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = \Str::slug($validated['title']);
        $validated['photo_date'] = $validated['event_date'] ?? now()->toDateString();
        $validated['is_published'] = true;
        $validated['published_at'] = now();

        Photo::create($validated);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Photo ajoutée avec succès.');
    }

    public function show(Photo $photo)
    {
        return view('admin.photos.show', compact('photo'));
    }

    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image_url' => 'required|url',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = \Str::slug($validated['title']);
        $validated['photo_date'] = $validated['event_date'] ?? $photo->photo_date;

        $photo->update($validated);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Photo mise à jour avec succès.');
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();

        return redirect()->route('admin.photos.index')
            ->with('success', 'Photo supprimée avec succès.');
    }
}
