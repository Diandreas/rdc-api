<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialLink;

class SocialLinkController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::all();
        return view('admin.social-links.index', compact('socialLinks'));
    }

    public function create()
    {
        return view('admin.social-links.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'act_type' => 'required|in:decret,arrete,ordonnance,decision,circulaire,autre',
            'act_number' => 'nullable|string|max:255',
            'signature_date' => 'required|date',
            'signature_location' => 'required|string|max:255',
            'document_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active', true);

        SocialLink::create($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Acte du chef de l\'état ajouté avec succès.');
    }

    public function show(SocialLink $socialLink)
    {
        return view('admin.social-links.show', compact('socialLink'));
    }

    public function edit(SocialLink $socialLink)
    {
        return view('admin.social-links.edit', compact('socialLink'));
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'act_type' => 'required|in:decret,arrete,ordonnance,decision,circulaire,autre',
            'act_number' => 'nullable|string|max:255',
            'signature_date' => 'required|date',
            'signature_location' => 'required|string|max:255',
            'document_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active', true);

        $socialLink->update($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Acte du chef de l\'état mis à jour avec succès.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Acte du chef de l\'état supprimé avec succès.');
    }
}
