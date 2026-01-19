<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectService;
use App\Models\Server;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalProjects = Project::where('user_id', $user->id)->count();

        $services = ProjectService::whereHas('project', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        $activeServices = $services->where('status', 'running')->count();
        $totalServices = $services->count();
        $failedServices = $services->where('status', 'failed')->count();

        if ($totalServices > 0) {
            $health = round((($totalServices - $failedServices) / $totalServices) * 100);
        } else {
            $health = 100;
        }

        $recentProjects = Project::where('user_id', $user->id)
            ->withCount('services')
            ->latest()
            ->take(5)
            ->get();

        $servers = Server::whereHas('services.project', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->distinct()->get();

        return view('dashboard.index', compact(
            'totalProjects',
            'activeServices',
            'health',
            'recentProjects',
            'servers'
        ));
    }
}
