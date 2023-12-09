<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
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

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// CRUD Route
Route::get('/dashboard', [ArticleController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/dashboard', [ArticleController::class, "store"])->middleware(['auth', 'verified'])->name('add.dashboard');    
Route::get('/delete/{id}', [ArticleController::class, "delete"])->middleware(['auth', 'verified'])->name('delete.dashboard');
Route::get('/article/edit', [ArticleController::class, "edit"])->middleware(['auth', 'verified'])->name('edit.dashboard');
Route::post('/article/update/{id}', [ArticleController::class, "update"])->middleware(['auth', 'verified'])->name('update.dashboard');    

// Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
