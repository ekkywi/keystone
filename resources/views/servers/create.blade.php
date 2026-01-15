@extends("layouts.app")

@section("header")
    <div class="flex items-center gap-3 h-full">
        <a class="text-slate-400 hover:text-slate-600 transition" href="{{ route("servers.index") }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </a>
        <h2 class="font-bold text-lg text-slate-800">Connect New Server</h2>
    </div>
@endsection

@section("content")
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route("servers.store") }}" method="POST">
                @csrf
                <div class="p-8 space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Server Name</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5" name="name" placeholder="e.g. Production Database" required type="text">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">IP Address</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 font-mono" name="ip_address" placeholder="e.g. 159.203.x.x" required type="text">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-2 space-y-1">
                            <label class="block text-sm font-medium text-slate-700">SSH Username</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 font-mono" name="user" required type="text" value="root">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Port</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 font-mono" name="ssh_port" required type="number" value="22">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between">
                            <label class="block text-sm font-medium text-slate-700">SSH Private Key</label>
                            <span class="text-xs text-slate-400">Stored with AES-256 encryption</span>
                        </div>
                        <textarea class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs px-4 py-2.5 font-mono bg-slate-50" name="private_key" placeholder="-----BEGIN OPENSSH PRIVATE KEY-----
..." required rows="8"></textarea>
                        <p class="text-xs text-slate-500">Paste your private key here. Ensure the public key is added to <code>~/.ssh/authorized_keys</code> on the target server.</p>
                    </div>

                </div>

                <div class="px-8 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
                    <a class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg" href="{{ route("servers.index") }}">Cancel</a>
                    <button class="bg-slate-900 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20" type="submit">
                        Connect Server
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
