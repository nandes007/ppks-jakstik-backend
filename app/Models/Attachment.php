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
    protected function getDomain() {
        if (config("app.env") == "production") {
            return config("app.url");
        } else {
            return "http://127.0.0.1:8000";
        }
    }

    public function getSignedUrlAttribute()
    {
        $domain = $this->getDomain();
        if (!empty($this->url)) {
            return $domain . '/' . 'storage/' . $this->url;
        }
    }
}
