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
        if ($service->project->user_id !== Auth::id()) abort(403);

        $service->update(['status' => 'building']);

        try {
            $composeContent = $this->generator->generateComposeFile($service);

            if (empty($composeContent)) {
                throw new \Exception("YAML Content is EMPTY! Please check the Stack configuration.");
            }

            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";

            $this->ssh->connect($service->server);

            $this->ssh->ensureDirectoryExists($remotePath);
            $this->ssh->uploadFile("{$remotePath}/docker-compose.yml", $composeContent);

            $output = $this->ssh->execute("cd {$remotePath} && docker compose up -d --remove-orphans");

            Log::info("Deployment Output for {$service->name}: " . $output);

            $service->update([
                'status' => 'running',
                'last_deployed_at' => now(),
            ]);

            return back()->with('success', 'Deployment successful! Container is running.');
        } catch (\Exception $e) {
            $service->update(['status' => 'failed']);
            Log::error("Deploy Failed: " . $e->getMessage());

            return back()->with('error', 'Deployment Failed: ' . $e->getMessage());
        }
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
}
