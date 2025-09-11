<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Photo;
use App\Models\Quote;
use App\Models\Speech;
use App\Models\Video;
use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Get application statistics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $totalSpeeches = Speech::where('is_published', true)->count();
            $totalNews = News::where('is_published', true)->count();
            $totalVideos = Video::where('is_published', true)->count();
            $totalPhotos = Photo::where('is_published', true)->count();
            $totalQuotes = Quote::count();
            $totalPublications = Publication::count();

            $featuredContent = Speech::where('is_featured', true)->where('is_published', true)->count()
                             + News::where('is_featured', true)->where('is_published', true)->count()
                             + Video::where('is_featured', true)->where('is_published', true)->count()
                             + Photo::where('is_featured', true)->where('is_published', true)->count();

            $lastUpdated = DB::table('news')->where('is_published', true)->latest('published_at')->value('published_at');

            $stats = [
                'total_speeches' => $totalSpeeches,
                'total_news' => $totalNews,
                'total_videos' => $totalVideos,
                'total_photos' => $totalPhotos,
                'total_quotes' => $totalQuotes,
                'total_publications' => $totalPublications,
                'featured_content' => $featuredContent,
                'last_updated' => $lastUpdated ? Carbon::parse($lastUpdated)->toIso8601String() : null,
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching statistics.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
