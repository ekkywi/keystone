@extends('layouts.app')

@section('title', 'Edit Project')

@section('header')
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 flex items-center justify-center font-bold text-lg shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-lg text-slate-800 leading-tight">Edit Project: {{ $project->name }}</h2>
                <p class="text-xs text-slate-500">Update general configuration.</p>
            </div>
        </div>
        <a href="{{ route('projects.show', $project) }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Dashboard
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto space-y-8 pb-20">

        {{-- FORM UTAMA --}}
        <form action="{{ route('projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header Card --}}
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Configuration</h3>
                </div>

                <div class="p-6 space-y-6">

                    {{-- Project Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Project Name</label>
                        <input type="text" name="name" required value="{{ old('name', $project->name) }}"
                            class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm px-4 py-3 shadow-sm placeholder:text-slate-300">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm px-4 py-3 shadow-sm placeholder:text-slate-300">{{ old('description', $project->description) }}</textarea>
                    </div>

                    {{-- Environment Selector --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Environment</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            {{-- Production --}}
                            <label class="cursor-pointer">
                                <input type="radio" name="environment" value="production" class="peer sr-only" {{ $project->environment == 'production' ? 'checked' : '' }}>
                                <div class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50 peer-checked:border-rose-500 peer-checked:ring-1 peer-checked:ring-rose-500 peer-checked:bg-rose-50 transition-all opacity-60 peer-checked:opacity-100 grayscale peer-checked:grayscale-0">
                                    <div class="text-xs font-bold uppercase tracking-wider text-rose-600 mb-1">Production</div>
                                    <div class="text-[10px] text-slate-500">Live for end-users</div>
                                </div>
                            </label>

                            {{-- Staging --}}
                            <label class="cursor-pointer">
                                <input type="radio" name="environment" value="staging" class="peer sr-only" {{ $project->environment == 'staging' ? 'checked' : '' }}>
                                <div class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50 peer-checked:border-amber-500 peer-checked:ring-1 peer-checked:ring-amber-500 peer-checked:bg-amber-50 transition-all opacity-60 peer-checked:opacity-100 grayscale peer-checked:grayscale-0">
                                    <div class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">Staging</div>
                                    <div class="text-[10px] text-slate-500">Pre-release testing</div>
                                </div>
                            </label>

                            {{-- Development --}}
                            <label class="cursor-pointer">
                                <input type="radio" name="environment" value="local" class="peer sr-only" {{ $project->environment == 'local' ? 'checked' : '' }}>
                                <div class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50 peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 peer-checked:bg-emerald-50 transition-all opacity-60 peer-checked:opacity-100 grayscale peer-checked:grayscale-0">
                                    <div class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-1">Development</div>
                                    <div class="text-[10px] text-slate-500">Internal experiments</div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Footer Action --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('projects.show', $project) }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition">Cancel</a>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

        {{-- DANGER ZONE (Delete Project) --}}
        <div class="bg-rose-50/50 rounded-2xl border border-rose-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-rose-100 bg-rose-50 flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="font-bold text-rose-700 text-sm uppercase tracking-wide">Danger Zone</h3>
            </div>

            <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h4 class="font-bold text-slate-700 text-sm">Delete this Project</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm">
                        Deleting this project will permanently remove all associated services, deployments, and databases. This action cannot be undone.
                    </p>
                </div>

                {{-- FORM DELETE DENGAN ID UNTUK JS --}}
                <form action="{{ route('projects.destroy', $project) }}" method="POST" id="delete-project-form">
                    @csrf
                    @method('DELETE')
                    
                    {{-- TYPE BUTTON AGAR TIDAK SUBMIT OTOMATIS --}}
                    <button type="button" onclick="confirmDeleteProject()" class="px-5 py-2.5 bg-white border border-rose-200 text-rose-600 text-sm font-bold rounded-xl hover:bg-rose-600 hover:text-white transition shadow-sm whitespace-nowrap">
                        Delete Project
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function confirmDeleteProject() {
            Swal.fire({
                title: 'Delete Project?',
                text: "WARNING: This will permanently delete the project and all its services! This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48', // Rose-600
                cancelButtonColor: '#64748b', // Slate-500
                confirmButtonText: 'Yes, Delete Everything',
                cancelButtonText: 'Cancel',
                heightAuto: false, // Mencegah layout bergeser
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading sebelum submit
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we tear down the infrastructure.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form
                    document.getElementById('delete-project-form').submit();
                }
            })
        }
    </script>
@endpush