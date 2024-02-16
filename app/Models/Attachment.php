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
    protected $domain = 'http://127.0.0.1:8000/';

    public function getSignedUrlAttribute()
    {
        if (!empty($this->url)) {
            return $this->domain . 'storage/' . $this->url;
        }
    }
}
