<?php

use App\Http\Controllers\Auth\UsuarioLoginController;
use App\Http\Controllers\PoltronaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'auth' => ['user' => Auth::user()],
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('users.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('users.store');

////
Route::get('/usuario/login', function () {
    return view('auth.login');
});

Route::middleware('auth:usuarios')->group(function () {
    Route::get('/poltronas/disponiveis', [PoltronaController::class, 'disponiveis'])->name('poltronas.disponiveis');
    Route::post('/poltronas/reservar/{id}', [PoltronaController::class, 'reservar'])->name('poltronas.reservar');
});

Route::post('/usuario/login', [UsuarioLoginController::class, 'login'])->name('usuario.login');
//

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UsuarioController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UsuarioController::class, 'destroy'])->name('users.destroy');

    // Exibir lista de poltronas
    Route::get('/poltronas', [PoltronaController::class, 'index'])->name('poltronas.index');
    // Exibir formulário de criação de poltrona
    Route::get('/poltronas/create', [PoltronaController::class, 'create'])->name('poltronas.create');
    // Armazenar a poltrona criada
    Route::post('/poltronas', [PoltronaController::class, 'store'])->name('poltronas.store');
});

require __DIR__ . '/auth.php';
