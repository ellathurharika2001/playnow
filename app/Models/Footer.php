<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'footer_content',
        'footer_logo',
        'phone',
        'email',
        'address',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'linkedin_link',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}