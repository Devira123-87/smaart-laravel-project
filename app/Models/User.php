<?php
// Kegunaan file: Mewakili akun admin untuk proses login dan pengelolaan website.

namespace App\Models;

// Aktifkan jika akun perlu diwajibkan memverifikasi alamat email.
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Isian akun yang boleh disimpan melalui model.
    /**
     * Isian akun yang boleh disimpan sekaligus melalui model.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Jangan tampilkan kata sandi atau token saat data akun dibagikan.
    /**
     * Isian sensitif yang tidak ditampilkan saat data akun diubah menjadi array atau JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Ubah tanggal verifikasi dan hash kata sandi ke tipe data yang tepat.
    /**
     * Atur tipe data atribut saat dibaca dari atau disimpan ke database.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
