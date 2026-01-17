@extends("layouts.app")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">My Projects</h2>
            <p class="text-sm text-slate-500 font-medium border-l border-slate-300 pl-3">Active Environments</p>
        </div>
        <button class="bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20 flex items-center gap-2" onclick="document.getElementById('createProjectModal').showModal()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            New Project
        </button>
    </div>
@endsection

@section("content")
    <div class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                <a class="group block bg-white rounded-xl border border-slate-200 shadow-sm hover:border-indigo-400 hover:shadow-md hover:shadow-indigo-500/10 transition duration-200 relative overflow-hidden" href="{{ route("projects.show", $project) }}">

                    <div class="absolute top-0 inset-x-0 h-1 
                        {{ $project->environment == "production" ? "bg-rose-500" : ($project->environment == "staging" ? "bg-amber-400" : "bg-emerald-400") }}">
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="h-10 w-10 rounded-lg bg-slate-50 text-slate-600 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>

                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md border 
                                {{ $project->environment == "production" ? "bg-rose-50 text-rose-700 border-rose-100" : ($project->environment == "staging" ? "bg-amber-50 text-amber-700 border-amber-100" : "bg-emerald-50 text-emerald-700 border-emerald-100") }}">
                                {{ $project->environment }}
                            </span>
                        </div>

                        <h3 class="font-bold text-slate-800 text-lg mb-1 group-hover:text-indigo-600 transition">{{ $project->name }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed h-10">
                            {{ $project->description ?? "No description provided." }}
                        </p>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/50 flex justify-between items-center text-xs text-slate-500">
                        <span class="flex items-center gap-1.5 font-medium">
                            <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                            {{ $project->services_count }} Services
                        </span>
                        <span class="font-mono">{{ $project->created_at->format("d M Y") }}</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">No projects yet</h3>
                    <p class="text-slate-500 max-w-sm mt-1 mb-6">Create a project to start deploying your applications and databases.</p>
                    <button class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition" onclick="document.getElementById('createProjectModal').showModal()">
                        Create Project
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <dialog class="m-auto rounded-2xl shadow-2xl p-0 w-full max-w-md backdrop:bg-slate-900/50 backdrop:backdrop-blur-sm open:animate-fade-in" id="createProjectModal">
        <div class="bg-white p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800">New Project</h3>
                <button class="text-slate-400 hover:text-slate-600 transition" onclick="document.getElementById('createProjectModal').close()" type="button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>
            </div>

            <form action="{{ route("projects.store") }}" class="space-y-4" method="POST">
                @csrf
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700">Project Name</label>
                    <input class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5" name="name" placeholder="e.g. Corporate Website" required type="text">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700">Environment</label>
                    <select class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5" name="environment">
                        <option value="development">Development (Dev)</option>
                        <option value="staging">Staging (Test)</option>
                        <option value="production">Production (Live)</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700">Description</label>
                    <textarea class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5" name="description" placeholder="Optional brief description..." rows="3"></textarea>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition" onclick="document.getElementById('createProjectModal').close()" type="button">Cancel</button>
                    <button class="bg-slate-900 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20" type="submit">Create Project</button>
                </div>
            </form>
        </div>
    </dialog>
@endsection

@push("styles")
    <style>
        /* Animasi Modal Sederhana */
        dialog[open] {
            animation: slide-up 0.3s ease-out;
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush
