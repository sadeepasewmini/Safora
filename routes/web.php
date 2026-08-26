<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\SosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

// Public Home Page & Map
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/live-map-data', [HomeController::class, 'apiLiveMapData'])->name('api.live-map-data');

// Incident reporting & details
Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
Route::get('/incidents/{id}', [IncidentController::class, 'show'])->name('incidents.show');
Route::post('/incidents/{id}/vote', [IncidentController::class, 'vote'])->name('incidents.vote');
Route::post('/ai/classify', [IncidentController::class, 'classifyAi'])->name('ai.classify');
Route::get('/ai/predict-risk', [IncidentController::class, 'predictRisk'])->name('ai.predict-risk');
Route::get('/ai/safe-route', [IncidentController::class, 'calculateSafeRoute'])->name('ai.safe-route');
Route::post('/ai/chat', [HomeController::class, 'aiChat'])->name('ai.chat');
Route::post('/api/public-feedback', [HomeController::class, 'storePublicFeedback'])->name('api.public-feedback.store');
Route::get('/log-sheets', fn() => response()->file(base_path('icbt_project_log_sheets.html')))->name('log-sheets');

// Instant SOS
Route::post('/sos/trigger', [SosController::class, 'trigger'])->name('sos.trigger');

// Authentication Routes (Public Registration & Login)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Dashboard Routes
Route::middleware(['auth'])->group(function () {
    // Central Router
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 4 Role Specific Dashboards
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/moderator/dashboard', [DashboardController::class, 'moderatorDashboard'])->name('moderator.dashboard');
    Route::get('/authority/dashboard', [DashboardController::class, 'authorityDashboard'])->name('authority.dashboard');
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');

    // Admin Only: Add Officers & Staff (Admin, Moderator, Authority)
    Route::post('/admin/staff', [DashboardController::class, 'storeStaff'])->name('admin.store-staff');

    // Moderator & Authority Actions
    Route::post('/incidents/{id}/status', [DashboardController::class, 'updateIncidentStatus'])->name('incidents.update-status');
    Route::post('/alerts', [DashboardController::class, 'createAlert'])->name('alerts.create');
    Route::post('/safe-places', [DashboardController::class, 'storeSafePlace'])->name('safe-places.store');
    Route::post('/sos/{id}/resolve', [DashboardController::class, 'resolveSos'])->name('sos.resolve');
});
