<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
Route::get('/', [HotelController::class, 'index']);

Route::resource('hotels', HotelController::class);


Route::resource('rooms', RoomController::class);
Route::get('/bookings', [BookingController::class, 'index']);
Route::get('/rooms/{id}/book', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings/payment', [BookingController::class, 'payment'])->name('bookings.payment');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
//Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin', [AdminController::class, 'dashboard']);
