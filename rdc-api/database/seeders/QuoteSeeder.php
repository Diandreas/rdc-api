<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quote;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quotes = [
            [
                'content' => 'L\'unité de notre peuple est notre force. Ensemble, nous bâtirons une République Centrafricaine prospère et pacifique.',
                'context' => 'Discours d\'investiture',
                'source' => 'Cérémonie d\'investiture 2021',
                'quote_date' => '2021-03-30',
                'location' => 'Bangui',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(30),
                'shares_count' => 456
            ],
            [
                'content' => 'La jeunesse centrafricaine est l\'avenir de notre nation. Nous devons investir dans son éducation et sa formation.',
                'context' => 'Rencontre avec les jeunes',
                'source' => 'Forum de la Jeunesse 2024',
                'quote_date' => '2024-02-14',
                'location' => 'Bangui',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'shares_count' => 289
            ],
            [
                'content' => 'La paix n\'est pas seulement l\'absence de guerre, c\'est la justice, l\'équité et le respect mutuel.',
                'context' => 'Conférence sur la paix',
                'source' => 'Sommet de la Paix 2023',
                'quote_date' => '2023-12-10',
                'location' => 'Bangui',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(45),
                'shares_count' => 178
            ],
            [
                'content' => 'Notre agriculture est le socle de notre économie. Nous devons moderniser nos techniques et soutenir nos agriculteurs.',
                'context' => 'Visite agricole',
                'source' => 'Visite dans l\'Ouham 2024',
                'quote_date' => '2024-01-20',
                'location' => 'Bossangoa',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(20),
                'shares_count' => 134
            ],
            [
                'content' => 'La réconciliation nationale passe par le dialogue, le pardon et la justice pour tous.',
                'context' => 'Forum de réconciliation',
                'source' => 'Forum National de Réconciliation',
                'quote_date' => '2023-11-15',
                'location' => 'Bangui',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(60),
                'shares_count' => 267
            ]
        ];

        foreach ($quotes as $quoteData) {
            Quote::create(array_merge($quoteData, [
                'metadata' => [
                    'language' => 'fr',
                    'verified' => true,
                    'category' => 'official'
                ]
            ]));
        }
    }
}