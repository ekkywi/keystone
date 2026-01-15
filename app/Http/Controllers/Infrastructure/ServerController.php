<?php

namespace App\Http\Controllers\Infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Server;

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
        ]);

        Server::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'ip_address' => $request->ip_address,
            'user' => $request->user,
            'ssh_port' => $request->ssh_port,
            'private_key' => $request->private_key,
            'status' => 'active',
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
            'ssh_port' => 'required|numeric',
        ]);

        $data = $request->only([
            'name',
            'ip_address',
            'user',
            'ssh_port'
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

        $server->delete();

        return redirect()->route('servers.index')->with('success', 'Server removed from inventory');
    }
}
