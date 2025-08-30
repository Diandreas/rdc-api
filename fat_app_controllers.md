# Contrôleurs et Resources API Laravel

## Contrôleurs Publics

### 1. ContentController (Public)

```php
<?php
// app/Http/Controllers/API/Public/ContentController.php
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
     * Liste des vidéos
     */
    public function videos(Request $request): JsonResponse
    {
        $query = Video::published()->with(['category', 'tags']);

        // Filtres similaires aux discours
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('quality')) {
            $query->byQuality($request->quality);
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest('recorded_date');
                break;
            case 'popular':
                $query->orderByDesc('views_count');
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        $videos = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data' => VideoResource::collection($videos),
            'meta' => [
                'total' => $videos->total(),
                'per_page' => $videos->perPage(),
                'current_page' => $videos->currentPage(),
                'last_page' => $videos->lastPage()
            ]
        ]);
    }

    /**
     * Détail d'une vidéo
     */
    public function showVideo(Video $video): JsonResponse
    {
        if (!$video->is_published) {
            return response()->json([
                'success' => false,
                'message' => 'Vidéo non trouvée'
            ], 404);
        }

        $video->load(['category', 'tags']);

        $relatedVideos = Video::published()
            ->where('id', '!=', $video->id)
            ->where('category_id', $video->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => new VideoResource($video),
            'related' => VideoResource::collection($relatedVideos)
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
     * Détail d'une actualité
     */
    public function showNews(News $news): JsonResponse
    {
        if (!$news->is_published) {
            return response()->json([
                'success' => false,
                'message' => 'Actualité non trouvée'
            ], 404);
        }

        $news->load(['category', 'tags']);

        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => new NewsResource($news),
            'related' => NewsResource::collection($relatedNews)
        ]);
    }

    /**
     * Liste des photos
     */
    public function photos(Request $request): JsonResponse
    {
        $query = Photo::published()->with(['category', 'tags']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('year')) {
            $query->byYear($request->year);
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest('photo_date');
                break;
            case 'popular':
                $query->orderByDesc('views_count');
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        $photos = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => PhotoResource::collection($photos),
            'meta' => [
                'total' => $photos->total(),
                'per_page' => $photos->perPage(),
                'current_page' => $photos->currentPage(),
                'last_page' => $photos->lastPage()
            ]
        ]);
    }

    /**
     * Détail d'une photo
     */
    public function showPhoto(Photo $photo): JsonResponse
    {
        if (!$photo->is_published) {
            return response()->json([
                'success' => false,
                'message' => 'Photo non trouvée'
            ], 404);
        }

        $photo->load(['category', 'tags']);

        return response()->json([
            'success' => true,
            'data' => new PhotoResource($photo)
        ]);
    }

    /**
     * Biographie du président
     */
    public function biography(): JsonResponse
    {
        $biographies = Biography::published()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => BiographyResource::collection($biographies)
        ]);
    }

    /**
     * Détail d'une section de biographie
     */
    public function showBiography(Biography $biography): JsonResponse
    {
        if (!$biography->is_published) {
            return response()->json([
                'success' => false,
                'message' => 'Section non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new BiographyResource($biography)
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
     * Liste des tags
     */
    public function tags(): JsonResponse
    {
        $tags = Tag::active()->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'color' => $tag->color
                ];
            })
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
            'videos' => VideoResource::collection(
                Video::published()->search($query)->take(5)->get()
            ),
            'news' => NewsResource::collection(
                News::published()->search($query)->take(5)->get()
            ),
            'photos' => PhotoResource::collection(
                Photo::published()->search($query)->take(5)->get()
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

    /**
     * Statistiques du dashboard
     */
    public function dashboardStats(): JsonResponse
    {
        $stats = [
            'speeches' => [
                'total' => Speech::count(),
                'published' => Speech::published()->count(),
                'featured' => Speech::published()->featured()->count(),
                'views' => Speech::sum('views_count')
            ],
            'videos' => [
                'total' => Video::count(),
                'published' => Video::published()->count(),
                'featured' => Video::published()->featured()->count(),
                'views' => Video::sum('views_count')
            ],
            'news' => [
                'total' => News::count(),
                'published' => News::published()->count(),
                'urgent' => News::published()->urgent()->count(),
                'views' => News::sum('views_count')
            ],
            'photos' => [
                'total' => Photo::count(),
                'published' => Photo::published()->count(),
                'featured' => Photo::published()->featured()->count(),
                'views' => Photo::sum('views_count')
            ],
            'quotes' => [
                'total' => Quote::count(),
                'published' => Quote::published()->count(),
                'featured' => Quote::published()->featured()->count()
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
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

    public function incrementVideoView(Video $video): JsonResponse
    {
        $video->increment('views_count');
        return response()->json(['success' => true]);
    }

    public function incrementVideoShare(Video $video): JsonResponse
    {
        $video->increment('shares_count');
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

    public function incrementPhotoView(Photo $photo): JsonResponse
    {
        $photo->increment('views_count');
        return response()->json(['success' => true]);
    }

    public function incrementPhotoShare(Photo $photo): JsonResponse
    {
        $photo->increment('shares_count');
        return response()->json(['success' => true]);
    }

    public function incrementQuoteShare(Quote $quote): JsonResponse
    {
        $quote->increment('shares_count');
        return response()->json(['success' => true]);
    }
}
```

