<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ─── Page d'accueil ──────────────────────────────────────────────────────────
Route::get('/', [HotelController::class, 'index']);

// ─── Hôtels (consultation publique) ──────────────────────────────────────────
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');

// ─── Chambres (consultation publique) ────────────────────────────────────────
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

// ─── Réservations (protégées par auth) ───────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/rooms/{id}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/payment', [BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/mes-reservations', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// ─── Avis ────────────────────────────────────────────────────────────────────
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::middleware('auth')->post('/reviews/room', [ReviewController::class, 'storeRoomReview'])->name('reviews.room');

// ─── Authentification ─────────────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('auth.login.post')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('auth.register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('auth.register.post')->middleware('guest');

// ─── Administration (protégée par auth + role:admin) ─────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // ─── Gestion des utilisateurs ────────────────────────────────────────────
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
});

// ─── CRUD Hôtels & Chambres (admin uniquement) ──────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('hotels', HotelController::class)->except(['index', 'show']);
    Route::resource('rooms', RoomController::class)->except(['index']);
});

// ─── Liste réservations (admin uniquement) ───────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
});
