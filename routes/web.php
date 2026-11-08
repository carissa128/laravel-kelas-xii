<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\{
    AuthController,
    FilmController,
    KritikController,
    ProfileController,
};
use App\Http\Controllers\Admin\{
    CastController as AdminCastController,
    DashboardController as AdminDashboardController,
    FilmController as AdminFilmController,
    GenreController as AdminGenreController,
    PeranController as AdminPeranController,
    UserController as AdminUserController,
};

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', fn (): RedirectResponse => redirect()->route('home'))->name('login.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/movies/{film}/comments', [KritikController::class, 'store'])
    ->middleware(['auth', 'role:user'])
    ->name('comments.store');

Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');

// PINDAHKAN INI KE ATAS sebelum /movies/{film}
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');

// Route dinamis diletakkan di bawah route statis/spesifik
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('films', AdminFilmController::class)->except('show');
    Route::resource('casts', AdminCastController::class)->except('show');
    Route::resource('genres', AdminGenreController::class)->except('show');
    Route::resource('perans', AdminPeranController::class)->except('show');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});