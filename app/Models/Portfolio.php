<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'email', 'phone', 'address', 'about', 'photo_url',
        'skills', 'education', 'projects', 'experience', 'links', 'template',
    ];

    protected $casts = [
        'skills' => 'array',
        'education' => 'array',
        'projects' => 'array',
        'experience' => 'array',
        'links' => 'array',
    ];

    /** Makes a user-typed link safe to put in an href. */
    public static function safeUrl(?string $u): string
    {
        $u = trim((string) $u);
        if ($u === '') return '#';
        return preg_match('#^https?://#i', $u) ? $u : 'https://' . $u;
    }
}
