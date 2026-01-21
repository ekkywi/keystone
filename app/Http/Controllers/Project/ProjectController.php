<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\SshService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())
            ->withCount('services')
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'environment' => 'required|in:development,staging,production'
        ]);

        $project = Project::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'environment' => $request->environment
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully. You can now add services.');
    }

    public function show(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this project.');
        }

        $project->load(['services.stack', 'services.server']);

        return view('projects.show', compact('project'));
    }

    public function destroy(Project $project, SshService $ssh)
    {
        if ($project->user_id !== Auth::id()) abort(403);

        $project->load(['services.server']);

        $userServers = \App\Models\Server::where('user_id', Auth::id())->get();

        if ($project->services->count() > 0) {
            $servicesByServer = $project->services->groupBy('server_id');

            foreach ($servicesByServer as $serverId => $services) {
                $server = $services->first()->server;
                $this->cleanupServer($server, $project, $services, $ssh);
            }
        } else {
            Log::info("Project {$project->id} tidak memiliki service. Melakukan scanning ke semua server user.");

            foreach ($userServers as $server) {
                try {
                    $ssh->connect($server);
                    $projectPath = "/var/www/keystone/{$project->id}";

                    $check = $ssh->execute("if [ -d \"{$projectPath}\" ]; then echo 'FOUND'; fi");

                    if (trim($check) === 'FOUND') {
                        Log::info("Folder 'nyangkut' ditemukan di server {$server->name}. Menghapus...");
                        $this->cleanupServer($server, $project, collect([]), $ssh);
                    }
                } catch (\Exception $e) {
                    Log::warning("Gagal scan server {$server->name}: " . $e->getMessage());
                }
            }
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted and resources cleaned up.');
    }

    private function cleanupServer($server, $project, $services, SshService $ssh)
    {
        try {
            $ssh->connect($server);

            foreach ($services as $service) {
                try {
                    $servicePath = "/var/www/keystone/{$project->id}/{$service->id}";
                    $ssh->execute("if [ -d \"$servicePath\" ]; then cd {$servicePath} && docker compose down -v --remove-orphans; fi");
                } catch (\Exception $e) {
                    Log::warning("Gagal stop service {$service->name}: " . $e->getMessage());
                }
            }

            $networkName = "keystone-p{$project->id}-net";
            $ssh->execute("docker network rm {$networkName} || true");

            $projectPath = "/var/www/keystone/{$project->id}";

            if (!empty($project->id) && strlen($projectPath) > 20) {
                $ssh->execute("rm -rf {$projectPath}");
                Log::info("Deleted project path on {$server->name}: {$projectPath}");
            }
        } catch (\Exception $e) {
            Log::error("Cleanup error on server {$server->name}: " . $e->getMessage());
        }
    }
}
