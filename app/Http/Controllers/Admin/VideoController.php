<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Services\FileCompressionService;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    protected $compressionService;

    public function __construct(FileCompressionService $compressionService)
    {
        $this->compressionService = $compressionService;
    }

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
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm,mkv|max:102400', // 100MB max
            'thumbnail_url' => 'nullable|url',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'duration' => 'nullable|string',
            'recorded_date' => 'required|date',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        // Ensure either video_url or video_file is provided
        if (!$request->hasFile('video_file') && !$request->filled('video_url')) {
            return redirect()->back()
                ->withErrors(['video' => __('admin.video_source_required')])
                ->withInput();
        }

        $validated['is_featured'] = $request->has('is_featured');
        
        // Handle video file upload with compression
        if ($request->hasFile('video_file')) {
            try {
                $videoFile = $request->file('video_file');
                $compressedPath = $this->compressionService->compressVideo($videoFile, 'videos');
                $videoFileName = basename($compressedPath);
                $validated['video_url'] = route('file.serve', ['type' => 'videos', 'filename' => $videoFileName]);
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['video_file' => 'Erreur lors de la compression de la vidéo: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        // Handle thumbnail file upload with compression
        if ($request->hasFile('thumbnail_file')) {
            try {
                $thumbnailFile = $request->file('thumbnail_file');
                $compressedPath = $this->compressionService->compressSingleImage($thumbnailFile, 'images');
                $thumbnailFileName = basename($compressedPath);
                $validated['thumbnail_url'] = route('file.serve', ['type' => 'images', 'filename' => $thumbnailFileName]);
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['thumbnail_file' => 'Erreur lors de la compression de la miniature: ' . $e->getMessage()])
                    ->withInput();
            }
        }
        
        // Generate unique slug from title
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        
        while (Video::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $validated['slug'] = $slug;
        
        // Convert empty strings to null for nullable fields
        $nullableFields = ['description', 'location', 'duration', 'video_url', 'thumbnail_url'];
        foreach ($nullableFields as $field) {
            if (isset($validated[$field]) && $validated[$field] === '') {
                $validated[$field] = null;
            }
        }

        Video::create($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', __('admin.video_created_successfully'));
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
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm,mkv|max:102400', // 100MB max
            'thumbnail_url' => 'nullable|url',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'duration' => 'nullable|string',
            'recorded_date' => 'required|date',
            'location' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        // Ensure either video_url or video_file is provided (unless keeping existing)
        if (!$request->hasFile('video_file') && !$request->filled('video_url') && !$video->video_url) {
            return redirect()->back()
                ->withErrors(['video' => __('admin.video_source_required')])
                ->withInput();
        }

        $validated['is_featured'] = $request->has('is_featured');
        
        // Handle video file upload with compression
        if ($request->hasFile('video_file')) {
            try {
                $videoFile = $request->file('video_file');
                $compressedPath = $this->compressionService->compressVideo($videoFile, 'videos');
                $videoFileName = basename($compressedPath);
                $validated['video_url'] = route('file.serve', ['type' => 'videos', 'filename' => $videoFileName]);
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['video_file' => 'Erreur lors de la compression de la vidéo: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        // Handle thumbnail file upload with compression
        if ($request->hasFile('thumbnail_file')) {
            try {
                $thumbnailFile = $request->file('thumbnail_file');
                $compressedPath = $this->compressionService->compressSingleImage($thumbnailFile, 'images');
                $thumbnailFileName = basename($compressedPath);
                $validated['thumbnail_url'] = route('file.serve', ['type' => 'images', 'filename' => $thumbnailFileName]);
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['thumbnail_file' => 'Erreur lors de la compression de la miniature: ' . $e->getMessage()])
                    ->withInput();
            }
        }
        
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
        
        // Convert empty strings to null for nullable fields
        $nullableFields = ['description', 'location', 'duration', 'video_url', 'thumbnail_url'];
        foreach ($nullableFields as $field) {
            if (isset($validated[$field]) && $validated[$field] === '') {
                $validated[$field] = null;
            }
        }

        $video->update($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', __('admin.video_updated_successfully'));
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo supprimée avec succès.');
    }
}
