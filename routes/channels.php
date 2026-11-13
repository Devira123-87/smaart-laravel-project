<?php
// Kegunaan file: Menentukan siapa yang boleh mendengarkan kanal siaran aplikasi.

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Aturan akses untuk kanal siaran waktu nyata.
|--------------------------------------------------------------------------
*/ 

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
