<?php
// Kegunaan file: Mendaftarkan alamat halaman publik, login, konsultasi, dan dashboard admin.

use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectConsultationController;
use Illuminate\Support\Facades\Route;

// Route halaman publik, formulir konsultasi, login, dan panel admin.
Route::post(
    '/konsultasi',
    [ProjectConsultationController::class, 'store']
)->name('consultations.store');
Route::get('/', HomeController::class)->name('home');

Route::middleware('guest')->group(function (){
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout'); 

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Semua halaman berikut hanya dapat dibuka setelah admin login.
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/consultations', [DashboardController::class, 'consultations'])->name('consultations.index');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::get('/chats', [AdminChatController::class, 'index'])->name('chats.index');
    Route::post('/chats/{conversation}/reply', [AdminChatController::class, 'reply'])->name('chats.reply');
    Route::post('/chats/{conversation}/close', [AdminChatController::class, 'close'])->name('chats.close');

    Route::resource('products', ProductController::class)
        ->except(['show']);

    Route::resource('services', ServiceController::class)
        ->except(['show']);
});
