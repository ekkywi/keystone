<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\ProjectService; // Pastikan Model ini sesuai nama file Anda (ProjectService atau Service)
use App\Services\DockerGenerator;
use App\Services\SshService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ServiceOperationController extends Controller
{
    protected $ssh;
    protected $generator;

    public function __construct(SshService $ssh, DockerGenerator $generator)
    {
        $this->ssh = $ssh;
        $this->generator = $generator;
    }

    /**
     * Deploy Service (Sekarang Return JSON untuk AJAX)
     */
    public function deploy(ProjectService $service)
    {
        // 1. Setup Resource PHP agar tidak timeout saat build lama
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        // 2. Validasi Owner
        if ($service->project->user_id !== auth()->id()) abort(403);

        // 3. Update Status ke 'Building' & Reset Error lama
        $service->update([
            'status' => 'building',
            'deployment_error' => null
        ]);

        try {
            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";

            // A. Konek SSH & Siapkan Folder
            $this->ssh->connect($service->server);
            $this->ssh->ensureDirectoryExists($remotePath);

            // B. Buat Network (Jika belum ada)
            $networkName = "keystone-p{$service->project_id}-net";
            $this->ssh->execute("docker network create {$networkName} || true");

            // C. Setup Code (Git Clone/Pull) jika tipe Application
            if ($service->stack->type === 'application') {
                $this->handleApplicationSetup($service, $remotePath);
            }

            // D. Generate & Upload docker-compose.yml
            $composeContent = $this->generator->generateComposeFile($service);
            $this->ssh->uploadFile("{$remotePath}/docker-compose.yml", $composeContent);

            // E. EKSEKUSI DOCKER UP
            // Tambahkan '2>&1' untuk menangkap pesan Error (stderr) ke dalam output variable
            $command = "cd {$remotePath} && docker compose up -d --build --remove-orphans 2>&1";
            $output = $this->ssh->execute($command);

            // Cek manual jika ada kata 'Error' tapi exit code 0 (Jaga-jaga)
            if (str_contains(strtolower($output), 'error') && !str_contains(strtolower($output), 'warning')) {
                // Abaikan error remeh, tangkap error fatal
                // throw new \Exception($output); 
                // (Opsional: kadang output docker verbose, jadi hati-hati enable ini)
            }

            // F. Sukses
            $service->update([
                'status' => 'running',
                'last_deployed_at' => now(),
                'deployment_error' => null
            ]);

            // Return JSON untuk UI Polling
            return response()->json([
                'status' => 'success',
                'message' => 'Service deployed successfully.'
            ]);
        } catch (\Exception $e) {
            // G. Gagal Handle
            $rawError = $e->getMessage();
            $humanError = $this->parseDockerError($rawError); // Percantik pesan error

            $service->update([
                'status' => 'failed',
                'deployment_error' => $humanError
            ]);

            Log::error("Deploy Failed Service {$service->id}: " . $rawError);

            return response()->json([
                'status' => 'error',
                'message' => 'Deploy failed. Check card for details.',
                'error_detail' => $humanError
            ], 500);
        }
    }

    /**
     * Helper untuk Git Clone / Pull
     */
    private function handleApplicationSetup(ProjectService $service, $remotePath)
    {
        $dockerfileContent = $service->stack->build_dockerfile;
        if (!empty($dockerfileContent)) {
            $this->ssh->uploadFile("{$remotePath}/Dockerfile", $dockerfileContent);
        } else {
            throw new \Exception("Stack configuration error: Dockerfile content is missing.");
        }

        $codePath = "{$remotePath}/code";
        $repoUrl = $service->repository_url;
        $branch = $service->branch ?? 'main';

        if (empty($repoUrl)) {
            throw new \Exception("Repository URL is required for application deployment.");
        }

        // Cek folder git
        $checkGit = $this->ssh->execute("if [ -d \"{$codePath}/.git\" ]; then echo 'EXISTS'; else echo 'NO'; fi");

        if (trim($checkGit) === 'EXISTS') {
            // Pull Updates
            $safeBranch = escapeshellarg($branch);
            $this->ssh->execute("cd {$codePath} && git fetch origin && git reset --hard origin/{$safeBranch}");
        } else {
            // Clone Fresh
            $this->ssh->execute("rm -rf {$codePath}");
            $safeRepo = escapeshellarg($repoUrl);
            $safeBranch = escapeshellarg($branch);
            $this->ssh->execute("git clone --branch {$safeBranch} {$safeRepo} {$codePath}");
        }

        // Fix Permissions (777 ke storage agar Laravel bisa nulis log/session)
        $this->ssh->execute("chmod -R 777 {$codePath}/storage {$codePath}/bootstrap/cache || true");
    }

    /**
     * Stop Service (Updated to JSON)
     */
    public function stop(ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        try {
            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";

            $this->ssh->connect($service->server);
            $this->ssh->execute("cd {$remotePath} && docker compose down");

            $service->update(['status' => 'stopped']);

            return response()->json([
                'status' => 'success',
                'message' => 'Service stopped successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stop Failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logs Stream (Tetap sama)
     */
    public function logs(ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        try {
            $service->load('server');
            if (!$service->server) {
                return response()->json(['status' => 'error', 'logs' => "CRITICAL ERROR: Server data missing."]);
            }

            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";
            $this->ssh->connect($service->server);

            // 2>&1 Penting agar error log juga tertangkap
            $output = $this->ssh->execute("cd {$remotePath} && docker compose logs --tail=100 2>&1");

            return response()->json(['status' => 'success', 'logs' => $output]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'logs' => 'System Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Polling Status (Updated dengan Error Handling)
     */
    public function refreshStatus(ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        try {
            $service->load('server');

            // Fail safe jika server terhapus
            if (!$service->server) return response()->json(['status' => 'error', 'message' => 'Server not found.'], 404);

            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";
            $this->ssh->connect($service->server);

            // Cek status container real di Docker
            try {
                $output = $this->ssh->execute("cd {$remotePath} && docker compose ps --format \"{{.State}}\"");
                $realStatus = str_contains(strtolower($output), 'running') ? 'running' : 'stopped';
            } catch (\Exception $e) {
                // Jika folder hilang atau error SSH
                $realStatus = 'stopped';
            }

            // LOGIKA PENTING:
            // Jika Docker bilang 'stopped', TAPI di database 'failed' (karena error deploy terakhir),
            // maka JANGAN ubah jadi 'stopped'. Biarkan 'failed' agar pesan error tetap muncul di UI.
            if ($realStatus === 'stopped' && $service->status === 'failed') {
                $finalStatus = 'failed';
            } else {
                $finalStatus = $realStatus;
            }

            // Simpan state baru
            $service->update(['status' => $finalStatus]);

            return response()->json([
                'status' => 'success',
                'new_status' => $finalStatus,
                'deployment_error' => $service->deployment_error // Kirim pesan error ke UI
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * FITUR BARU: Execute Command (Console/Terminal)
     */
    public function executeCommand(Request $request, ProjectService $service)
    {
        // 1. Validasi User
        if ($service->project->user_id !== Auth::id()) abort(403);

        // 2. Load Relasi Penting (INI YANG SEBELUMNYA KURANG)
        // Kita butuh data 'stack' untuk cek tipe container, dan 'server' untuk SSH
        $service->load(['stack', 'server']);

        // 3. Validasi Input & Status
        $request->validate(['command' => 'required|string']);

        if ($service->status !== 'running') {
            return response()->json([
                'status' => 'error',
                'output' => 'Service is not running. Please start the service first.'
            ]);
        }

        try {
            $this->ssh->connect($service->server);

            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";
            $userCommand = $request->input('command');

            // --- LOGIC PENENTUAN TARGET CONTAINER ---
            // Default target: 'app' (untuk Laravel/Nodejs)
            $targetContainer = 'app';

            // Jika tipe servicenya Database/Service murni
            if ($service->stack->type === 'service') {
                if (str_contains(strtolower($service->stack->slug), 'redis')) {
                    $targetContainer = 'cache'; // Service name di docker-compose Redis
                } else {
                    $targetContainer = 'db';    // Service name di docker-compose Postgres/MySQL/Mongo
                }
            }
            // ----------------------------------------

            // Escape single quote agar command tidak pecah di shell
            $safeCommand = str_replace("'", "'\\''", $userCommand);

            // Command Final: Masuk ke folder -> docker exec ke container -> jalankan perintah
            $fullCmd = "cd {$remotePath} && docker compose exec -T {$targetContainer} sh -c '{$safeCommand}' 2>&1";

            $output = $this->ssh->execute($fullCmd);

            return response()->json([
                'status' => 'success',
                'output' => $output ?: 'Command executed successfully (No output returned).'
            ]);
        } catch (\Exception $e) {
            // Log error asli ke file laravel.log untuk debugging
            Log::error("Console Error: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'output' => "System Error:\n" . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper: Menerjemahkan Error Docker yang Rumit menjadi Manusiawi
     */
    private function parseDockerError($rawError)
    {
        // Ubah ke huruf kecil semua biar gampang dicek
        $err = strtolower($rawError);

        // 1. Port Conflict
        // Cek variasi kalimat error bind port
        if (
            str_contains($err, 'port is already allocated') ||
            str_contains($err, 'address already in use') ||
            str_contains($err, 'bind for')
        ) {

            // Coba ambil angkanya
            preg_match('/:(\d+) failed/', $rawError, $matches);
            $port = $matches[1] ?? '(Unknown Port)';

            return "PORT CONFLICT: Port $port is already in use by another service. Please change the Public Port in 'Edit Service'.";
        }

        // 2. Database Connection
        if (str_contains($err, 'connection refused') || str_contains($err, 'sqlstate')) {
            return "CONNECTION ERROR: Could not connect to the database. Check your DB Host/Password env variables.";
        }

        // 3. Image Pull Error
        if (str_contains($err, 'pull access denied') || str_contains($err, 'manifest for')) {
            return "IMAGE ERROR: Could not pull Docker image. Check version tag or image name.";
        }

        // 4. Default: Tampilkan RAW errornya (dipotong dikit biar gak kepanjangan)
        // Ini penting agar kalau "Unknown Error", user tetep bisa lihat error aslinya apa
        $lines = explode("\n", trim($rawError));
        $lastLines = array_slice($lines, -5); // Ambil 5 baris terakhir

        return "SYSTEM ERROR:\n" . implode("\n", $lastLines);
    }
}
