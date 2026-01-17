<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectService;
use App\Models\Server;
use App\Models\Stack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
