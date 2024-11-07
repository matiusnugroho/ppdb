<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'url_video_tutorial' => 'https://example.com/tutorial',
            'header' => 'Welcome to PPDB Kuansing',
            'social_media' => json_encode([
                'facebook' => 'https://facebook.com/ppdbkuansing',
                'twitter' => 'https://twitter.com/ppdbkuansing',
                'instagram' => 'https://instagram.com/ppdbkuansing',
            ]),
        ]);
    }
}