### 2. ContactController (Public)

```php
<?php
// app/Http/Controllers/API/Public/ContactController.php
namespace App\Http\Controllers\API\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageReceived;
use App\Mail\ContactMessageConfirmation;

class ContactController extends Controller
{
    /**
     * Envoyer un message au Président
     */
    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        try {
            // Créer le message
            $message = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'city' => $request->city,
                'country' => $request->country ?? 'République Centrafricaine',
                'metadata' => [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'submitted_at' => now()->toISOString()
                ]
            ]);

            // Envoyer l'email de notification à l'administration
            try {
                Mail::to(config('app.admin_email'))
                    ->send(new ContactMessageReceived($message));
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email admin: ' . $e->getMessage());
            }

            // Envoyer l'email de confirmation à l'utilisateur
            try {
                Mail::to($message->email)
                    ->send(new ContactMessageConfirmation($message));
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email confirmation: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.',
                'data' => [
                    'id' => $message->id,
                    'reference' => 'MSG-' . str_pad($message->id, 6, '0', STR_PAD_LEFT)
                ]
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Erreur création message de contact: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.'
            ], 500);
        }
    }
}
```

## Contrôleurs d'Administration

### 3. AuthController

```php
<?php
// app/Http/Controllers/API/AuthController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Connexion admin
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données de connexion invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants incorrects'
            ], 401);
        }

        $user = Auth::user();
        
        if (!$user->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie'
        ]);
    }

    /**
     * Informations utilisateur connecté
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name')
            ]
        ]);
    }

    /**
     * Mot de passe oublié
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email invalide',
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Lien de réinitialisation envoyé par email'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'envoi du lien'
        ], 500);
    }

    /**
     * Réinitialiser le mot de passe
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => 'Mot de passe réinitialisé avec succès'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la réinitialisation'
        ], 500);
    }

    /**
     * Inscription (pour les tests en développement)
     */
    public function register(Request $request): JsonResponse
    {
        if (!app()->environment('local')) {
            return response()->json([
                'success' => false,
                'message' => 'Fonctionnalité non disponible'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Compte créé avec succès',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ], 201);
    }
}
```

### 4. SpeechController (Admin)

