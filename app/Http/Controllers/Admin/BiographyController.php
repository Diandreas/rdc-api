<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biography;

class BiographyController extends Controller
{
    public function index()
    {
        $biographies = Biography::orderBy('order')->get();
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
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

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
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

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
