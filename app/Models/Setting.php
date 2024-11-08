<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url_video_tutorial',
        'header',
        'social_media',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'social_media' => 'array',
    ];

    public function updateSocialMedia($platform, $url)
    {
        $socialMedia = $this->social_media ?? [];
        $socialMedia[$platform] = $url;

        $this->social_media = $socialMedia;
        $this->save();
    }
}
