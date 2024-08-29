<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowUserController;
use App\Http\Controllers\LikePostController;
use App\Http\Controllers\NewsFeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ViewUsersController;
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

// Routes with 'auth' and 'verified' middleware
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard route
    Route::get('/feed', [NewsFeedController::class, 'index'])->name('dashboard');

    // Post Like/Unlike routes
    Route::post('/like-post', [LikePostController::class, 'like'])->name('post.like');
    Route::delete('/unlike-post', [LikePostController::class, 'unlike'])->name('post.unlike');

    // Follow/Unfollow User routes
    Route::post('/follow-user', [FollowUserController::class, 'follow'])->name('user.follow');
    Route::delete('/unfollow-user', [FollowUserController::class, 'unfollow'])->name('user.unfollow');

    // Post routes
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/share-post', [PostController::class, 'sharePost'])->name('posts.share');
    Route::get('/posts/show/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::put('/posts', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts', [PostController::class, 'destroy'])->name('posts.destroy');

    // User viewing routes
    Route::get('/users/{user}', [ViewUsersController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/posts', [ViewUsersController::class, 'getPosts'])->name('users.posts');

    // Comment routes
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comment', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Search route
    Route::get('/search-query', [SearchController::class, 'search'])->name('search');
    Route::get('/search/{query}', [SearchController::class, 'index'])->name('search.index');
});

// Routes with 'auth' middleware only
Route::middleware('auth')->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar.store');
    Route::patch('/profile/socials', [ProfileController::class, 'updateSocials'])->name('profile.update.socials');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
