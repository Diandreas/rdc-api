<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Speech;
use App\Models\News;
use App\Models\Quote;
use App\Models\Photo;
use App\Models\Video;
use App\Models\ContactMessage;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'speeches' => Speech::count(),
            'news' => News::count(),
            'quotes' => Quote::count(),
            'photos' => Photo::count(),
            'videos' => Video::count(),
            'categories' => Category::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_messages' => ContactMessage::count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentSpeeches = Speech::with('category')->latest()->take(3)->get();
        $recentNews = News::with('category')->latest()->take(3)->get();

        return view('admin.dashboard.index', compact('stats', 'recentMessages', 'recentSpeeches', 'recentNews'));
    }
}
