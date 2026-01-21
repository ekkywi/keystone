<?php

use Illuminate\Support\Facades\Route;
use App\Models\Server;
use App\Services\SshService;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PublicRequestController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Infrastructure\ServerController;
use App\Http\Controllers\Infrastructure\StackController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\ProjectServiceController;
use App\Http\Controllers\Project\ServiceOperationController;
use App\Http\Controllers\Help\HelpController;

// --- GUEST ROUTES ---
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/request-access', [PublicRequestController::class, 'create'])->name('request.create');
Route::post('/request-access', [PublicRequestController::class, 'store'])->name('request.store');

// --- AUTHENTICATED ROUTES (Must Login) ---
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Servers
    Route::resource('servers', ServerController::class);
    Route::post('/servers/{server}/test-connection', [ServerController::class, 'testConnection'])->name('servers.test-connection');

    // Stacks
    Route::resource('stacks', StackController::class);

    Route::middleware(['auth'])->group(function () {

        // Resource Project
        Route::resource('projects', ProjectController::class);

        // Resource Services (Shallow)
        Route::resource('projects.services', ProjectServiceController::class)
            ->only(['create', 'store', 'destroy', 'edit', 'update'])
            ->shallow();

        // Custom Actions
        Route::post('/services/{service}/deploy', [ServiceOperationController::class, 'deploy'])->name('services.deploy');
        Route::post('/services/{service}/stop', [ServiceOperationController::class, 'stop'])->name('services.stop');
        Route::get('/services/{service}/logs', [ServiceOperationController::class, 'logs'])->name('services.logs');
        Route::post('/services/{service}/refresh-status', [ServiceOperationController::class, 'refreshStatus'])->name('services.refresh-status');
        Route::post('/services/{service}/execute', [ServiceOperationController::class, 'executeCommand'])
            ->name('services.execute');
    });

    // Help
    Route::get('/help', [HelpController::class, 'index'])->name('help.index');
});
