<?php

namespace App\Providers;

use App\Models\News;
use App\Models\Photo;
use App\Models\Quote;
use App\Models\SocialLink;
use App\Models\Speech;
use App\Models\Video;
use App\Observers\ContentNotificationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $observer = ContentNotificationObserver::class;

        Speech::observe($observer);
        News::observe($observer);
        Quote::observe($observer);
        Photo::observe($observer);
        Video::observe($observer);
        SocialLink::observe($observer);
    }
}
