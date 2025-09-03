<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::latest()->paginate(10);
        return view('admin.quotes.index', compact('quotes'));
    }

    public function create()
    {
        return view('admin.quotes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:1000',
            'context' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
        ]);

        Quote::create($validated);

        return redirect()->route('admin.quotes.index')
            ->with('success', 'Citation créée avec succès.');
    }

    public function show(Quote $quote)
    {
        return view('admin.quotes.show', compact('quote'));
    }

    public function edit(Quote $quote)
    {
        return view('admin.quotes.edit', compact('quote'));
    }

    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:1000',
            'context' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
        ]);

        $quote->update($validated);

        return redirect()->route('admin.quotes.index')
            ->with('success', 'Citation mise à jour avec succès.');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()->route('admin.quotes.index')
            ->with('success', 'Citation supprimée avec succès.');
    }
}
