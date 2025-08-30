<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Développement', 'color' => '#10B981'],
            ['name' => 'Économie', 'color' => '#F59E0B'],
            ['name' => 'Éducation', 'color' => '#3B82F6'],
            ['name' => 'Santé', 'color' => '#EF4444'],
            ['name' => 'Sécurité', 'color' => '#8B5CF6'],
            ['name' => 'Agriculture', 'color' => '#059669'],
            ['name' => 'Infrastructure', 'color' => '#6B7280'],
            ['name' => 'Jeunesse', 'color' => '#F97316'],
            ['name' => 'Femmes', 'color' => '#EC4899'],
            ['name' => 'Paix', 'color' => '#06B6D4'],
            ['name' => 'Réconciliation', 'color' => '#84CC16'],
            ['name' => 'Gouvernance', 'color' => '#6366F1'],
            ['name' => 'Démocratie', 'color' => '#14B8A6'],
            ['name' => 'État de Droit', 'color' => '#A855F7'],
            ['name' => 'Coopération', 'color' => '#F472B6']
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag['name'],
                'slug' => Str::slug($tag['name']),
                'color' => $tag['color'],
                'is_active' => true
            ]);
        }
    }
}