```php
<?php
// app/Http/Controllers/API/Admin/SpeechController.php
namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speech;
use App\Http\Requests\StoreSpeechRequest;
use App\Http\Requests\UpdateSpeechRequest;
use App\Http\Resources\SpeechResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class SpeechController extends Controller
{
    /**
     * Liste des discours pour l'admin
     */
    public function index(Request $request): JsonResponse
    {
        $query = Speech::with(['category', 'tags']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('status')) {
            if ($request->status === 'published') {
                $query->published();
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        if ($request->has('featured')) {
            $query->featured();
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'title':
                $query->orderBy('title');
                break;
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'views':
                $query->orderByDesc('views_count');
                break;
            case 'latest':
            default:
                $query->latest('created_at');
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
     * Créer un nouveau discours
     */
    public function store(StoreSpeechRequest $request): JsonResponse
    {
        $speech = Speech::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'event_type' => $request->event_type,
            'speech_date' => $request->speech_date,
            'speech_time' => $request->speech_time,
            'audio_url' => $request->audio_url,
            'video_url' => $request->video_url,
            'youtube_id' => $request->youtube_id,
            'duration' => $request->duration,
            'metadata' => $request->metadata ?? [],
            'is_featured' => $request->is_featured ?? false,
            'is_published' => $request->is_published ?? false,
            'published_at' => $request->is_published ? now() : null,
        ]);

        // Associer les tags
        if ($request->has('tags')) {
            $speech->tags()->sync($request->tags);
        }

        $speech->load(['category', 'tags']);

        return response()->json([
            'success' => true,
            'message' => 'Discours créé avec succès',
            'data' => new SpeechResource($speech)
        ], 201);
    }

    /**
     * Afficher un discours
     */
    public function show(Speech $speech): JsonResponse
    {
        $speech->load(['category', 'tags']);

        return response()->json([
            'success' => true,
            'data' => new SpeechResource($speech)
        ]);
    }

    /**
     * Mettre à jour un discours
     */
    public function update(UpdateSpeechRequest $request, Speech $speech): JsonResponse
    {
        $speech->update([
            'title' => $request->title,
            'slug' => $request->has('title') ? Str::slug($request->title) : $speech->slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'event_type' => $request->event_type,
            'speech_date' => $request->speech_date,
            'speech_time' => $request->speech_time,
            'audio_url' => $request->audio_url,
            'video_url' => $request->video_url,
            'youtube_id' => $request->youtube_id,
            'duration' => $request->duration,
            'metadata' => $request->metadata ?? $speech->metadata,
            'is_featured' => $request->is_featured ?? $speech->is_featured,
            'is_published' => $request->is_published ?? $speech->is_published,
            'published_at' => $request->is_published && !$speech->published_at ? now() : $speech->published_at,
        ]);

        // Mettre à jour les tags
        if ($request->has('tags')) {
            $speech->tags()->sync($request->tags);
        }

        $speech->load(['category', 'tags']);

        return response()->json([
            'success' => true,
            'message' => 'Discours mis à jour avec succès',
            'data' => new SpeechResource($speech)
        ]);
    }

    /**
     * Supprimer un discours
     */
    public function destroy(Speech $speech): JsonResponse
    {
        $speech->tags()->detach();
        $speech->clearMediaCollection();
        $speech->delete();

        return response()->json([
            'success' => true,
            'message' => 'Discours supprimé avec succès'
        ]);
    }

    /**
     * Publier un discours
     */
    public function publish(Speech $speech): JsonResponse
    {
        $speech->update([
            'is_published' => true,
            'published_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Discours publié avec succès',
            'data' => new SpeechResource($speech)
        ]);
    }

    /**
     * Dépublier un discours
     */
    public function unpublish(Speech $speech): JsonResponse
    {
        $speech->update([
            'is_published' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Discours dépublié avec succès',
            'data' => new SpeechResource($speech)
        ]);
    }

    /**
     * Marquer comme à la une
     */
    public function feature(Speech $speech): JsonResponse
    {
        $speech->update([
            'is_featured' => !$speech->is_featured
        ]);

        $message = $speech->is_featured ? 'Discours mis à la une' : 'Discours retiré de la une';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => new SpeechResource($speech)
        ]);
    }

    /**
     * Upload de média
     */
    public function uploadMedia(Request $request, Speech $speech): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,mp3,wav|max:10240', // 10MB max
            'collection' => 'required|string|in:thumbnails,documents'
        ]);

        try {
            $media = $speech->addMediaFromRequest('file')
                ->toMediaCollection($request->collection);

            return response()->json([
                'success' => true,
                'message' => 'Fichier uploadé avec succès',
                'data' => [
                    'id' => $media->id,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'url' => $media->getUrl(),
                    'collection' => $media->collection_name
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'upload: ' . $e->getMessage()
            ], 500);
        }
    }
}
```

## Resources API

### 1. SpeechResource

```php
<?php
// app/Http/Resources/SpeechResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpeechResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'location' => $this->location,
            'event_type' => $this->event_type,
            'speech_date' => $this->speech_date?->format('Y-m-d'),
            'speech_time' => $this->speech_time?->format('H:i'),
            'audio_url' => $this->audio_url,
            'video_url' => $this->video_url,
            'youtube_id' => $this->youtube_id,
            'duration' => $this->duration,
            'formatted_duration' => $this->formatted_duration,
            'metadata' => $this->metadata,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'views_count' => $this->views_count,
            'shares_count' => $this->shares_count,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relations
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            
            // Médias
            'thumbnail' => $this->getFirstMediaUrl('thumbnails'),
            'thumbnail_thumb' => $this->getFirstMediaUrl('thumbnails', 'thumb'),
            'documents' => $this->getMedia('documents')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'name' => $media->name,
                    'url' => $media->getUrl(),
                    'mime_type' => $media->mime_type,
                    'size' => $media->human_readable_size
                ];
            })
        ];
    }
}
```

