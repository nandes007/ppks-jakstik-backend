<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

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
