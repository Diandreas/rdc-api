<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'priority' => 'required|in:low,medium,high,urgent',
            'published_at' => 'nullable|date',
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'location' => 'nullable|string',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = \Str::slug($validated['title']);
        $validated['published_at'] = $validated['published_at'] ?? now();

        $news = News::create($validated);

        if ($request->filled('image_url')) {
            try {
                $news->addMediaFromUrl($request->input('image_url'))->toMediaCollection('featured_images');
            } catch (\Exception $e) {
                // Optionnel: logger l\'erreur si le lien est invalide ou inaccessible
                \Log::error('Impossible de charger l\'image depuis l\'URL : ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité créée avec succès.');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'priority' => 'required|in:low,medium,high,urgent',
            'published_at' => 'nullable|date',
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'location' => 'nullable|string',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = \Str::slug($validated['title']);

        $news->update($validated);

        if ($request->filled('image_url')) {
            try {
                // Supprime l\'ancienne image avant d\'ajouter la nouvelle
                $news->clearMediaCollection('featured_images');
                $news->addMediaFromUrl($request->input('image_url'))->toMediaCollection('featured_images');
            } catch (\Exception $e) {
                \Log::error('Impossible de mettre à jour l\'image depuis l\'URL : ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité mise à jour avec succès.');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité supprimée avec succès.');
    }
}
