<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceOperationController extends Controller
{
    public function deploy(ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        $service->update([
            'status' => 'building'
        ]);

        sleep(1);

        $service->update([
            'status' => 'running'
        ]);

        return back()->with('success', 'Deployment started for ' . $service->name);
    }

    public function stop(ProjectService $service)
    {
        if ($service->project->user_id !== Auth::id()) abort(403);

        $service->update([
            'status' => 'stopped'
        ]);

        return back()->with('success', 'Service stopped');
    }
}
