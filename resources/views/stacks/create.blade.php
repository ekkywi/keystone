@extends("layouts.app")

@section("title", "Create Stack Template")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-4">
            <a class="group p-2 rounded-xl border border-transparent hover:bg-white hover:border-slate-200 text-slate-400 hover:text-slate-600 transition shadow-sm hover:shadow" href="{{ route("stacks.index") }}">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </a>

            <div class="h-8 w-px bg-slate-200"></div>

            <div>
                <h2 class="font-bold text-xl text-slate-800 tracking-tight">Create Master Stack</h2>
                <p class="text-xs text-slate-500 mt-0.5">Define service template and variables</p>
            </div>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-5xl mx-auto pb-20">

        <form action="{{ route("stacks.store") }}" id="stackForm" method="POST">
            @csrf

            <div class="space-y-8">

                {{-- 1. STACK IDENTITY --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">1. Stack Identity</h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Stack Name</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all placeholder:text-slate-300" name="name" placeholder="e.g. PostgreSQL Database" required type="text">
                        </div>

                        {{-- Type --}}
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Service Type</label>
                            <div class="relative">
                                <select class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all appearance-none bg-white cursor-pointer" name="type">
                                    <option value="application">Application (Node, PHP, Python)</option>
                                    <option value="database">Database (MySQL, Postgres)</option>
                                    <option value="cache">Cache (Redis, Memcached)</option>
                                    <option value="service">Service (Generic/Other)</option>
                                </select>
                                {{-- icon panah tetap sama --}}
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Description</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all placeholder:text-slate-300" name="description" placeholder="Short description for the catalog..." type="text">
                        </div>
                    </div>
                </div>

                {{-- 2. DOCKER COMPOSE --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">2. Docker Compose Template</h3>
                        </div>
                        <div class="flex items-center gap-2 text-[10px] bg-white border border-slate-200 px-2 py-1 rounded-lg text-slate-500">
                            <span>Use</span>
                            <code class="font-mono text-indigo-600 bg-indigo-50 px-1 rounded">${VAR_NAME}</code>
                            <span>for dynamic values</span>
                        </div>
                    </div>

                    <div class="p-0">
                        <textarea class="block w-full bg-[#1e293b] text-slate-300 font-mono text-xs leading-relaxed p-6 focus:outline-none focus:ring-0 border-0 resize-y" name="raw_compose_template" placeholder="# Example Docker Compose
services:
  ${SERVICE_NAME}:
    image: postgres:${DB_VERSION}
    restart: unless-stopped
    environment:
      POSTGRES_PASSWORD: ${DB_PASSWORD}
    volumes:
      - ${SERVICE_NAME}_data:/var/lib/postgresql/data" rows="16" spellcheck="false"></textarea>
                    </div>
                </div>

                {{-- 3. INPUT VARIABLES --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">3. Input Variables</h3>
                        </div>
                        <button class="text-xs bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition flex items-center gap-1 shadow-md shadow-indigo-200" onclick="addVariableRow()" type="button">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
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
                                {{-- Rows added via JS --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="p-8 text-center" id="emptyState">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-50 mb-3">
                            <svg class="h-6 w-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-slate-900">No variables defined</h3>
                        <p class="mt-1 text-xs text-slate-500">Click "Add Variable" to define user inputs for this stack.</p>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition" href="{{ route("stacks.index") }}">Cancel</a>
                    <button class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" type="submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                        Save Master Stack
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection

@push("scripts")
    <script>
        let varIndex = 0;

        function addVariableRow() {
            document.getElementById('emptyState').style.display = 'none';

            const container = document.getElementById('variablesContainer');
            const row = document.createElement('tr');
            row.className = "group border-b border-slate-50 hover:bg-slate-50/50 transition-colors";
            row.id = `row-${varIndex}`;

            // Helper classes for consistent inputs
            const inputClass = "block w-full rounded-lg border-slate-200 text-xs px-3 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 shadow-sm transition-all";
            const selectClass = "block w-full rounded-lg border-slate-200 text-xs px-3 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 shadow-sm bg-white cursor-pointer transition-all";

            row.innerHTML = `
            <td class="py-3 px-6 align-top">
                <input type="text" name="vars[${varIndex}][label]" placeholder="e.g. Database Password" required class="${inputClass}">
            </td>
            <td class="py-3 px-6 align-top">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-slate-400 font-mono text-[10px]">$</span>
                    <input type="text" name="vars[${varIndex}][env_key]" placeholder="DB_PASSWORD" required 
                           onkeyup="this.value = this.value.toUpperCase().replace(/[^A-Z0-9_]/g, '')"
                           class="${inputClass} pl-5 font-mono text-indigo-600 font-bold placeholder:font-sans placeholder:text-slate-300 placeholder:font-normal">
                </div>
            </td>
            <td class="py-3 px-6 align-top">
                <select name="vars[${varIndex}][type]" class="${selectClass}">
                    <option value="text">Text</option>
                    <option value="secret">Secret</option>
                    <option value="number">Number</option>
                    <option value="select">Dropdown</option>
                    <option value="boolean">Boolean</option>
                </select>
            </td>
            <td class="py-3 px-6 align-top">
                <input type="text" name="vars[${varIndex}][default_value]" placeholder="Value or Option1,Option2" class="${inputClass}">
                <span class="text-[10px] text-slate-400 mt-1 block">For Select: <code>opt1,opt2</code></span>
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
            if (row) row.remove();

            if (document.getElementById('variablesContainer').children.length === 0) {
                document.getElementById('emptyState').style.display = 'block';
            }
        }

        // Initialize with 1 row
        document.addEventListener('DOMContentLoaded', () => {
            addVariableRow();
        });
    </script>
@endpush
