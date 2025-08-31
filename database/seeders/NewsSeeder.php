<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Lancement du Programme National de Développement Rural',
                'excerpt' => 'Le Président Touadéra lance un ambitieux programme de développement rural pour améliorer les conditions de vie en milieu rural.',
                'content' => 'Dans le cadre de sa politique de développement inclusif, le Président Faustin Archange Touadéra a officiellement lancé le Programme National de Développement Rural...',
                'source' => 'Présidence de la République',
                'author' => 'Service de Communication',
                'type' => 'announcement',
                'priority' => 'high',
                'send_notification' => true,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'views_count' => 3420,
                'shares_count' => 187
            ],
            [
                'title' => 'Rencontre avec les Leaders Religieux',
                'excerpt' => 'Le Chef de l\'État a reçu en audience les leaders religieux du pays pour discuter de la paix et de la réconciliation.',
                'content' => 'Le Président Faustin Archange Touadéra a reçu ce matin au Palais de la Renaissance une délégation de leaders religieux...',
                'source' => 'Cabinet du Président',
                'author' => 'Direction de la Communication',
                'type' => 'news',
                'priority' => 'medium',
                'send_notification' => false,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'views_count' => 1890,
                'shares_count' => 92
            ],
            [
                'title' => 'Inauguration de l\'Hôpital Général de Bangui Rénové',
                'excerpt' => 'Le Président inaugure les nouveaux équipements de l\'Hôpital Général de Bangui après sa rénovation complète.',
                'content' => 'C\'est avec fierté que le Président Touadéra a inauguré aujourd\'hui les nouvelles installations de l\'Hôpital Général de Bangui...',
                'source' => 'Ministère de la Santé',
                'author' => 'Service de Presse',
                'type' => 'press_release',
                'priority' => 'high',
                'send_notification' => true,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'views_count' => 5670,
                'shares_count' => 234
            ]
        ];

        $newsCategory = Category::where('type', 'news')->first();
        $tags = Tag::take(8)->get();

        foreach ($news as $newsData) {
            $newsItem = News::create(array_merge($newsData, [
                'slug' => Str::slug($newsData['title']),
                'category_id' => $newsCategory?->id,
                'metadata' => [
                    'language' => 'fr',
                    'reading_time' => rand(2, 8),
                    'keywords' => ['centrafrique', 'président', 'développement']
                ]
            ]));

            // Associer quelques tags aléatoires
            $newsItem->tags()->attach($tags->random(4)->pluck('id'));
        }
    }
}
