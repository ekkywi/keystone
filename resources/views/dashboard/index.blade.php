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
             <button class="bg-white border border-slate-300 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-slate-50 transition shadow-sm h-9">
                Docs
            </button>
             <button class="bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-slate-800 transition shadow-md flex items-center gap-2 h-9">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Project
            </button>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:border-indigo-300 transition duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Projects</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2 font-mono group-hover:text-indigo-600 transition">0</h3>
                    </div>
                    <div class="p-2.5 bg-slate-50 text-slate-400 rounded-lg group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: 5%"></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:border-purple-300 transition duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Deployments</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2 font-mono group-hover:text-purple-600 transition">0</h3>
                    </div>
                    <div class="p-2.5 bg-slate-50 text-slate-400 rounded-lg group-hover:bg-purple-50 group-hover:text-purple-600 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-slate-500 mt-2">
                    <span class="w-2 h-2 bg-slate-300 rounded-full mr-2"></span> No runners active
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:border-emerald-300 transition duration-300 group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">System Health</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2 font-mono text-emerald-600">100%</h3>
                    </div>
                    <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-lg">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <div class="text-xs text-emerald-600 font-medium bg-emerald-50 inline-block px-2 py-1 rounded">
                    All Systems Operational
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col items-center justify-center p-16 text-center">

            <div class="h-20 w-20 bg-slate-50 rounded-full flex items-center justify-center mb-6 ring-8 ring-slate-50">
                <svg class="h-10 w-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                </svg>
            </div>

            <h3 class="text-lg font-bold text-slate-900">No Projects Found</h3>
            <p class="text-slate-500 max-w-sm mx-auto mt-2 mb-8">
                Your dashboard is looking a bit empty. Start by creating a project to configure your first runner pipeline.
            </p>

            <div class="flex space-x-4">
                <button class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-lg shadow-indigo-500/30">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                    Create Project
                </button>
                <button class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-300 rounded-lg font-semibold text-sm text-slate-700 hover:bg-slate-50 focus:outline-none transition">
                    Learn more
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-semibold text-slate-800 text-sm">Runner Status</h3>
                <span class="text-xs text-slate-500">Last checked: Just now</span>
            </div>
            <div class="divide-y divide-slate-100">
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
                    <div class="flex items-center space-x-3">
                        <div class="h-2.5 w-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-50"></div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Worker-01 (General)</p>
                            <p class="text-xs text-slate-500 font-mono">ID: runner-pool-1</p>
                        </div>
                    </div>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600">Idle</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
                    <div class="flex items-center space-x-3">
                        <div class="h-2.5 w-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-50"></div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Worker-02 (General)</p>
                            <p class="text-xs text-slate-500 font-mono">ID: runner-pool-2</p>
                        </div>
                    </div>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600">Idle</span>
                </div>
            </div>
        </div>

    </div>
@endsection
