<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Speech;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class SpeechSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $speeches = [
            [
                'title' => 'Discours d\'investiture du Président Faustin Archange Touadéra',
                'excerpt' => 'Discours prononcé lors de la cérémonie d\'investiture pour le second mandat présidentiel.',
                'content' => 'Mes chers compatriotes, c\'est avec une profonde émotion et un sentiment de responsabilité que je m\'adresse à vous aujourd\'hui...',
                'location' => 'Palais de la Renaissance, Bangui',
                'event_type' => 'Investiture',
                'speech_date' => '2021-03-30',
                'speech_time' => '10:00',
                'duration' => 1800,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(30),
                'views_count' => 15420,
                'shares_count' => 892
            ],
            [
                'title' => 'Message à la Nation pour la Nouvelle Année 2024',
                'excerpt' => 'Message de vœux du Président à la nation centrafricaine pour l\'année 2024.',
                'content' => 'Mes chers compatriotes, en cette aube de l\'année 2024, je vous adresse mes vœux les plus sincères...',
                'location' => 'Palais de la Renaissance, Bangui',
                'event_type' => 'Message à la Nation',
                'speech_date' => '2024-01-01',
                'speech_time' => '20:00',
                'duration' => 900,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(60),
                'views_count' => 8750,
                'shares_count' => 456
            ],
            [
                'title' => 'Discours sur l\'état de la Nation 2024',
                'excerpt' => 'Bilan des réalisations et perspectives pour l\'avenir de la République Centrafricaine.',
                'content' => 'Honorables députés, distingués invités, mes chers compatriotes, je me présente devant vous pour faire le bilan...',
                'location' => 'Assemblée Nationale, Bangui',
                'event_type' => 'Session parlementaire',
                'speech_date' => '2024-03-15',
                'speech_time' => '15:00',
                'duration' => 2400,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'views_count' => 12300,
                'shares_count' => 678
            ]
        ];

        $speechCategory = Category::where('type', 'speech')->first();
        $tags = Tag::take(5)->get();

        foreach ($speeches as $speechData) {
            $speech = Speech::create(array_merge($speechData, [
                'slug' => Str::slug($speechData['title']),
                'category_id' => $speechCategory?->id,
                'metadata' => [
                    'language' => 'fr',
                    'transcript_available' => true,
                    'audio_quality' => 'high'
                ]
            ]));

            // Associer quelques tags aléatoires
            $speech->tags()->attach($tags->random(3)->pluck('id'));
        }
    }
}
