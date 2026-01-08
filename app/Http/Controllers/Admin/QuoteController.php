<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Services\FcmService;
use Illuminate\Support\Str;

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
            'author' => 'required|string|max:255',
            'context' => 'nullable|string|max:255',
            'quote_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'featured' => 'nullable',
        ]);

        // Convertir les noms de champs pour correspondre à la base de données
        $data = [
            'content' => $validated['text'],
            'context' => $validated['context'],
            'quote_date' => $validated['quote_date'],
            'location' => $validated['location'],
            'is_featured' => $request->has('featured'),
            'is_published' => true,
            'published_at' => now(),
            'metadata' => [
                'author' => $validated['author'],
                'created_by' => auth()->id(),
                'created_at' => now()->toISOString()
            ]
        ];

        $quote = Quote::create($data);

        app(FcmService::class)->sendToTopic(
            'quotes',
            'Nouvelle citation',
            Str::limit($quote->content ?? $validated['text'], 140),
            ['type' => 'quote', 'id' => $quote->id]
        );

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
            'author' => 'required|string|max:255',
            'context' => 'nullable|string|max:255',
            'quote_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'featured' => 'nullable',
        ]);

        // Convertir les noms de champs pour correspondre à la base de données
        $data = [
            'content' => $validated['text'],
            'context' => $validated['context'],
            'quote_date' => $validated['quote_date'],
            'location' => $validated['location'],
            'is_featured' => $request->has('featured'),
            'metadata' => array_merge($quote->metadata ?? [], [
                'author' => $validated['author'],
                'updated_by' => auth()->id(),
                'updated_at' => now()->toISOString()
            ])
        ];

        $quote->update($data);

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
