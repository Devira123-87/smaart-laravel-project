<?php
// Kegunaan file: Mendaftarkan perintah terminal khusus aplikasi.

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Route untuk perintah terminal (Artisan) khusus aplikasi.
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Tampilkan kutipan penyemangat');

