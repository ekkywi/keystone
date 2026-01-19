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

        $servers = $project->services->pluck('server')->unique('id');

        foreach ($project->services as $service) {
            try {
                $remotePath = "/var/www/keystone/{$project->id}/{$service->id}";

                $ssh->connect($service->server);
                $ssh->execute("cd {$remotePath} && docker compose down -v");
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Gagal stop service {$service->name}: " . $e->getMessage());
            }
        }

        foreach ($servers as $server) {
            try {
                $ssh->connect($server);

                $projectPath = "/var/www/keystone/{$project->id}";

                if (empty($project->id) || strlen($projectPath) < 20) {
                    \Illuminate\Support\Facades\Log::error("Safety Block: Mencoba menghapus path yang mencurigakan: {$projectPath}");
                    continue;
                }

                $ssh->removeDirectory($projectPath);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Gagal hapus folder project di server {$server->name}: " . $e->getMessage());
            }
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project and server files deleted successfully.');
    }
}
