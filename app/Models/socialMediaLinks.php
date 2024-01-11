<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class socialMediaLinks extends Model
{
    use HasFactory;
    protected $table = 'social_media_links';

    protected $fillable = [
    'linkedin_link',
    'facebook_link',
    'youtube_link',
    'instagram_link',
    'status'
    ];
}
