<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\FacebookAuthController;

Route::get('/', [TaskController::class, 'index'])->name('tasks.index')->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('guest');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.auth');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [FacebookAuthController::class, 'redirectToFacebook'])->name('facebook.auth');
Route::get('auth/facebook/callback', [FacebookAuthController::class, 'handleFacebookCallback']);

Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');
Route::delete('/history/{id}', [HistoryController::class, 'deleteHistory'])->name('history.delete')->middleware('auth');
Route::delete('/history', [HistoryController::class, 'multiDeleteHistory'])->name('history.multi-delete')->middleware('auth');

Route::get('/create', [TaskController::class, 'create'])->name('tasks.create')->middleware('auth');
Route::get('/priority', [TaskController::class, 'priority'])->name('tasks.priority')->middleware('auth');
Route::get('/upcoming', [TaskController::class, 'upcoming'])->name('tasks.upcoming')->middleware('auth');
Route::get('/labels', [TaskController::class, 'labels'])->name('tasks.labels')->middleware('auth');
Route::get('/history', [TaskController::class, 'history'])->name('tasks.history')->middleware('auth');
Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search')->middleware('auth');

Route::post('/', [TaskController::class, 'store'])->name('tasks.store');

Route::get('/{task}', [TaskController::class, 'show'])->name('tasks.show')->middleware('auth');
Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit')->middleware('auth');
Route::put('/{task}', [TaskController::class, 'update'])->name('tasks.update')->middleware('auth');
Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware('auth');

Route::post('tasks/update_order', [TaskController::class, 'updateOrder'])->name('tasks.update_order')->middleware('auth');

Route::get('lang/{locale}', [LanguageController::class, 'swap'])->name('lang');
