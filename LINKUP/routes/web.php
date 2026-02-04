<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.welcome');
})->name("welcome");

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

  Route::post('/connect/{id}', [DashboardController::class, 'sendFriendRequest'])->name('connections.store');


    // connections page
    Route::get('/connections', [DashboardController::class, 'connections'])->name('connections');

    //actions
    Route::post('/connections/{id}/accept', [DashboardController::class, 'acceptRequest'])->name('connection.accept');
    Route::post('/connections/{id}/reject', [DashboardController::class, 'rejectRequest'])->name('connection.reject');
    Route::delete('/connections/{id}/cancel', [DashboardController::class, 'cancelRequest'])->name('connection.cancel');
    Route::delete('/connections/{id}/remove', [DashboardController::class, 'removeConnection'])->name('connection.remove');

    Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');

    // Route::get('/test', function(){
    //     return view('welcome');
    // });
require __DIR__.'/auth.php';
