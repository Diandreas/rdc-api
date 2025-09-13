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
            'pdf_url' => 'required|url',
        ]);

        $publication = Publication::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $validated['pdf_url'],
        ]);

        return redirect()->route('admin.publications.index')
            ->with('success', 'Publication créée avec succès.');
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();

        return redirect()->route('admin.publications.index')
            ->with('success', 'Publication supprimée avec succès.');
    }
}
