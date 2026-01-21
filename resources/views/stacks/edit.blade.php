@extends('layouts.app')

@section('title', 'Edit Stack Template')

@section('header')
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('stacks.index') }}" class="group p-2 rounded-xl border border-transparent hover:bg-white hover:border-slate-200 text-slate-400 hover:text-slate-600 transition shadow-sm hover:shadow">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div class="h-8 w-px bg-slate-200"></div>
            <div>
                <h2 class="font-bold text-xl text-slate-800 tracking-tight">Edit Stack</h2>
                <p class="text-xs text-slate-500 mt-0.5">{{ $stack->name }}</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto pb-20">

        <form action="{{ route('stacks.update', $stack) }}" id="stackForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-8">

                {{-- 1. STACK IDENTITY --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">1. Stack Identity</h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Stack Name</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all" 
                                   name="name" required type="text" value="{{ old('name', $stack->name) }}">
                        </div>

                        {{-- Type (DIPERBAIKI) --}}
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Service Type</label>
                            <div class="relative">
                                <select class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all appearance-none bg-white cursor-pointer" name="type">
                                    <option value="application" {{ $stack->type == 'application' ? 'selected' : '' }}>Application (Node, PHP, Python)</option>
                                    <option value="database" {{ $stack->type == 'database' ? 'selected' : '' }}>Database (MySQL, Postgres)</option>
                                    <option value="cache" {{ $stack->type == 'cache' ? 'selected' : '' }}>Cache (Redis, Memcached)</option>
                                    <option value="service" {{ $stack->type == 'service' ? 'selected' : '' }}>Service (Generic/Other)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Description</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all" 
                                   name="description" type="text" value="{{ old('description', $stack->description) }}">
                        </div>
                    </div>
                </div>

                {{-- 2. DOCKER COMPOSE --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                            </div>
                            <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">2. Docker Compose Template</h3>
                        </div>
                    </div>
                    <div class="p-0">
                        <textarea class="block w-full bg-[#1e293b] text-slate-300 font-mono text-xs leading-relaxed p-6 focus:outline-none focus:ring-0 border-0 resize-y" 
                                  name="raw_compose_template" rows="16" spellcheck="false">{{ old('raw_compose_template', $stack->raw_compose_template) }}</textarea>
                    </div>
                </div>

                {{-- 3. INPUT VARIABLES --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                            </div>
                            <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">3. Input Variables</h3>
                        </div>
                        <button class="text-xs bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition flex items-center gap-1 shadow-md shadow-indigo-200" onclick="addVariableRow()" type="button">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Variable
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[10px] font-bold text-slate-400 uppercase border-b border-slate-100 bg-slate-50/30">
                                    <th class="py-3 px-6 w-1/4">Label</th>
                                    <th class="py-3 px-6 w-1/4">ENV Key</th>
                                    <th class="py-3 px-6 w-1/6">Type</th>
                                    <th class="py-3 px-6 w-1/4">Default / Options</th>
                                    <th class="py-3 px-4 w-10 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="text-sm" id="variablesContainer">
                                {{-- JS will populate this --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="p-8 text-center hidden" id="emptyState">
                        <p class="text-xs text-slate-500">No variables defined.</p>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition" href="{{ route('stacks.index') }}">Cancel</a>
                    <button class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" type="submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Save Changes
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    let varIndex = 0;
    
    // DATA DARI DATABASE (PENTING)
    const existingVariables = @json($stack->variables);

    function addVariableRow(data = null) {
        document.getElementById('emptyState').style.display = 'none';

        const container = document.getElementById('variablesContainer');
        const row = document.createElement('tr');
        row.className = "group border-b border-slate-50 hover:bg-slate-50/50 transition-colors";
        row.id = `row-${varIndex}`;

        const inputClass = "block w-full rounded-lg border-slate-200 text-xs px-3 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 shadow-sm transition-all";
        const selectClass = "block w-full rounded-lg border-slate-200 text-xs px-3 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 shadow-sm bg-white cursor-pointer transition-all";

        // Nilai Default (Jika data ada, pakai data. Jika tidak, kosong)
        const label = data ? data.label : '';
        const envKey = data ? data.env_key : '';
        const type = data ? data.type : 'text';
        const defaultVal = data ? data.default_value : '';

        row.innerHTML = `
            <td class="py-3 px-6 align-top">
                <input type="text" name="vars[${varIndex}][label]" value="${label}" placeholder="e.g. Password" required class="${inputClass}">
            </td>
            <td class="py-3 px-6 align-top">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-slate-400 font-mono text-[10px]">$</span>
                    <input type="text" name="vars[${varIndex}][env_key]" value="${envKey}" placeholder="DB_PASS" required 
                           onkeyup="this.value = this.value.toUpperCase().replace(/[^A-Z0-9_]/g, '')"
                           class="${inputClass} pl-5 font-mono text-indigo-600 font-bold">
                </div>
            </td>
            <td class="py-3 px-6 align-top">
                <select name="vars[${varIndex}][type]" class="${selectClass}">
                    <option value="text" ${type === 'text' ? 'selected' : ''}>Text</option>
                    <option value="secret" ${type === 'secret' ? 'selected' : ''}>Secret</option>
                    <option value="number" ${type === 'number' ? 'selected' : ''}>Number</option>
                    <option value="select" ${type === 'select' ? 'selected' : ''}>Dropdown</option>
                    <option value="boolean" ${type === 'boolean' ? 'selected' : ''}>Boolean</option>
                </select>
            </td>
            <td class="py-3 px-6 align-top">
                <input type="text" name="vars[${varIndex}][default_value]" value="${defaultVal}" placeholder="Value or Opt1,Opt2" class="${inputClass}">
            </td>
            <td class="py-3 px-4 text-right align-top">
                <button type="button" onclick="removeRow(${varIndex})" class="text-slate-300 hover:text-rose-500 hover:bg-rose-50 p-2 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </td>
        `;

        container.appendChild(row);
        varIndex++;
    }

    function removeRow(index) {
        const row = document.getElementById(`row-${index}`);
        if(row) row.remove();
        if (document.getElementById('variablesContainer').children.length === 0) {
            document.getElementById('emptyState').classList.remove('hidden');
        }
    }

    // LOAD DATA SAAT HALAMAN DIBUKA
    document.addEventListener('DOMContentLoaded', () => {
        if (existingVariables && existingVariables.length > 0) {
            existingVariables.forEach(variable => {
                addVariableRow(variable);
            });
        } else {
            addVariableRow(); // Tambah 1 baris kosong jika tidak ada data
        }
    });
</script>
@endpush