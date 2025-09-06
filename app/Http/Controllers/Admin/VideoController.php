<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'thumbnail_url' => 'nullable|url',
            'duration' => 'nullable|string',
            'recorded_date' => 'required|date',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        
        // Generate unique slug from title
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        
        while (Video::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $validated['slug'] = $slug;

        Video::create($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo ajoutée avec succès.');
    }

    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'thumbnail_url' => 'nullable|url',
            'duration' => 'nullable|string',
            'recorded_date' => 'required|date',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        
        // Generate unique slug from title if title has changed
        if ($video->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            
            while (Video::where('slug', $slug)->where('id', '!=', $video->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $validated['slug'] = $slug;
        }

        $video->update($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo mise à jour avec succès.');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo supprimée avec succès.');
    }
}
