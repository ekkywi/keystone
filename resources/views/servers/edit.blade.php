@extends("layouts.app")

@section("header")
    <div class="flex items-center gap-3 h-full">
        <a class="text-slate-400 hover:text-slate-600 transition" href="{{ route("servers.index") }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </a>
        <div class="flex flex-col">
            <h2 class="font-bold text-lg text-slate-800 leading-tight">Edit Server</h2>
            <p class="text-xs text-slate-500 font-mono">{{ $server->name }} ({{ $server->ip_address }})</p>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            <form action="{{ route("servers.update", $server) }}" method="POST">
                @csrf
                @method("PUT")

                <div class="p-8 space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Server Name</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5" name="name" required type="text" value="{{ old("name", $server->name) }}">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">IP Address</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 font-mono" name="ip_address" required type="text" value="{{ old("ip_address", $server->ip_address) }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-2 space-y-1">
                            <label class="block text-sm font-medium text-slate-700">SSH Username</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 font-mono" name="user" required type="text" value="{{ old("user", $server->user) }}">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Port</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 font-mono" name="ssh_port" required type="number" value="{{ old("ssh_port", $server->ssh_port) }}">
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <div class="bg-amber-50 rounded-lg border border-amber-100 p-5">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="p-2 bg-amber-100 rounded-md text-amber-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-amber-900">Update SSH Key</h4>
                                    <p class="text-xs text-amber-700 mt-0.5">Leave this field blank if you want to keep the current private key.</p>
                                </div>
                            </div>

                            <textarea class="block w-full rounded-lg border-amber-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-xs px-4 py-2.5 font-mono bg-white placeholder-slate-400" name="private_key" placeholder="-----BEGIN OPENSSH PRIVATE KEY-----
(Only paste here if you want to replace the existing key)" rows="6"></textarea>
                        </div>
                    </div>

                </div>

                <div class="px-8 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
                    <a class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg" href="{{ route("servers.index") }}">Cancel</a>
                    <button class="bg-slate-900 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20" type="submit">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
