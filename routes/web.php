<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\StripeController;

// Welcome Route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Client Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::post('/start-verification/{client}', [ClientController::class, 'startVerification'])->name('start-verification');
});

// Document Routes
Route::middleware(['auth'])->group(function () {
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
});

// Notifications Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/read/{id}', [NotificationsController::class, 'markAsRead'])->name('notifications.read');
});

// Invitation Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/send-invitation', [InvitationController::class, 'sendInvitation'])->name('send-invitation');
});

Route::middleware(['invitation.access'])->group(function () {
    Route::get('/invitations/{token}', [InvitationController::class, 'showInvitationForm'])->name('invitations.complete');
    Route::post('/invitations/{token}', [InvitationController::class, 'completeInvitation'])->name('invitations.complete.post');
});

// Stripe Verification Route
Route::post('/create-verification-session', [StripeController::class, 'createVerificationSession'])->name('create-verification-session');

require __DIR__.'/auth.php';
