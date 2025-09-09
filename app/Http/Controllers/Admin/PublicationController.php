<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publication;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::latest()->paginate(10);
        return view('admin.publications.index', compact('publications'));
    }

    public function create()
    {
        return view('admin.publications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        $publication = Publication::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => '',
        ]);

        if ($request->hasFile('file')) {
            $publication->addMediaFromRequest('file')
                ->toMediaCollection('publications');
            
            $publication->update([
                'file_path' => $publication->getFirstMediaUrl('publications')
            ]);
        }

        return redirect()->route('admin.publications.index')
            ->with('success', 'Publication créée avec succès.');
    }

    public function destroy(Publication $publication)
    {
        $publication->clearMediaCollection('publications');
        $publication->delete();

        return redirect()->route('admin.publications.index')
            ->with('success', 'Publication supprimée avec succès.');
    }
}
