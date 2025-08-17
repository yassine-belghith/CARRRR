<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarController as DashboardCarController;
use App\Http\Controllers\RentalController as DashboardRentalController;
use App\Http\Controllers\UserController as DashboardUserController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\TransferController as DashboardTransferController;
use App\Http\Controllers\TransferBookingController;
use App\Http\Controllers\Dashboard\ContactMessageController;
use App\Http\Controllers\UserPreferencesController;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home route redirect
Route::get('/home', function () {
    return redirect()->route('car.acceuil');
})->name('home');

// Publicly Accessible Routes
Route::get('/', [CarController::class, 'acceuil'])->name('car.acceuil');
Route::get('/cars', [CarController::class, 'cars'])->name('car.cars');
Route::get('/cars/search', [CarController::class, 'search'])->name('car.search');
Route::get('/cars/{car}', [CarController::class, 'publicShow'])->name('cars.detail');
Route::get('/contact', [ContactController::class, 'showContactForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.send');

// Language and Currency Switcher
Route::get('language/{locale}', [LocalizationController::class, 'switch'])->name('language.switch');
Route::get('currency/{currency}', [LocalizationController::class, 'switchCurrency'])->name('currency.switch');
Route::get('/unsubscribe/contact', [ContactController::class, 'unsubscribe'])->name('unsubscribe.contact');
Route::get('/transfers', [TransferBookingController::class, 'create'])->name('transfers.book');
Route::post('/transfers', [\App\Http\Controllers\TransferBookingController::class, 'store'])->name('transfers.store');
Route::post('/rentals/user/{car}', [RentalController::class, 'userStore'])->name('rental.user.store')->middleware('auth');

// Current reservation routes
Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');

// Chatbot route
Route::post('/chatbot', [ChatbotController::class, 'handle'])->name('chatbot.handle');

// User Profile & Preferences
Route::middleware('auth')->group(function () {
        Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile.show');
    Route::put('profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');
    Route::prefix('preferences')->name('preferences.')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'showPreferences'])->name('show');
        Route::post('avatar', [UserPreferencesController::class, 'updateAvatar'])->name('avatar');
        Route::put('/', [UserPreferencesController::class, 'update'])->name('update');
    });
});

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.perform');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Admin Dashboard Routes
Route::middleware(['auth', 'admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Car Management
    Route::resource('cars', DashboardCarController::class);

    // User Management
    Route::get('users', [DashboardUserController::class, 'users'])->name('users.index');
    Route::get('users/create', [DashboardUserController::class, 'create'])->name('users.create');
    Route::post('users', [DashboardUserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [DashboardUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [DashboardUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [DashboardUserController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{user}/make-admin', [DashboardUserController::class, 'makeAdmin'])->name('users.makeAdmin');
    Route::put('users/{user}/remove-admin', [DashboardUserController::class, 'removeAdmin'])->name('users.removeAdmin');
    Route::put('users/{user}/make-driver', [DashboardUserController::class, 'makeDriver'])->name('users.makeDriver');
    Route::put('users/{user}/remove-driver', [DashboardUserController::class, 'removeDriver'])->name('users.removeDriver');

    // Rental Management
    Route::resource('rentals', DashboardRentalController::class);
    Route::put('rentals/{rental}/status/{status}', [DashboardRentalController::class, 'updateStatus'])->name('rentals.status');

    // Other Resources
    Route::resource('destinations', DestinationController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('transfers', DashboardTransferController::class);

    // Transfers
    Route::get('transfers', [\App\Http\Controllers\Admin\TransferController::class, 'index'])->name('transfers.index');
    Route::get('transfers/{transfer}/edit', [\App\Http\Controllers\Admin\TransferController::class, 'edit'])->name('transfers.edit');

    // Contact Messages
    Route::resource('contact-messages', ContactMessageController::class);

    // Contact Messages
    Route::prefix('contact-messages')->name('contact.messages.')->group(function () {
        Route::get('/', [ContactMessageController::class, 'index'])->name('index');
        Route::get('/{contactMessage}', [ContactMessageController::class, 'show'])->name('show');
        Route::get('/{contactMessage}/edit', [ContactMessageController::class, 'edit'])->name('edit');
        Route::post('/{contactMessage}/toggle-read', [ContactMessageController::class, 'toggleReadStatus'])->name('toggle-read');
        Route::delete('/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('destroy');
        Route::delete('/multiple', [ContactMessageController::class, 'destroyMultiple'])->name('destroy-multiple');
        Route::get('/export', [ContactMessageController::class, 'export'])->name('export');
        Route::get('/stats', [ContactMessageController::class, 'stats'])->name('stats');
    });
});