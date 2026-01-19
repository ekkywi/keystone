<?php

use Illuminate\Support\Facades\Route;
use App\Models\Server;
use App\Services\SshService;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Infrastructure\ServerController;
use App\Http\Controllers\Infrastructure\StackController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\ProjectServiceController;
use App\Http\Controllers\Project\ServiceOperationController;

// --- GUEST ROUTES ---
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- AUTHENTICATED ROUTES (Must Login) ---
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Users
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Servers
    Route::resource('servers', ServerController::class);

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
    });

    Route::get('/test-ssh', function () {
        $server = Server::first();

        if (!$server) return "No server found in DB.";

        try {
            $ssh = new SshService();
            $ssh->connect($server);

            $user = $ssh->execute('whoami');
            $docker = $ssh->execute('docker -v');

            return "Connected to <b>{$server->name}</b>!<br>User: {$user}<br>Docker: {$docker}";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    });
});
