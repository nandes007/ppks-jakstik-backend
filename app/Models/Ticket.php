<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_ticket',
        'nama',
        'email',
        'no_wa',
        'jenis_pengaduan',
        'deskripsi',
        'status'
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
