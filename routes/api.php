<?php
// Kegunaan file: Mendaftarkan endpoint API chat yang dipakai widget pengunjung.

use App\Http\Controllers\PublicChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route API untuk komunikasi data tanpa memuat ulang halaman.
| Route di file ini otomatis memakai middleware grup API.
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API ini dipakai widget chat untuk mengambil riwayat, mengirim pesan, dan meminta admin.
Route::get('/chat', [PublicChatController::class, 'show']);
Route::post('/chat', [PublicChatController::class, 'send'])->middleware('throttle:chat');
Route::post('/chat/handoff', [PublicChatController::class, 'handoff'])->middleware('throttle:chat');
