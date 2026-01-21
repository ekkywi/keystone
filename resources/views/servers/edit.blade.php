@extends("layouts.app")

@section("title", "Edit Server")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-4">
            {{-- Back Button --}}
            <a class="group p-2 rounded-xl border border-transparent hover:bg-white hover:border-slate-200 text-slate-400 hover:text-slate-600 transition shadow-sm hover:shadow" href="{{ route("servers.index") }}">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </a>

            <div class="h-8 w-px bg-slate-200"></div>

            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 text-violet-600 flex items-center justify-center font-bold text-sm shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 01-2 2v4a2 2 0 012 2h14a2 2 0 012-2v-4a2 2 0 01-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-slate-800 tracking-tight">Edit Server</h2>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $server->name }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-4xl mx-auto pb-20">

        <form action="{{ route("servers.update", $server) }}" method="POST">
            @csrf
            @method("PUT")

            <div class="space-y-8">

                {{-- 1. SERVER CONFIGURATION --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">1. Server Configuration</h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Server Name --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Server Name</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all placeholder:text-slate-300" name="name" required type="text" value="{{ old("name", $server->name) }}">
                        </div>

                        {{-- IP Address --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">IP Address</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </span>
                                <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm pl-10 pr-4 py-3 shadow-sm transition-all font-mono text-slate-600" name="ip_address" required type="text" value="{{ old("ip_address", $server->ip_address) }}">
                            </div>
                        </div>

                        {{-- Username & Port --}}
                        <div class="col-span-2 grid grid-cols-3 gap-6">
                            <div class="col-span-2">
                                <label class="block text-xs font-bold uppercase text-slate-500 mb-2">SSH Username</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </span>
                                    <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm pl-10 pr-4 py-3 shadow-sm transition-all font-mono text-slate-600" name="user" required type="text" value="{{ old("user", $server->user) }}">
                                </div>
                            </div>
                            <div class="col-span-1">
                                <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Port</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </span>
                                    <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm pl-10 pr-4 py-3 shadow-sm transition-all font-mono text-slate-600" name="ssh_port" required type="number" value="{{ old("ssh_port", $server->ssh_port) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Description</label>
                            <textarea class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all placeholder:text-slate-300" name="description" rows="2">{{ old("description", $server->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- 2. SECURITY CARD (Update Key) --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 17l-3.21 3.21a1.207 1.207 0 01-1.707 0L4.5 18.093a1.207 1.207 0 010-1.707l3.21-3.21A6 6 0 0118 9a2.015 2.015 0 011.035.291z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">2. Security Update</h3>
                        </div>
                        <div class="px-2 py-1 bg-amber-50 border border-amber-100 rounded text-[10px] text-amber-700 font-bold">
                            Optional
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="mb-4 bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            <div class="text-xs text-slate-600 leading-relaxed">
                                <p class="font-bold text-slate-800 mb-1">Update Instructions:</p>
                                Leave the field below <strong>blank</strong> if you want to keep using the currently stored Private Key. Only paste a new key if you have rotated your SSH credentials.
                            </div>
                        </div>

                        <label class="block text-xs font-bold uppercase text-slate-500 mb-2">New SSH Private Key</label>
                        <div class="relative group">
                            <textarea class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-xs px-4 py-4 shadow-inner font-mono bg-slate-900 text-slate-300 leading-relaxed transition-all placeholder:text-slate-600" name="private_key" placeholder="-----BEGIN OPENSSH PRIVATE KEY-----&#10;(Leave blank to keep existing key)" rows="8"></textarea>
                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-[10px] text-slate-500 bg-slate-800 px-2 py-1 rounded border border-slate-700">Paste new key here</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition" href="{{ route("servers.index") }}">Cancel</a>
                    <button class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" type="submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                        Save Changes
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
