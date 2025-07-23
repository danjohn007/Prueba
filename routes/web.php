<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Business\DashboardController as BusinessDashboard;
use App\Http\Controllers\Collaborator\DashboardController as CollaboratorDashboard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/directorio', [HomeController::class, 'directory'])->name('directory');
Route::get('/negocio/{id}', [HomeController::class, 'businessDetail'])->name('business.detail');

// Autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rutas protegidas
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Panel de Administrador
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::post('/export-report', [AdminDashboard::class, 'exportReport'])->name('export.report');
        
        // Gestión de usuarios y afiliaciones
        Route::resource('users', UserController::class);
        Route::resource('businesses', BusinessController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('commissions', CommissionController::class);
        Route::resource('events', EventController::class);
    });
    
    // Panel de Colaborador
    Route::middleware('role:collaborator')->prefix('collaborator')->name('collaborator.')->group(function () {
        Route::get('/dashboard', [CollaboratorDashboard::class, 'index'])->name('dashboard');
        Route::get('/affiliations', [CollaboratorDashboard::class, 'affiliations'])->name('affiliations');
        Route::get('/commissions', [CollaboratorDashboard::class, 'commissions'])->name('commissions');
        Route::get('/monthly-report', [CollaboratorDashboard::class, 'monthlyReport'])->name('monthly.report');
        
        // Gestión de afiliaciones
        Route::resource('businesses', 'Collaborator\BusinessController')->only(['index', 'show', 'create', 'store']);
    });
    
    // Panel de Comercio Afiliado
    Route::middleware('role:business')->prefix('business')->name('business.')->group(function () {
        Route::get('/dashboard', [BusinessDashboard::class, 'index'])->name('dashboard');
        Route::get('/profile', [BusinessDashboard::class, 'profile'])->name('profile');
        Route::put('/profile', [BusinessDashboard::class, 'updateProfile'])->name('profile.update');
        Route::get('/documents', [BusinessDashboard::class, 'documents'])->name('documents');
        Route::post('/documents', [BusinessDashboard::class, 'uploadDocument'])->name('documents.upload');
        Route::get('/payments', [BusinessDashboard::class, 'payments'])->name('payments');
        
        // Eventos y registraciones
        Route::resource('events', 'Business\EventController')->only(['index', 'show']);
        Route::post('/events/{event}/register', 'Business\EventController@register')->name('events.register');
    });
});

// API Routes (para integraciones futuras)
Route::prefix('api')->name('api.')->group(function () {
    Route::post('/webhook/payment', 'Api\PaymentWebhookController@handle')->name('payment.webhook');
    Route::post('/webhook/whatsapp', 'Api\WhatsAppWebhookController@handle')->name('whatsapp.webhook');
});