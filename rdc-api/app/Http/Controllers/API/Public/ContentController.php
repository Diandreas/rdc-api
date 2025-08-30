<?php

namespace App\Http\Controllers\API\Public;

use App\Http\Controllers\Controller;
use App\Models\Speech;
use App\Models\Video;
use App\Models\News;
use App\Models\Photo;
use App\Models\Biography;
use App\Models\Quote;
use App\Models\Category;
use App\Models\Tag;
use App\Models\SocialLink;
use App\Http\Resources\SpeechResource;
use App\Http\Resources\VideoResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\BiographyResource;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SocialLinkResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    /**
     * Page d'accueil de l'app
     */
    public function home(): JsonResponse
    {
        $data = [
            'welcome_message' => config('app.welcome_message', 'Bienvenue sur l\'application officielle du Président Faustin Archange Touadéra'),
            'featured_speeches' => SpeechResource::collection(
                Speech::published()->featured()->latest('published_at')->take(3)->get()
            ),
            'latest_news' => NewsResource::collection(
                News::published()->latest('published_at')->take(5)->get()
            ),
            'featured_videos' => VideoResource::collection(
                Video::published()->featured()->latest('published_at')->take(3)->get()
            ),
            'featured_photos' => PhotoResource::collection(
                Photo::published()->featured()->latest('published_at')->take(6)->get()
            ),
            'quote_of_day' => new QuoteResource(
                Quote::published()->featured()->inRandomOrder()->first()
            ),
            'social_links' => SocialLinkResource::collection(
                SocialLink::active()->visible()->ordered()->get()
            )
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Message de bienvenue personnalisé
     */
    public function welcome(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'message' => config('app.welcome_message'),
                'president_name' => 'Faustin Archange Touadéra',
                'app_version' => config('app.version', '1.0.0'),
                'last_updated' => now()->format('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Liste des discours
     */
    public function speeches(Request $request): JsonResponse
    {
        $query = Speech::published()->with(['category', 'tags']);

        // Filtres
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('year')) {
            $query->byYear($request->year);
        }

        if ($request->has('location')) {
            $query->byLocation($request->location);
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        // Tri
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest('speech_date');
                break;
            case 'popular':
                $query->orderByDesc('views_count');
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        $speeches = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => SpeechResource::collection($speeches),
            'meta' => [
                'total' => $speeches->total(),
                'per_page' => $speeches->perPage(),
                'current_page' => $speeches->currentPage(),
                'last_page' => $speeches->lastPage()
            ]
        ]);
    }

    /**
     * Détail d'un discours
     */
    public function showSpeech(Speech $speech): JsonResponse
    {
        if (!$speech->is_published) {
            return response()->json([
                'success' => false,
                'message' => 'Discours non trouvé'
            ], 404);
        }

        $speech->load(['category', 'tags']);

        // Discours similaires
        $relatedSpeeches = Speech::published()
            ->where('id', '!=', $speech->id)
            ->where('category_id', $speech->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => new SpeechResource($speech),
            'related' => SpeechResource::collection($relatedSpeeches)
        ]);
    }

    /**
     * Liste des actualités
     */
    public function news(Request $request): JsonResponse
    {
        $query = News::published()->with(['category', 'tags']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('type')) {
            $query->byType($request->type);
        }

        if ($request->has('priority')) {
            $query->byPriority($request->priority);
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        if ($request->has('urgent')) {
            $query->urgent();
        }

        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest('published_at');
                break;
            case 'popular':
                $query->orderByDesc('views_count');
                break;
            case 'priority':
                $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')");
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        $news = $query->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => NewsResource::collection($news),
            'meta' => [
                'total' => $news->total(),
                'per_page' => $news->perPage(),
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage()
            ]
        ]);
    }

    /**
     * Liste des citations
     */
    public function quotes(Request $request): JsonResponse
    {
        $query = Quote::published();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        $quotes = $query->latest('published_at')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => QuoteResource::collection($quotes),
            'meta' => [
                'total' => $quotes->total(),
                'per_page' => $quotes->perPage(),
                'current_page' => $quotes->currentPage(),
                'last_page' => $quotes->lastPage()
            ]
        ]);
    }

    /**
     * Citation aléatoire
     */
    public function randomQuote(): JsonResponse
    {
        $quote = Quote::published()->inRandomOrder()->first();

        if (!$quote) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune citation disponible'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new QuoteResource($quote)
        ]);
    }

    /**
     * Liste des réseaux sociaux
     */
    public function socialLinks(): JsonResponse
    {
        $socialLinks = SocialLink::active()->visible()->ordered()->get();

        return response()->json([
            'success' => true,
            'data' => SocialLinkResource::collection($socialLinks)
        ]);
    }

    /**
     * Liste des catégories
     */
    public function categories(Request $request): JsonResponse
    {
        $query = Category::active()->ordered();

        if ($request->has('type')) {
            $query->byType($request->type);
        }

        $categories = $query->get();

        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($categories)
        ]);
    }

    /**
     * Recherche globale
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Terme de recherche requis'
            ], 422);
        }

        $results = [
            'speeches' => SpeechResource::collection(
                Speech::published()->search($query)->take(5)->get()
            ),
            'news' => NewsResource::collection(
                News::published()->search($query)->take(5)->get()
            ),
            'quotes' => QuoteResource::collection(
                Quote::published()->search($query)->take(3)->get()
            )
        ];

        return response()->json([
            'success' => true,
            'data' => $results,
            'query' => $query
        ]);
    }

    /**
     * Configuration de l'app
     */
    public function appConfig(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'app_name' => config('app.name'),
                'app_version' => config('app.version', '1.0.0'),
                'api_version' => 'v1',
                'pagination' => [
                    'speeches_per_page' => 15,
                    'videos_per_page' => 12,
                    'news_per_page' => 10,
                    'photos_per_page' => 20,
                    'quotes_per_page' => 10
                ],
                'features' => [
                    'push_notifications' => true,
                    'social_sharing' => true,
                    'offline_reading' => false,
                    'dark_mode' => true
                ],
                'contact' => [
                    'email' => config('app.contact_email'),
                    'phone' => config('app.contact_phone'),
                    'address' => config('app.contact_address')
                ]
            ]
        ]);
    }

    // Méthodes pour incrémenter les compteurs de vues et partages
    public function incrementSpeechView(Speech $speech): JsonResponse
    {
        $speech->increment('views_count');
        return response()->json(['success' => true]);
    }

    public function incrementSpeechShare(Speech $speech): JsonResponse
    {
        $speech->increment('shares_count');
        return response()->json(['success' => true]);
    }

    public function incrementNewsView(News $news): JsonResponse
    {
        $news->increment('views_count');
        return response()->json(['success' => true]);
    }

    public function incrementNewsShare(News $news): JsonResponse
    {
        $news->increment('shares_count');
        return response()->json(['success' => true]);
    }

    public function incrementQuoteShare(Quote $quote): JsonResponse
    {
        $quote->increment('shares_count');
        return response()->json(['success' => true]);
    }
}