### 2. VideoResource

```php
<?php
// app/Http/Resources/VideoResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'video_url' => $this->video_url,
            'youtube_id' => $this->youtube_id,
            'thumbnail_url' => $this->thumbnail_url,
            'youtube_thumbnail' => $this->youtube_thumbnail,
            'duration' => $this->duration,
            'formatted_duration' => $this->formatted_duration,
            'quality' => $this->quality,
            'location' => $this->location,
            'event_type' => $this->event_type,
            'recorded_date' => $this->recorded_date?->format('Y-m-d'),
            'metadata' => $this->metadata,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'views_count' => $this->views_count,
            'shares_count' => $this->shares_count,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relations
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            
            // Médias
            'thumbnail' => $this->getFirstMediaUrl('thumbnails'),
            'thumbnail_thumb' => $this->getFirstMediaUrl('thumbnails', 'thumb'),
            'thumbnail_preview' => $this->getFirstMediaUrl('thumbnails', 'preview')
        ];
    }
}
```

### 3. NewsResource

```php
<?php
// app/Http/Resources/NewsResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'source' => $this->source,
            'author' => $this->author,
            'type' => $this->type,
            'priority' => $this->priority,
            'send_notification' => $this->send_notification,
            'metadata' => $this->metadata,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'views_count' => $this->views_count,
            'shares_count' => $this->shares_count,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relations
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            
            // Médias
            'featured_image' => $this->getFirstMediaUrl('featured_images'),
            'featured_image_thumb' => $this->getFirstMediaUrl('featured_images', 'thumb'),
            'featured_image_medium' => $this->getFirstMediaUrl('featured_images', 'medium'),
            'attachments' => $this->getMedia('attachments')->map(function ($media) {
                return [
                    'id' => $media->id,
                    'name' => $media->name,
                    'url' => $media->getUrl(),
                    'mime_type' => $media->mime_type,
                    'size' => $media->human_readable_size
                ];
            })
        ];
    }
}
```

### 4. PhotoResource

```php
<?php
// app/Http/Resources/PhotoResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'photographer' => $this->photographer,
            'location' => $this->location,
            'event_type' => $this->event_type,
            'photo_date' => $this->photo_date?->format('Y-m-d'),
            'metadata' => $this->metadata,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'views_count' => $this->views_count,
            'shares_count' => $this->shares_count,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relations
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            
            // Médias
            'image' => $this->getFirstMediaUrl('images'),
            'image_thumb' => $this->getFirstMediaUrl('images', 'thumb'),
            'image_medium' => $this->getFirstMediaUrl('images', 'medium'),
            'image_large' => $this->getFirstMediaUrl('images', 'large')
        ];
    }
}
```

### 5. CategoryResource

```php
<?php
// app/Http/Resources/CategoryResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'color' => $this->color,
            'icon' => $this->icon,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Compteurs (si demandé)
            $this->mergeWhen($request->has('with_counts'), function () {
                return [
                    'speeches_count' => $this->speeches()->published()->count(),
                    'videos_count' => $this->videos()->published()->count(),
                    'news_count' => $this->news()->published()->count(),
                    'photos_count' => $this->photos()->published()->count(),
                ];
            })
        ];
    }
}
```

### 6. QuoteResource

```php
<?php
// app/Http/Resources/QuoteResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'short_content' => $this->short_content,
            'context' => $this->context,
            'source' => $this->source,
            'quote_date' => $this->quote_date?->format('Y-m-d'),
            'location' => $this->location,
            'metadata' => $this->metadata,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'shares_count' => $this->shares_count,
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
```

Cette architecture complète fournit tous les contrôleurs et resources nécessaires pour l'API de l'application mobile du Président FAT. Elle inclut une gestion complète des contenus, des médias, de l'authentification et des permissions, avec une API publique optimisée pour l'application mobile et une interface d'administration robuste.

Voulez-vous que je continue avec les Form Requests et les configurations supplémentaires ?