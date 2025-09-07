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
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'event_date' => 'nullable|date',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        // Vérifier qu'au moins une image est fournie
        if (!$request->hasFile('image_file') && !$request->image_url) {
            return back()->withErrors(['image_file' => 'Veuillez fournir soit un fichier image soit une URL d\'image.']);
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = \Str::slug($validated['title']);
        $validated['photo_date'] = $validated['event_date'] ?? now()->toDateString();
        $validated['is_published'] = true;
        $validated['published_at'] = now();

        // Gérer le téléchargement de fichier
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos', $filename, 'public');
            $validated['image_url'] = route('file.serve', ['type' => 'photos', 'filename' => $filename]);
        }

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
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'event_date' => 'nullable|date',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        // Vérifier qu'au moins une image est fournie
        if (!$request->hasFile('image_file') && !$request->image_url && !$photo->image_url) {
            return back()->withErrors(['image_file' => 'Veuillez fournir soit un fichier image soit une URL d\'image.']);
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = \Str::slug($validated['title']);
        $validated['photo_date'] = $validated['event_date'] ?? $photo->photo_date;

        // Gérer le téléchargement de fichier
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos', $filename, 'public');
            $validated['image_url'] = route('file.serve', ['type' => 'photos', 'filename' => $filename]);
        }

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
