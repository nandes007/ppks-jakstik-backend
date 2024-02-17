<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'url'
    ];

    protected $appends = ['signed_url'];
    // protected $domain = env("APP_URL", "http://localhost");

    public function getSignedUrlAttribute()
    {
        if (!empty($this->url)) {
            return env("APP_URL", "http://localhost") . 'storage/' . $this->url;
        }
    }
}
