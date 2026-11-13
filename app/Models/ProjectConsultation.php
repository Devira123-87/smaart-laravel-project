<?php
// Kegunaan file: Mewakili data yang dikirim pengunjung melalui formulir konsultasi.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model untuk data permintaan konsultasi dari formulir pengunjung.
class ProjectConsultation extends Model
{
    // Isian formulir yang boleh disimpan sebagai permintaan konsultasi.
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service',
        'message',
        'status',
    ];
}