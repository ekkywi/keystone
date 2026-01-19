@extends("layouts.app")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">
                Dashboard
            </h2>
            <span class="text-slate-300 text-xl font-light">/</span>
            <p class="text-sm text-slate-500 font-medium">
                Overview
            </p>
        </div>

        <div class="flex space-x-3 items-center">
            <a class="bg-white border border-slate-300 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-slate-50 transition shadow-sm h-9 flex items-center" href="https://laravel.com/docs" target="_blank">
                Docs
            </a>

            <a class="bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-slate-800 transition shadow-md flex items-center gap-2 h-9" href="{{ route("projects.create") }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
                New Project
            </a>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-7xl mx-auto space-y-8 pb-12">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition duration-300 group">
                <div class="flex justify-between items-start">
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Projects</span>
                        <span class="text-3xl font-bold text-slate-900 mt-2 font-mono group-hover:text-indigo-600 transition">
                            {{ str_pad($totalProjects, 2, "0", STR_PAD_LEFT) }}
                        </span>
                    </div>
                    <div class="h-10 w-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-indigo-500 h-full rounded-full" style="width: {{ $totalProjects > 0 ? "100%" : "5%" }}"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition duration-300 group">
                <div class="flex justify-between items-start">
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Running Services</span>
                        <span class="text-3xl font-bold text-slate-900 mt-2 font-mono group-hover:text-purple-600 transition">
                            {{ str_pad($activeServices, 2, "0", STR_PAD_LEFT) }}
                        </span>
                    </div>
                    <div class="h-10 w-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    @if ($activeServices > 0)
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs text-emerald-600 font-medium">Operational</span>
                    @else
                        <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                        <span class="text-xs text-slate-400">No activity</span>
                    @endif
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition duration-300 group">
                <div class="flex justify-between items-start">
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">System Health</span>
                        <span class="text-3xl font-bold text-slate-900 mt-2 font-mono group-hover:text-emerald-600 transition">
                            {{ $health }}%
                        </span>
                    </div>
                    <div class="h-10 w-10 rounded-lg {{ $health < 100 ? "bg-amber-50 text-amber-500" : "bg-emerald-50 text-emerald-600" }} flex items-center justify-center group-hover:scale-110 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-[10px] uppercase font-bold px-2 py-1 rounded border {{ $health < 100 ? "bg-amber-50 text-amber-600 border-amber-100" : "bg-emerald-50 text-emerald-600 border-emerald-100" }}">
                        {{ $health < 100 ? "Attention Needed" : "All Systems Normal" }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-4">
                <div class="flex justify-between items-center px-1">
                    <h3 class="font-bold text-slate-800">Recent Projects</h3>
                    @if ($totalProjects > 0)
                        <a class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1 hover:gap-2 transition-all" href="{{ route("projects.index") }}">
                            View All <span aria-hidden="true">&rarr;</span>
                        </a>
                    @endif
                </div>

                @if ($totalProjects == 0)
                    <div class="bg-white rounded-xl border border-dashed border-slate-300 p-12 text-center">
                        <div class="mx-auto w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">No projects yet</h3>
                        <p class="text-slate-500 max-w-sm mx-auto mt-1 mb-6 text-sm">
                            Get started by deploying your first application or database service.
                        </p>
                        <a class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition" href="{{ route("projects.create") }}">
                            Create Project
                        </a>
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="divide-y divide-slate-100">
                            @foreach ($recentProjects as $project)
                                <div class="p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50 transition group">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-50 to-slate-100 text-indigo-600 border border-slate-100 flex items-center justify-center font-bold text-sm shadow-sm">
                                            {{ substr($project->name, 0, 2) }}
                                        </div>

                                        <div>
                                            <a class="font-bold text-slate-800 hover:text-indigo-600 transition block" href="{{ route("projects.show", $project) }}">
                                                {{ $project->name }}
                                            </a>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs text-slate-500 font-medium bg-slate-100 px-2 py-0.5 rounded">
                                                    {{ $project->services_count }} Services
                                                </span>
                                                <span class="text-xs text-slate-400">&bull;</span>
                                                <span class="text-xs text-slate-400">{{ $project->updated_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        {{-- Environment Badge --}}
                                        <span class="hidden sm:inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border 
                                            {{ $project->environment == "production" ? "bg-rose-50 text-rose-600 border-rose-100" : ($project->environment == "staging" ? "bg-amber-50 text-amber-600 border-amber-100" : "bg-emerald-50 text-emerald-600 border-emerald-100") }}">
                                            {{ $project->environment }}
                                        </span>

                                        {{-- Arrow --}}
                                        <a class="text-slate-300 hover:text-indigo-600 p-2 rounded-full hover:bg-indigo-50 transition" href="{{ route("projects.show", $project) }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center px-1">
                    <h3 class="font-bold text-slate-800">Server Nodes</h3>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    @if ($servers->count() > 0)
                        <div class="bg-slate-50/50 border-b border-slate-100 px-4 py-3">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Connected Infrastructure</span>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach ($servers as $server)
                                <div class="px-4 py-3 flex items-center justify-between hover:bg-white transition">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                </svg>
                                            </div>
                                            <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 border-2 border-white"></span>
                                            </span>
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-sm font-bold text-slate-700 truncate w-32">{{ $server->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-mono">{{ $server->ip_address }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="bg-slate-50 px-4 py-2 border-t border-slate-100">
                            <p class="text-[10px] text-center text-slate-400">System metrics updated automatically</p>
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 mb-3">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium text-slate-900">No servers connected</h3>
                            <p class="mt-1 text-xs text-slate-500">Deploy a service to initialize a connection.</p>
                        </div>
                    @endif
                </div>

                <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-xl p-5 text-white shadow-lg shadow-indigo-200">
                    <h4 class="font-bold text-sm mb-1">Did you know?</h4>
                    <p class="text-xs text-indigo-100 leading-relaxed mb-3">
                        You can view live logs from your containers by clicking the "Logs" button inside any running service.
                    </p>
                    <a class="text-xs font-semibold bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded transition inline-block" href="https://laravel.com/docs" target="_blank">
                        Read Documentation
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
