<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\ProjectService;
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

    public function deploy(ProjectService $service)
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        if ($service->project->user_id !== auth()->id()) abort(403);

        $service->update(['status' => 'building']);

        try {
            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";

            $this->ssh->connect($service->server);
            $this->ssh->ensureDirectoryExists($remotePath);

            $networkName = "keystone-p{$service->project_id}-net";
            $this->ssh->execute("docker network create {$networkName} || true");

            if ($service->stack->type === 'application') {
                $this->handleApplicationSetup($service, $remotePath);
            }

            $composeContent = $this->generator->generateComposeFile($service);
            $this->ssh->uploadFile("{$remotePath}/docker-compose.yml", $composeContent);

            $output = $this->ssh->execute("cd {$remotePath} && docker compose up -d --build --remove-orphans");

            $service->update(['status' => 'running', 'last_deployed_at' => now()]);
            return back()->with('success', 'Service deployed successfully.');
        } catch (\Exception $e) {
            $service->update(['status' => 'failed']);
            Log::error("Deploy Failed: " . $e->getMessage());
            return back()->with('error', 'Deploy failed: ' . $e->getMessage());
        }
    }

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

        $checkGit = $this->ssh->execute("if [ -d \"{$codePath}/.git\" ]; then echo 'EXISTS'; else echo 'NO'; fi");

        if (trim($checkGit) === 'EXISTS') {
            $safeBranch = escapeshellarg($branch);
            $this->ssh->execute("cd {$codePath} && git fetch origin && git reset --hard origin/{$safeBranch}");
        } else {
            $this->ssh->execute("rm -rf {$codePath}");
            $safeRepo = escapeshellarg($repoUrl);
            $safeBranch = escapeshellarg($branch);
            $this->ssh->execute("git clone --branch {$safeBranch} {$safeRepo} {$codePath}");
        }

        $this->ssh->execute("chmod -R 777 {$codePath}/storage {$codePath}/bootstrap/cache || true");
    }

    public function stop(ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        try {
            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";
            $this->ssh->connect($service->server);
            $this->ssh->execute("cd {$remotePath} && docker compose down");
            $service->update(['status' => 'stopped']);

            return back()->with('success', 'Service stopped successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Stop Failed: ' . $e->getMessage());
        }
    }

    public function logs(ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        try {
            $service->load('server');
            if (!$service->server) {
                return response()->json([
                    'status' => 'error',
                    'logs' => "CRITICAL ERROR: Server data missing."
                ]);
            }

            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";
            $this->ssh->connect($service->server);
            $output = $this->ssh->execute("cd {$remotePath} && docker compose logs --tail=100 2>&1");

            return response()->json([
                'status' => 'success',
                'logs' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'logs' => 'System Error: ' . $e->getMessage()
            ]);
        }
    }

    public function refreshStatus(ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        try {
            $service->load('server');
            if (!$service->server) {
                return response()->json(['status' => 'error', 'message' => 'Server not found.'], 404);
            }

            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";
            $this->ssh->connect($service->server);

            try {
                $output = $this->ssh->execute("cd {$remotePath} && docker compose ps --format \"{{.State}}\"");
            } catch (\Exception $e) {
                $service->update(['status' => 'stopped']);
                return response()->json([
                    'status' => 'success',
                    'new_status' => 'stopped',
                    'message' => 'Service not found on server.'
                ]);
            }

            $newStatus = str_contains(strtolower($output), 'running') ? 'running' : 'stopped';
            $service->update(['status' => $newStatus]);

            return response()->json([
                'status' => 'success',
                'new_status' => $newStatus,
                'message' => 'Status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
