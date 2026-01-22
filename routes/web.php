<?php

use Illuminate\Support\Facades\Route;

// --- CONTROLLERS IMPORT ---
// Auth
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AccessRequestController;

// Core & Common
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Help\HelpController;

// Infrastructure
use App\Http\Controllers\Infrastructure\ServerController;
use App\Http\Controllers\Infrastructure\StackController;

// Projects & Services
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\ProjectServiceController;
use App\Http\Controllers\Project\ServiceOperationController;

// Admin Zone
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| PUBLIC & GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login'));

// Authentication
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.process');
    Route::post('/logout', 'logout')->name('logout');
});

// Access Request (Guest)
Route::controller(AccessRequestController::class)->group(function () {
    Route::get('/request-access', 'create')->name('request.create');
    Route::post('/request-access', 'store')->name('request.store');
    // QR Verification (Allow slashes in ticket_number)
    Route::get('/verify/{ticket_number}', 'verifyQr')
        ->name('request.verify')
        ->where('ticket_number', '.*');
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (GENERAL USER)
|--------------------------------------------------------------------------
| Semua user yang sudah login (Apapun role-nya) bisa akses ini.
*/

Route::middleware(['auth'])->group(function () {

    // --- Core ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/help', [HelpController::class, 'index'])->name('help.index');

    // --- Infrastructure Management ---
    Route::resource('servers', ServerController::class);
    Route::post('/servers/{server}/test-connection', [ServerController::class, 'testConnection'])
        ->name('servers.test-connection');

    Route::resource('stacks', StackController::class);

    // --- Project Management ---
    Route::resource('projects', ProjectController::class);

    // --- Service Management (Shallow Resource) ---
    Route::resource('projects.services', ProjectServiceController::class)
        ->only(['create', 'store', 'destroy', 'edit', 'update'])
        ->shallow();

    // --- Service Operations (Actions) ---
    Route::controller(ServiceOperationController::class)->prefix('services/{service}')->name('services.')->group(function () {
        Route::post('/deploy', 'deploy')->name('deploy');
        Route::post('/stop', 'stop')->name('stop');
        Route::get('/logs', 'logs')->name('logs');
        Route::post('/refresh-status', 'refreshStatus')->name('refresh-status');
        Route::post('/execute', 'executeCommand')->name('execute');
    });

    // --- Request Center (Internal)
    Route::get('/my-requests', [AccessRequestController::class, 'index'])->name('internal.requests.index');
    Route::get('/my-requests/create', [AccessRequestController::class, 'createInternal'])->name('internal.requests.create');
    Route::post('/my-requests', [AccessRequestController::class, 'storeInternal'])->name('internal.requests.store');
});


/*
|--------------------------------------------------------------------------
| ROLE-BASED ACCESS CONTROL (RBAC)
|--------------------------------------------------------------------------
*/

// 1. SYSTEM ADMINISTRATOR ZONE
Route::middleware(['auth', 'role:system_administrator'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User Management (Dipindahkan kesini agar aman)
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');

        // Approval Request
        Route::post('/requests/{id}/approve', [AdminDashboardController::class, 'approve'])->name('requests.approve');
        Route::post('/requests/{id}/reject', [AdminDashboardController::class, 'reject'])->name('requests.reject');
    });

// 2. DEVELOPER ZONE
Route::middleware(['auth', 'role:developer'])
    ->prefix('dev')
    ->name('dev.')
    ->group(function () {

        Route::get('/my-tickets', fn() => "Halaman Khusus Developer")->name('tickets');
    });

// 3. AUDIT ZONE (Admin + QA)
Route::middleware(['auth', 'role:system_administrator,quality_assurance'])
    ->prefix('audit')
    ->name('audit.')
    ->group(function () {

        Route::get('/logs', fn() => "Halaman Audit Log")->name('logs');
    });
