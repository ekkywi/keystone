@extends("layouts.app")

@section("title", "Create Project")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-sm shadow-indigo-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-lg text-slate-800 leading-tight">Create New Project</h2>
                <p class="text-xs text-slate-500">Initialize a new environment for your applications.</p>
            </div>
        </div>
        <a class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition flex items-center gap-1" href="{{ route("projects.index") }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Back to Projects
        </a>
    </div>
@endsection

@section("content")
    <div class="max-w-2xl mx-auto pb-20">

        <form action="{{ route("projects.store") }}" method="POST">
            @csrf

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Header Card --}}
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Project Details</h3>
                </div>

                <div class="p-6 space-y-6">

                    {{-- Project Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Project Name</label>
                        <input class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm px-4 py-3 shadow-sm placeholder:text-slate-300" name="name" placeholder="e.g. E-Commerce API, Marketing Site" required type="text">
                        <p class="text-xs text-slate-400 mt-2">A unique name to identify your project dashboard.</p>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Description <span class="text-slate-400 font-normal">(Optional)</span></label>
                        <textarea class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm px-4 py-3 shadow-sm placeholder:text-slate-300" name="description" placeholder="Briefly describe the purpose of this project..." rows="3"></textarea>
                    </div>

                    {{-- Environment --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Environment</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            {{-- Production --}}
                            <label class="cursor-pointer">
                                <input checked class="peer sr-only" name="environment" type="radio" value="production">
                                <div class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50 peer-checked:border-rose-500 peer-checked:ring-1 peer-checked:ring-rose-500 peer-checked:bg-rose-50 transition-all">
                                    <div class="text-xs font-bold uppercase tracking-wider text-rose-600 mb-1">Production</div>
                                    <div class="text-[10px] text-slate-500">Live for end-users</div>
                                </div>
                            </label>

                            {{-- Staging --}}
                            <label class="cursor-pointer">
                                <input class="peer sr-only" name="environment" type="radio" value="staging">
                                <div class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50 peer-checked:border-amber-500 peer-checked:ring-1 peer-checked:ring-amber-500 peer-checked:bg-amber-50 transition-all">
                                    <div class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">Staging</div>
                                    <div class="text-[10px] text-slate-500">Pre-release testing</div>
                                </div>
                            </label>

                            {{-- Development --}}
                            <label class="cursor-pointer">
                                <input class="peer sr-only" name="environment" type="radio" value="local">
                                <div class="rounded-xl border border-slate-200 p-4 hover:bg-slate-50 peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 peer-checked:bg-emerald-50 transition-all">
                                    <div class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-1">Development</div>
                                    <div class="text-[10px] text-slate-500">Internal experiments</div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Footer Action --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition" href="{{ route("projects.index") }}">Cancel</a>
                    <button class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20" type="submit">
                        Create Project
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
