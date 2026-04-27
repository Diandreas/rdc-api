<?php

namespace App\Observers;

use App\Models\News;
use App\Models\Photo;
use App\Models\Quote;
use App\Models\SocialLink;
use App\Models\Speech;
use App\Models\Video;
use App\Services\FcmService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContentNotificationObserver
{
    public function created(Model $model): void
    {
        $notification = $this->resolveNotificationPayload($model);

        if ($notification === null) {
            return;
        }

        try {
            $sent = app(FcmService::class)->sendToTopic(
                $notification['topic'],
                $notification['title'],
                $notification['body'],
                $notification['data']
            );

            if (!$sent) {
                Log::warning('Automatic content notification was not sent.', [
                    'model' => $model::class,
                    'id' => $model->getKey(),
                    'topic' => $notification['topic'],
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Automatic content notification failed.', [
                'model' => $model::class,
                'id' => $model->getKey(),
                'topic' => $notification['topic'],
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function resolveNotificationPayload(Model $model): ?array
    {
        return match (true) {
            $model instanceof Speech => [
                'topic' => 'speeches',
                'title' => 'Nouveau discours',
                'body' => Str::limit($model->title, 120),
                'data' => ['type' => 'speech', 'id' => $model->getKey()],
            ],
            $model instanceof News => [
                'topic' => 'news',
                'title' => 'Nouvelle actualité',
                'body' => Str::limit($model->title, 120),
                'data' => ['type' => 'news', 'id' => $model->getKey()],
            ],
            $model instanceof Quote => [
                'topic' => 'quotes',
                'title' => 'Nouvelle citation',
                'body' => Str::limit($model->content, 140),
                'data' => ['type' => 'quote', 'id' => $model->getKey()],
            ],
            $model instanceof Photo => [
                'topic' => 'gallery',
                'title' => 'Nouvelle photo',
                'body' => Str::limit($model->title, 120),
                'data' => ['type' => 'photo', 'id' => $model->getKey()],
            ],
            $model instanceof Video => [
                'topic' => 'videos',
                'title' => 'Nouvelle vidéo',
                'body' => Str::limit($model->title, 120),
                'data' => ['type' => 'video', 'id' => $model->getKey()],
            ],
            $model instanceof SocialLink => [
                'topic' => 'acts',
                'title' => 'Nouvel acte du chef de l\'État',
                'body' => Str::limit($model->title, 120),
                'data' => ['type' => 'act', 'id' => $model->getKey()],
            ],
            default => null,
        };
    }
}
