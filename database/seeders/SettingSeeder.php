<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'url_video_tutorial' => 'https://www.youtube.com/watch?v=G_3V80LynwU',
            'header' => 'Welcome to PPDB Kuansing',
            'social_media' => [
                'facebook' => 'https://facebook.com/ppdbkuansing',
                'twitter' => 'https://twitter.com/ppdbkuansing',
                'instagram' => 'https://instagram.com/ppdbkuansing',
            ],
        ]);
    }
}
