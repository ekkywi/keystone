<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->with('success', 'Service added successfully. Ready to deploy.');
    }

    public function show(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this project.');
        }

        $project->load(['services.stack', 'services.server']);

        return view('projects.show', compact('project'));
    }
}
