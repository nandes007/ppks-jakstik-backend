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
        'status',
        'created_by',
        'approved_by',
        'approved_at'
    ];

    protected $appends = [
        'category_formatted',
        'status_alias'
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function getCategoryFormattedAttribute()
    {
        switch($this->jenis_pengaduan) {
            case "A":
                return "Perundungan Online / Cyberbullying";
                break;
            case "B":
                return "Perundungan Fisik/ Physical Bullying";
                break;
            case "C":
                return "Perundungan Verbal/ Verbal Bullying";
                break;
            case "D":
                return "Kekerasan Seksual/ Sexual Violence";
                break;
            case "E":
                return "Perundungan Sosial/ Social Bullyings";
                break;
            default:
                return "";
        }
    }

    public function getStatusAliasAttribute()
    {
        switch($this->status) {
            case "Pending":
                return "Menghubungi";
            case "Consultation":
                return "Konsultasi";
            case "Service":
                return "Pemberian Layanan";
            case "Resolved":
                return "Penanganan";
            default:
                return "Menghubungi";
        }
    }
}
