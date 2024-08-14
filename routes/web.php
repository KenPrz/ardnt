<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\NewsFeedController;
use App\Http\Controllers\LikePostController;
use App\Http\Controllers\FollowUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [NewsFeedController::class, 'index'])->name('dashboard');
    Route::post('/like-post', [LikePostController::class, 'like'])->name('post.like');
    Route::delete('/unlike-post', [LikePostController::class, 'unlike'])->name('post.unlike');
    Route::post('/follow-user', [FollowUserController::class, 'follow'])->name('user.follow');
    Route::delete('/unfollow-user', [FollowUserController::class, 'unfollow'])->name('user.unfollow');
});

//auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
