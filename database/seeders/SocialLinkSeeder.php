<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SocialLink;

class SocialLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialLinks = [
            [
                'platform' => 'facebook',
                'username' => 'presidence.rca',
                'url' => 'https://facebook.com/presidence.rca',
                'icon' => 'facebook',
                'color' => '#1877F2',
                'description' => 'Page officielle Facebook de la Présidence',
                'sort_order' => 1
            ],
            [
                'platform' => 'twitter',
                'username' => 'presidencerca',
                'url' => 'https://twitter.com/presidencerca',
                'icon' => 'twitter',
                'color' => '#1DA1F2',
                'description' => 'Compte officiel Twitter de la Présidence',
                'sort_order' => 2
            ],
            [
                'platform' => 'youtube',
                'username' => 'PresidenceRCA',
                'url' => 'https://youtube.com/c/PresidenceRCA',
                'icon' => 'youtube',
                'color' => '#FF0000',
                'description' => 'Chaîne officielle YouTube de la Présidence',
                'sort_order' => 3
            ],
            [
                'platform' => 'instagram',
                'username' => 'presidence_rca',
                'url' => 'https://instagram.com/presidence_rca',
                'icon' => 'instagram',
                'color' => '#E4405F',
                'description' => 'Compte officiel Instagram de la Présidence',
                'sort_order' => 4
            ]
        ];

        foreach ($socialLinks as $link) {
            SocialLink::create($link);
        }
    }
}
