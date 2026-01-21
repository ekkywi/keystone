<?php

namespace App\Http\Controllers\Infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Server;
use App\Services\SshService;
use Illuminate\Http\JsonResponse;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::where('user_id', Auth::id())->latest()->paginate(10);
        return view('servers.index', compact('servers'));
    }

    public function create()
    {
        return view('servers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ipv4',
            'user' => 'required|string|max:50',
            'ssh_port' => 'required|numeric|min:1|max:65535',
            'private_key' => 'required|string',
            'description' => 'nullable|string|max:500',
        ]);

        Server::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'ip_address' => $request->ip_address,
            'user' => $request->user,
            'ssh_port' => $request->ssh_port,
            'private_key' => $request->private_key,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('servers.index')->with('success', 'Server registered successfully');
    }

    public function edit(Server $server)
    {
        if ($server->user_id !== Auth::id()) {
            abort(403);
        }

        return view('servers.edit', compact('server'));
    }

    public function update(Request $request, Server $server)
    {
        if ($server->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ipv4',
            'user' => 'required|string|max:50',
            'ssh_port' => 'required|numeric|min:1|max:65535',
            'description' => 'nullable|string|max:500',
        ]);

        $data = $request->only([
            'name',
            'ip_address',
            'user',
            'ssh_port',
            'description'
        ]);

        if ($request->filled('private_key')) {
            $data['private_key'] = $request->private_key;
        }

        $server->update($data);

        return redirect()->route('servers.index')->with('success', 'Server updated successfully.');
    }

    public function destroy(Server $server)
    {
        if ($server->user_id !== Auth::id()) {
            abort(403);
        }

        if ($server->services()->exists()) {
            $count = $server->services()->count();
            return back()->with('error', "Cannot disconnect this server. It is currently being used by {$count} active service(s). Please delete the services in your Projects first.");
        }

        $server->delete();

        return redirect()->route('servers.index')->with('success', 'Server removed from inventory');
    }

    public function testConnection(Server $server): JsonResponse
    {
        try {
            $ssh = new SshService();
            $ssh->connect($server);

            // Jalankan beberapa command diagnostic
            $user = trim($ssh->execute('whoami'));
            $docker = trim($ssh->execute('docker -v'));
            $disk = trim($ssh->execute("df -h / | tail -1 | awk '{print $5}'")); // Cek penggunaan disk root
            $uptime = trim($ssh->execute("uptime -p"));

            return response()->json([
                'status' => 'success',
                'server_name' => $server->name,
                'details' => [
                    'User' => $user,
                    'Docker Version' => $docker,
                    'Disk Usage' => $disk,
                    'Uptime' => $uptime,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
