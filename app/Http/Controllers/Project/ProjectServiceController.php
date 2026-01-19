<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectService;
use App\Models\Server;
use App\Models\Stack;
use App\Services\SshService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectServiceController extends Controller
{
    public function create(Project $project)
    {
        if ($project->user_id !== Auth::id()) abort(403);

        $servers = Server::where('is_active', true)->get();
        $stacks = Stack::where('is_active', true)->with('variables')->get();

        return view('projects.services.create', compact('project', 'servers', 'stacks'));
    }

    public function store(Request $request, Project $project)
    {
        if ($project->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'stack_id' => 'required|exists:stacks,id',
            'server_id' => 'required|exists:servers,id',
        ]);

        $inputVariables = $request->input('vars', []);

        $detectedPort = null;
        if (isset($inputVariables['PUBLIC_PORT'])) {
            $detectedPort = $inputVariables['PUBLIC_PORT'];
        } elseif (isset($inputVariables['PORT'])) {
            $detectedPort = $inputVariables['PORT'];
        }

        $project->services()->create([
            'name' => $request->name,
            'stack_id' => $request->stack_id,
            'server_id' => $request->server_id,
            'input_variables' => $inputVariables,
            'public_port' => $detectedPort,
            'status' => 'stopped',
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Service added successfully. Ready to deploy.');
    }

    public function edit(ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        $service->load(['stack.variables', 'server']);

        return view('projects.services.edit', compact('service'));
    }

    public function update(Request $request, ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $inputVariables = $request->input('vars', []);

        $detectedPort = null;
        if (isset($inputVariables['PUBLIC_PORT'])) {
            $detectedPort = $inputVariables['PUBLIC_PORT'];
        } elseif (isset($inputVariables['PORT'])) {
            $detectedPort = $inputVariables['PORT'];
        }

        $service->update([
            'name' => $request->name,
            'input_variables' => $inputVariables,
            'public_port' => $detectedPort ?? $service->public_port,
        ]);

        return redirect()->route('projects.show', $service->project)
            ->with('success', 'Service updated. Please Redeploy to apply changes.');
    }

    public function destroy(ProjectService $service, SshService $ssh)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        try {
            $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', str_replace(' ', '-', strtolower($service->name)));
            $remotePath = "/var/www/keystone/{$service->project->id}/{$service->id}";

            try {
                $ssh->connect($service->server);

                $ssh->execute("cd {$remotePath} && docker compose down -v");

                $ssh->removeDirectory($remotePath);
            } catch (\Exception $e) {
                Log::warning("Failed to cleanup server files for {$service->name}: " . $e->getMessage());
                session()->flash('warning', 'Service deleted from dashboard, but server cleanup failed (Check server connection).');
            }

            $service->delete();

            return back()->with('success', 'Service removed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting service: ' . $e->getMessage());
        }
    }
}
