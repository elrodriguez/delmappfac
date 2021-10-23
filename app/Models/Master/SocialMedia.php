<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_media_name',
        'url_event',
        'logo',
        'background_color',
        'state',
        'credentials',
        'username',
        'user_password',
        'access_token',
        'access_key_id',
        'access_secret_key_id',
        'access_port',
        'access_host',
        'access_api'
    ];
}
