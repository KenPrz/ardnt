<?php

use App\Http\Controllers\FollowUserController;
use App\Http\Controllers\LikePostController;
use App\Http\Controllers\NewsFeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ViewUsersController;
use App\Http\Controllers\CommentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/show/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/users/{user}', [ViewUsersController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/posts', [ViewUsersController::class, 'getPosts'])->name('users.posts');
    Route::get('/users/{user}/followers', [ViewUsersController::class, 'followers'])->name('users.followers');
    Route::get('/users/{user}/following', [ViewUsersController::class, 'following'])->name('users.following');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comment', [CommentController::class,'destroy'])->name('comments.destroy');
});

//auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
