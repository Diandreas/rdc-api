<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Discours Officiels',
                'slug' => 'discours-officiels',
                'description' => 'Discours officiels du Président de la République',
                'color' => '#1E40AF',
                'icon' => 'microphone',
                'type' => 'speech',
                'sort_order' => 1
            ],
            [
                'name' => 'Cérémonies',
                'slug' => 'ceremonies',
                'description' => 'Discours lors de cérémonies officielles',
                'color' => '#7C3AED',
                'icon' => 'calendar',
                'type' => 'speech',
                'sort_order' => 2
            ],
            [
                'name' => 'Visites Officielles',
                'slug' => 'visites-officielles',
                'description' => 'Discours lors de visites officielles',
                'color' => '#059669',
                'icon' => 'globe',
                'type' => 'speech',
                'sort_order' => 3
            ],
            [
                'name' => 'Communiqués',
                'slug' => 'communiques',
                'description' => 'Communiqués officiels de la Présidence',
                'color' => '#DC2626',
                'icon' => 'document',
                'type' => 'news',
                'sort_order' => 4
            ],
            [
                'name' => 'Actualités',
                'slug' => 'actualites',
                'description' => 'Actualités de la Présidence',
                'color' => '#EA580C',
                'icon' => 'newspaper',
                'type' => 'news',
                'sort_order' => 5
            ],
            [
                'name' => 'Événements',
                'slug' => 'evenements',
                'description' => 'Événements officiels',
                'color' => '#0891B2',
                'icon' => 'calendar-days',
                'type' => 'photo',
                'sort_order' => 6
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}