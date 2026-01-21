@extends("layouts.app")

@section("title", "Dashboard")

@section("content")
    <div class="max-w-7xl mx-auto space-y-8 pb-12">

        {{-- 1. HERO SECTION --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
                    Welcome back, {{ explode(" ", Auth::user()->name)[0] }}! 👋
                </h2>
                <p class="text-slate-500 text-sm mt-1">Here's what's happening with your infrastructure today.</p>
            </div>
            <div class="flex items-center gap-3">
                <a class="px-4 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-50 hover:text-slate-800 transition shadow-sm" href={{ route("help.index") }} target="_blank">
                    Documentation & Guides
                </a>
                <a class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20 flex items-center gap-2" href="{{ route("projects.create") }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                    New Project
                </a>
            </div>
        </div>

        {{-- 2. STATS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Total Projects --}}
            <div class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/60 shadow-[0_2px_12px_-4px_rgba(6,81,237,0.1)] hover:-translate-y-1 transition-transform duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Projects</p>
                        <h3 class="text-3xl font-bold text-slate-800 mt-2 font-mono">{{ str_pad($totalProjects, 2, "0", STR_PAD_LEFT) }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2 text-xs">
                    <span class="text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-md">+{{ $totalProjects > 0 ? "100%" : "0%" }}</span>
                    <span class="text-slate-400">active deployments</span>
                </div>
            </div>

            {{-- Running Services --}}
            <div class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/60 shadow-[0_2px_12px_-4px_rgba(6,81,237,0.1)] hover:-translate-y-1 transition-transform duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Services Online</p>
                        <h3 class="text-3xl font-bold text-slate-800 mt-2 font-mono">{{ str_pad($activeServices, 2, "0", STR_PAD_LEFT) }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600 relative">
                        <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 border-2 border-white"></span>
                        </span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-full rounded-full" style="width: {{ $totalProjects > 0 ? ($activeServices / ($totalProjects * 2)) * 100 : 0 }}%"></div>
                </div>
            </div>

            {{-- System Health --}}
            <div class="bg-white/60 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/60 shadow-[0_2px_12px_-4px_rgba(6,81,237,0.1)] hover:-translate-y-1 transition-transform duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">System Health</p>
                        <h3 class="text-3xl font-bold text-slate-800 mt-2 font-mono">{{ $health }}%</h3>
                    </div>
                    <div class="p-3 {{ $health < 90 ? "bg-amber-50 text-amber-500" : "bg-blue-50 text-blue-600" }} rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-wide px-2 py-0.5 rounded border {{ $health < 90 ? "bg-amber-50 text-amber-600 border-amber-200" : "bg-blue-50 text-blue-600 border-blue-200" }}">
                        {{ $health < 90 ? "Degraded" : "Operational" }}
                    </span>
                </div>
            </div>
        </div>

        {{-- 3. MAIN CONTENT SPLIT --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT COLUMN: RECENT PROJECTS --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="flex justify-between items-end px-1">
                    <h3 class="font-bold text-slate-800 text-lg">Active Deployments</h3>
                    @if ($totalProjects > 0)
                        <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline" href="{{ route("projects.index") }}">View All Projects &rarr;</a>
                    @endif
                </div>

                @if ($totalProjects == 0)
                    {{-- Empty State --}}
                    <div class="bg-white/50 border border-dashed border-slate-300 rounded-2xl p-12 text-center">
                        <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm ring-1 ring-slate-100">
                            <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">No projects yet</h3>
                        <p class="text-slate-500 text-sm mt-1 mb-6 max-w-xs mx-auto">Your dashboard is looking a bit empty. Let's deploy your first application.</p>
                        <a class="inline-flex items-center px-5 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20" href="{{ route("projects.create") }}">
                            Create First Project
                        </a>
                    </div>
                @else
                    {{-- Project List --}}
                    <div class="space-y-4">
                        @foreach ($recentProjects as $project)
                            <div class="group bg-white rounded-2xl border border-slate-200/60 p-4 hover:shadow-lg hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        {{-- Project Icon --}}
                                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-slate-100 to-white border border-slate-100 flex items-center justify-center font-bold text-lg text-slate-700 shadow-sm group-hover:scale-105 transition-transform">
                                            {{ substr($project->name, 0, 2) }}
                                        </div>

                                        <div>
                                            <div class="flex items-center gap-2">
                                                <a class="font-bold text-slate-800 hover:text-indigo-600 transition" href="{{ route("projects.show", $project) }}">{{ $project->name }}</a>
                                                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wide border 
                                                    {{ $project->environment == "production" ? "bg-rose-50 text-rose-600 border-rose-100" : ($project->environment == "staging" ? "bg-amber-50 text-amber-600 border-amber-100" : "bg-emerald-50 text-emerald-600 border-emerald-100") }}">
                                                    {{ $project->environment }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-3 mt-1">
                                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                    </svg>
                                                    {{ $project->services_count }} Services
                                                </div>
                                                <span class="text-slate-300">•</span>
                                                <span class="text-xs text-slate-400">Updated {{ $project->updated_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Quick Actions --}}
                                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" href="{{ route("projects.show", $project) }}" title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- RIGHT COLUMN: INFRASTRUCTURE --}}
            <div class="space-y-6">

                {{-- Server Nodes --}}
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 text-sm">Server Nodes</h3>
                        <span class="text-[10px] bg-white border border-slate-200 px-2 py-0.5 rounded text-slate-500 font-medium">{{ $servers->count() }} Connected</span>
                    </div>

                    @if ($servers->count() > 0)
                        <div class="divide-y divide-slate-50">
                            @foreach ($servers as $server)
                                <div class="px-5 py-3 hover:bg-slate-50 transition group">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                </svg>
                                            </div>
                                            <span class="absolute -top-0.5 -right-0.5 flex h-2.5 w-2.5">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 ring-2 ring-white"></span>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-slate-700 truncate">{{ $server->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-mono flex items-center gap-1">
                                                {{ $server->ip_address }}
                                            </p>
                                        </div>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded">OK</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center">
                            <p class="text-sm text-slate-500">No servers connected.</p>
                        </div>
                    @endif
                </div>

                {{-- Support / Tip Card --}}
                <div class="relative overflow-hidden rounded-2xl bg-[#0B1120] p-5 text-white shadow-lg">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 h-24 w-24 rounded-full bg-indigo-500 opacity-20 blur-xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-indigo-500/20 text-indigo-300">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </span>
                            <h4 class="text-sm font-bold">Console Access</h4>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed mb-3">
                            You can now run commands like <code class="bg-white/10 px-1 py-0.5 rounded text-indigo-300">php artisan</code> or <code class="bg-white/10 px-1 py-0.5 rounded text-indigo-300">psql</code> directly from the Service Card UI.
                        </p>
                        <a class="text-xs font-semibold text-white hover:text-indigo-300 transition flex items-center gap-1" href="{{ route("projects.index") }}">
                            Try it now <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
