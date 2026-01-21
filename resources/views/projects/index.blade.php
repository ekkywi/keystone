@extends("layouts.app")

@section("title", "Projects")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">My Projects</h2>
            <div class="h-6 w-px bg-slate-200 mx-2"></div>
            <p class="text-sm text-slate-500 font-medium">Manage your applications & services</p>
        </div>

        {{-- BUTTON CREATE: Sekarang Link ke Halaman Create (Bukan Modal lagi) --}}
        <a class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" href="{{ route("projects.create") }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            New Project
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-8 pb-12">

        {{-- GRID LAYOUT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                {{-- CARD PROJECT --}}
                <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300 relative flex flex-col h-full hover:-translate-y-1">

                    {{-- TOP SECTION --}}
                    <div class="p-6 pb-4 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            {{-- Icon --}}
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-100 text-slate-600 flex items-center justify-center font-bold text-lg shadow-sm group-hover:from-indigo-50 group-hover:to-white group-hover:text-indigo-600 transition-colors">
                                {{ substr($project->name, 0, 2) }}
                            </div>

                            {{-- Environment Badge --}}
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border 
                                {{ $project->environment == "production" ? "bg-rose-50 text-rose-600 border-rose-100" : ($project->environment == "staging" ? "bg-amber-50 text-amber-600 border-amber-100" : "bg-emerald-50 text-emerald-600 border-emerald-100") }}">
                                {{ $project->environment }}
                            </span>
                        </div>

                        {{-- Title & Desc --}}
                        <a class="block group/link" href="{{ route("projects.show", $project) }}">
                            <h3 class="font-bold text-slate-800 text-lg mb-2 group-hover/link:text-indigo-600 transition-colors line-clamp-1">
                                {{ $project->name }}
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 min-h-[2.5rem]">
                                {{ $project->description ?? "No description provided for this project." }}
                            </p>
                        </a>
                    </div>

                    {{-- FOOTER / ACTIONS --}}
                    <div class="px-6 py-4 mt-auto border-t border-slate-50 bg-slate-50/50 rounded-b-2xl flex justify-between items-center">

                        {{-- Stats --}}
                        <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            {{ $project->services_count }} Services
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">

                            {{-- EDIT BUTTON (Menuju Halaman Edit) --}}
                            <a class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition" href="{{ route("projects.edit", $project) }}" title="Settings">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </a>

                            {{-- DELETE BUTTON --}}
                            <form action="{{ route("projects.destroy", $project) }}" class="delete-project-form block" method="POST">
                                @csrf @method("DELETE")
                                <button class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition" title="Delete Project" type="submit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                {{-- EMPTY STATE --}}
                <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100 mb-6 relative">
                        <div class="absolute inset-0 bg-indigo-50 rounded-full animate-pulse opacity-50"></div>
                        <svg class="w-10 h-10 text-indigo-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">No projects yet</h3>
                    <p class="text-slate-500 max-w-md mt-2 mb-8 leading-relaxed">
                        Start by creating a project to group your services and databases.
                    </p>
                    <a class="bg-slate-900 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20" href="{{ route("projects.create") }}">
                        Create First Project
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push("scripts")
    // Di bagian paling bawah file resources/views/projects/index.blade.php

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert untuk Konfirmasi Hapus
            document.querySelectorAll('.delete-project-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to delete this project and all its services!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Delete it',
                        focusCancel: true,

                        // --- TAMBAHKAN BARIS INI (PENTING) ---
                        heightAuto: false,
                        // -------------------------------------

                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl',
                            cancelButton: 'rounded-xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
