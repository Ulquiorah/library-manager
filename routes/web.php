<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\PenaliteController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\CategorieController;

// Routes web de l'application

// Routes publiques
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        // Rediriger selon le rôle de l'utilisateur
        if ($user->role_id === 1) {
            return redirect()->route('home');
        } else {
            return redirect()->route('dashboard');
        }
    }
    return redirect()->route('login');
});

// Routes d'authentification (guest middleware)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// Routes protégées (auth middleware)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');
    
    // Route d'accueil pour les utilisateurs simples (role_id = 1)
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('check.role:1');
    
    // Routes pour les administrateurs/bibliothécaires (role_id >= 2)
    Route::middleware('check.role:2,3')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/administration', [DashboardController::class, 'administration'])->name('administration');
        
        // Routes pour la gestion des utilisateurs
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update.role');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::get('/categories', [CategorieController::class, 'index'])->name('categories');
    Route::post('/categories', [CategorieController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{categorie}', [CategorieController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{categorie}', [CategorieController::class, 'destroy'])->name('categories.destroy');

    // Routes des livres
    Route::resource('livres', LivreController::class);
    Route::post('/livres/{livre}/emprunter', [EmpruntController::class, 'store'])->name('livres.emprunter');
    Route::patch('/emprunts/{emprunt}/return', [EmpruntController::class, 'return'])->name('emprunts.return');

    // Routes des pénalités (administrateur)
    Route::patch('/penalites/{penalite}/pay', [PenaliteController::class, 'pay'])->name('penalites.pay');
});

