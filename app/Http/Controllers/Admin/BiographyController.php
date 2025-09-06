<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biography;
use Illuminate\Support\Str;

class BiographyController extends Controller
{
    public function index()
    {
        $biographies = Biography::orderBy('sort_order')->get();
        return view('admin.biographies.index', compact('biographies'));
    }

    public function create()
    {
        return view('admin.biographies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'section' => 'required|in:early_life,education,career,presidency,achievements,personal',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date',
            'order' => 'required|integer|min:1',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['sort_order'] = $validated['order'];
        unset($validated['order']);
        
        // Generate unique slug from title
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        
        while (Biography::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $validated['slug'] = $slug;

        Biography::create($validated);

        return redirect()->route('admin.biographies.index')
            ->with('success', 'Section biographique ajoutée avec succès.');
    }

    public function show(Biography $biography)
    {
        return view('admin.biographies.show', compact('biography'));
    }

    public function edit(Biography $biography)
    {
        return view('admin.biographies.edit', compact('biography'));
    }

    public function update(Request $request, Biography $biography)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'section' => 'required|in:early_life,education,career,presidency,achievements,personal',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date',
            'order' => 'required|integer|min:1',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['sort_order'] = $validated['order'];
        unset($validated['order']);
        
        // Generate unique slug from title if title has changed
        if ($biography->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            
            while (Biography::where('slug', $slug)->where('id', '!=', $biography->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $validated['slug'] = $slug;
        }

        $biography->update($validated);

        return redirect()->route('admin.biographies.index')
            ->with('success', 'Section biographique mise à jour avec succès.');
    }

    public function destroy(Biography $biography)
    {
        $biography->delete();

        return redirect()->route('admin.biographies.index')
            ->with('success', 'Section biographique supprimée avec succès.');
    }
}
