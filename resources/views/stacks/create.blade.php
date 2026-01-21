@extends("layouts.app")

@section("header")
    <div class="flex items-center gap-3 h-full">
        <a class="text-slate-400 hover:text-slate-600 transition" href="{{ route("stacks.index") }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </a>
        <div class="flex flex-col">
            <h2 class="font-bold text-lg text-slate-800 leading-tight">Create Master Stack</h2>
            <p class="text-xs text-slate-500 font-mono">Define service template and variables</p>
        </div>
    </div>
@endsection

@section("content")
    <form action="{{ route("stacks.store") }}" id="stackForm" method="POST">
        @csrf

        <div class="max-w-5xl mx-auto space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">1. Stack Identity</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700">Stack Name</label>
                        <input class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2" name="name" placeholder="e.g. PostgreSQL Database" required type="text">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700">Service Type</label>
                        <select class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2" name="type">
                            <option value="service">Service</option>
                            <option value="application">Application</option>
                        </select>
                    </div>
                    <div class="col-span-2 space-y-1">
                        <label class="block text-sm font-medium text-slate-700">Description</label>
                        <input class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2" name="description" placeholder="Short description for the user..." type="text">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-2">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">2. Docker Compose Template</h3>
                    <div class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded">
                        Use <span class="font-mono text-indigo-600">${VAR_NAME}</span> for dynamic values
                    </div>
                </div>

                <textarea class="block w-full rounded-lg border-slate-300 bg-slate-900 text-slate-300 font-mono text-sm focus:ring-indigo-500 focus:border-indigo-500 p-4 leading-relaxed" name="raw_compose_template" placeholder="services:
  ${SERVICE_NAME}:
    image: postgres:${DB_VERSION}
    environment:
      POSTGRES_PASSWORD: ${DB_PASSWORD}" rows="12" spellcheck="false"></textarea>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-2">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">3. Input Variables</h3>
                    <button class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-md font-medium hover:bg-indigo-100 transition" onclick="addVariableRow()" type="button">
                        + Add Variable
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs text-slate-500 uppercase border-b border-slate-200">
                                <th class="py-2 w-1/4 font-semibold">Label (Question)</th>
                                <th class="py-2 w-1/4 font-semibold">ENV Key (Must match YAML)</th>
                                <th class="py-2 w-1/6 font-semibold">Input Type</th>
                                <th class="py-2 w-1/4 font-semibold">Default / Options</th>
                                <th class="py-2 w-10 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="text-sm" id="variablesContainer">
                        </tbody>
                    </table>
                </div>

                <p class="mt-4 text-xs text-slate-400 italic text-center" id="emptyState">
                    No variables defined yet. Click "Add Variable" to start.
                </p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a class="px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-white rounded-lg transition" href="{{ route("stacks.index") }}">Cancel</a>
                <button class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20" type="submit">
                    Save Master Stack
                </button>
            </div>

        </div>
    </form>
@endsection

@push("scripts")
    <script>
        let varIndex = 0;

        function addVariableRow() {
            // Hide empty state hint
            document.getElementById('emptyState').style.display = 'none';

            const container = document.getElementById('variablesContainer');
            const row = document.createElement('tr');
            row.className = "group border-b border-slate-50 hover:bg-slate-50 transition";
            row.id = `row-${varIndex}`;

            row.innerHTML = `
            <td class="py-2 pr-2 align-top">
                <input type="text" name="vars[${varIndex}][label]" placeholder="e.g. Database Password" required 
                       class="block w-full rounded border-slate-300 text-xs px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500">
            </td>
            <td class="py-2 pr-2 align-top">
                <input type="text" name="vars[${varIndex}][env_key]" placeholder="e.g. DB_PASSWORD" required 
                       onkeyup="this.value = this.value.toUpperCase().replace(/[^A-Z0-9_]/g, '')"
                       class="block w-full rounded border-slate-300 text-xs px-2 py-1.5 font-mono text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500">
            </td>
            <td class="py-2 pr-2 align-top">
                <select name="vars[${varIndex}][type]" 
                        class="block w-full rounded border-slate-300 text-xs px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="text">Text</option>
                    <option value="secret">Secret (Password)</option>
                    <option value="number">Number</option>
                    <option value="select">Dropdown (Select)</option>
                    <option value="boolean">Boolean (Yes/No)</option>
                </select>
            </td>
            <td class="py-2 pr-2 align-top">
                <input type="text" name="vars[${varIndex}][default_value]" placeholder="Value or Option1,Option2" 
                       class="block w-full rounded border-slate-300 text-xs px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500">
                <span class="text-[10px] text-slate-400">For Select: Comma separated (14,15,16)</span>
            </td>
            <td class="py-2 text-right align-top">
                <button type="button" onclick="removeRow(${varIndex})" class="text-slate-400 hover:text-rose-500 transition p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </td>
        `;

            container.appendChild(row);
            varIndex++;
        }

        function removeRow(index) {
            const row = document.getElementById(`row-${index}`);
            row.remove();

            // Show empty state if no rows left
            if (document.getElementById('variablesContainer').children.length === 0) {
                document.getElementById('emptyState').style.display = 'block';
            }
        }

        // Auto add 1 row on load
        document.addEventListener('DOMContentLoaded', () => {
            addVariableRow();
        });
    </script>
@endpush
