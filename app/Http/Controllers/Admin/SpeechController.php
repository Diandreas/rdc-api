<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Speech;
use App\Models\Category;

class SpeechController extends Controller
{
    public function index()
    {
        $speeches = Speech::with('category')->latest()->paginate(10);
        return view('admin.speeches.index', compact('speeches'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.speeches.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'location' => 'required|string|max:255',
            'event_type' => 'required|string|max:255',
            'speech_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'nullable|boolean',
            'audio_url' => 'nullable|url',
            'video_url' => 'nullable|url',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = \Str::slug($validated['title']);

        Speech::create($validated);

        return redirect()->route('admin.speeches.index')
            ->with('success', 'Discours créé avec succès.');
    }

    public function show(Speech $speech)
    {
        return view('admin.speeches.show', compact('speech'));
    }

    public function edit(Speech $speech)
    {
        $categories = Category::all();
        return view('admin.speeches.edit', compact('speech', 'categories'));
    }

    public function update(Request $request, Speech $speech)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'location' => 'required|string|max:255',
            'event_type' => 'required|string|max:255',
            'speech_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'nullable|boolean',
            'audio_url' => 'nullable|url',
            'video_url' => 'nullable|url',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = \Str::slug($validated['title']);

        $speech->update($validated);

        return redirect()->route('admin.speeches.index')
            ->with('success', 'Discours mis à jour avec succès.');
    }

    public function destroy(Speech $speech)
    {
        $speech->delete();

        return redirect()->route('admin.speeches.index')
            ->with('success', 'Discours supprimé avec succès.');
    }
}
