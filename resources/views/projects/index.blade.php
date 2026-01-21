@extends("layouts.app")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">My Projects</h2>
            <div class="h-6 w-px bg-slate-300 mx-2"></div>
            <p class="text-sm text-slate-500 font-medium">Dashboard & Overview</p>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" onclick="document.getElementById('createProjectModal').showModal()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" /></svg>
            New Project
        </button>
    </div>
@endsection

@section("content")
    <div class="space-y-8">

        {{-- GRID LAYOUT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                {{-- CARD PROJECT (Clickable) --}}
                <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300 relative overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                    
                    {{-- LINK WRAPPER (Body Only) --}}
                    <a class="block flex-1 p-6 pb-2" href="{{ route("projects.show", $project) }}">
                        
                        {{-- STATUS BAR (Top Indicator) --}}
                        <div class="absolute top-0 inset-x-0 h-1.5 transition-colors duration-300 
                            {{ $project->environment == 'production' ? 'bg-rose-500 group-hover:bg-rose-600' : 
                              ($project->environment == 'staging' ? 'bg-amber-400 group-hover:bg-amber-500' : 
                              'bg-emerald-400 group-hover:bg-emerald-500') }}">
                        </div>

                        {{-- HEADER --}}
                        <div class="flex justify-between items-start mb-4">
                            <div class="h-12 w-12 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors duration-300 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" /></svg>
                            </div>

                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border shadow-sm transition-colors duration-300
                                {{ $project->environment == 'production' ? 'bg-rose-50 text-rose-700 border-rose-100 group-hover:border-rose-200' : 
                                  ($project->environment == 'staging' ? 'bg-amber-50 text-amber-700 border-amber-100 group-hover:border-amber-200' : 
                                  'bg-emerald-50 text-emerald-700 border-emerald-100 group-hover:border-emerald-200') }}">
                                {{ $project->environment }}
                            </span>
                        </div>

                        {{-- TITLE & DESC --}}
                        <h3 class="font-bold text-slate-800 text-lg mb-2 group-hover:text-indigo-600 transition-colors duration-300 line-clamp-1">{{ $project->name }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 min-h-[2.5rem]">
                            {{ $project->description ?? "A reliable environment for your applications." }}
                        </p>
                    </a>

                    {{-- STATS FOOTER --}}
                    <div class="px-6 py-4 mt-2 border-t border-slate-50 bg-slate-50/50 flex justify-between items-center text-xs text-slate-500 rounded-b-2xl group-hover:bg-slate-50 transition-colors">
                        
                        <div class="flex items-center gap-4">
                            {{-- Services Count --}}
                            <div class="flex items-center gap-1.5" title="Total Services">
                                <div class="w-2 h-2 rounded-full {{ $project->services_count > 0 ? 'bg-indigo-500' : 'bg-slate-300' }}"></div>
                                <span class="font-medium text-slate-600">{{ $project->services_count }} Services</span>
                            </div>
                            
                            {{-- Created At --}}
                            <div class="flex items-center gap-1.5" title="Created At">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <span class="font-mono">{{ $project->created_at->format("M d, Y") }}</span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 border-l border-slate-200 pl-3 ml-3">
                            <form action="{{ route("projects.destroy", $project) }}" class="delete-project-form block" method="POST">
                                @csrf @method("DELETE")
                                <button class="text-slate-400 hover:text-rose-600 transition p-1 rounded-md hover:bg-rose-50" title="Delete Project" type="submit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                {{-- EMPTY STATE (Modern) --}}
                <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-white rounded-3xl border border-dashed border-slate-300 shadow-sm">
                    <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center shadow-inner mb-6 ring-1 ring-slate-100">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">No projects found</h3>
                    <p class="text-slate-500 max-w-md mt-2 mb-8 leading-relaxed">
                        Your workspace is clean. Create your first project to start organizing your services, databases, and deployments.
                    </p>
                    <button class="bg-indigo-600 text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 transform hover:-translate-y-0.5 active:translate-y-0" onclick="document.getElementById('createProjectModal').showModal()">
                        Create New Project
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- MODAL CREATE PROJECT --}}
    <dialog class="m-auto rounded-2xl shadow-2xl p-0 w-full max-w-lg backdrop:bg-slate-900/60 backdrop:backdrop-blur-[2px] open:animate-fade-in" id="createProjectModal">
        <div class="bg-white overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-bold text-lg text-slate-800">New Project</h3>
                <button class="text-slate-400 hover:text-slate-600 transition p-1 rounded-md hover:bg-slate-100" onclick="document.getElementById('createProjectModal').close()" type="button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form action="{{ route("projects.store") }}" class="p-6 space-y-5" method="POST">
                @csrf
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Project Name <span class="text-rose-500">*</span></label>
                    <input class="block w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm px-4 py-3 shadow-sm transition" name="name" placeholder="e.g. My Awesome App" required type="text">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Environment <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="environment" value="development" class="peer sr-only" checked>
                            <div class="rounded-xl border border-slate-200 p-3 text-center transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 hover:bg-slate-50">
                                <span class="block text-xs font-bold uppercase">Dev</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="environment" value="staging" class="peer sr-only">
                            <div class="rounded-xl border border-slate-200 p-3 text-center transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 hover:bg-slate-50">
                                <span class="block text-xs font-bold uppercase">Staging</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="environment" value="production" class="peer sr-only">
                            <div class="rounded-xl border border-slate-200 p-3 text-center transition-all peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 hover:bg-slate-50">
                                <span class="block text-xs font-bold uppercase">Prod</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Description</label>
                    <textarea class="block w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm px-4 py-3 shadow-sm transition resize-none" name="description" placeholder="Short description about this project..." rows="3"></textarea>
                </div>

                <div class="pt-2 flex justify-end gap-3">
                    <button class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition" onclick="document.getElementById('createProjectModal').close()" type="button">Cancel</button>
                    <button class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20" type="submit">Create Project</button>
                </div>
            </form>
        </div>
    </dialog>
@endsection

@push("styles")
    <style>
        dialog[open] { animation: modal-pop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        @keyframes modal-pop {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
@endpush

@push("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete Confirmation
            document.querySelectorAll('.delete-project-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Delete Project?',
                        text: "WARNING: This will permanently delete the project and all its services!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Delete All',
                        cancelButtonText: 'Cancel',
                        focusCancel: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({ title: 'Deleting...', text: 'Please wait.', showConfirmButton: false, allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush