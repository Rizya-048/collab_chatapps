<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
=======
// Semua route chat dilindungi login
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    // Tambahan fitur: buat percakapan & broadcast
    Route::post('/chat/create', [ChatController::class, 'createConversation'])->name('chat.create');
    Route::post('/chat/broadcast', [ChatController::class, 'createBroadcast'])->name('chat.broadcast');
});
>>>>>>> 501378dfd4c3b76db1b4c61b1037040ffa0c2aca
