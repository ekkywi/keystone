@extends("layouts.app")

@section("header")
    <div class="flex items-center gap-3 h-full">
        <a class="text-slate-400 hover:text-slate-600 transition" href="{{ route("stacks.index") }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </a>
        <div class="flex flex-col">
            <h2 class="font-bold text-lg text-slate-800 leading-tight">Edit Master Stack</h2>
            <p class="text-xs text-slate-500 font-mono">Updating: {{ $stack->name }}</p>
        </div>
    </div>
@endsection

@section("content")
    <form action="{{ route("stacks.update", $stack) }}" id="stackForm" method="POST">
        @csrf
        @method("PUT")

        <div class="max-w-5xl mx-auto space-y-6">

            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" fill-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-700">
                            <strong>Caution:</strong> Changing "ENV Key" names may break existing deployments that use this stack.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">1. Stack Identity</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700">Stack Name</label>
                        <input class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2" name="name" required type="text" value="{{ old("name", $stack->name) }}">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700">Service Type</label>
                        <select class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2" name="type">
                            <option {{ $stack->type == "service" ? "selected" : "" }} value="service">Service</option>
                            <option {{ $stack->type == "application" ? "selected" : "" }} value="application">Application</option>
                        </select>
                    </div>
                    <div class="col-span-2 space-y-1">
                        <label class="block text-sm font-medium text-slate-700">Description</label>
                        <input class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2" name="description" type="text" value="{{ old("description", $stack->description) }}">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-2">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">2. Docker Compose Template</h3>
                </div>
                <textarea class="block w-full rounded-lg border-slate-300 bg-slate-900 text-slate-300 font-mono text-sm focus:ring-indigo-500 focus:border-indigo-500 p-4 leading-relaxed" name="raw_compose_template" rows="12" spellcheck="false">{{ old("raw_compose_template", $stack->raw_compose_template) }}</textarea>
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
                                <th class="py-2 w-1/4 font-semibold">ENV Key</th>
                                <th class="py-2 w-1/6 font-semibold">Input Type</th>
                                <th class="py-2 w-1/4 font-semibold">Default / Options</th>
                                <th class="py-2 w-10 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="text-sm" id="variablesContainer"></tbody>
                    </table>
                </div>
                <p class="mt-4 text-xs text-slate-400 italic text-center" id="emptyState" style="display: none;">
                    No variables defined yet.
                </p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a class="px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-white rounded-lg transition" href="{{ route("stacks.index") }}">Cancel</a>

                <button class="bg-slate-900 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20" onclick="confirmUpdate()" type="button">
                    Update Changes
                </button>
            </div>

        </div>
    </form>
@endsection

@push("scripts")
    <script>
        let varIndex = 0;

        // Fungsi Add Row (Sama seperti Create, tapi bisa terima data existing)
        function addVariableRow(data = null) {
            document.getElementById('emptyState').style.display = 'none';

            const container = document.getElementById('variablesContainer');
            const row = document.createElement('tr');
            row.className = "group border-b border-slate-50 hover:bg-slate-50 transition";
            row.id = `row-${varIndex}`;

            // Nilai Default (jika data kosong)
            const label = data ? data.label : '';
            const envKey = data ? data.env_key : '';
            const type = data ? data.type : 'text';
            const defaultValue = data ? (data.default_value || '') : '';

            row.innerHTML = `
            <td class="py-2 pr-2 align-top">
                <input type="text" name="vars[${varIndex}][label]" value="${label}" required 
                       class="block w-full rounded border-slate-300 text-xs px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500">
            </td>
            <td class="py-2 pr-2 align-top">
                <input type="text" name="vars[${varIndex}][env_key]" value="${envKey}" required 
                       onkeyup="this.value = this.value.toUpperCase().replace(/[^A-Z0-9_]/g, '')"
                       class="block w-full rounded border-slate-300 text-xs px-2 py-1.5 font-mono text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500">
            </td>
            <td class="py-2 pr-2 align-top">
                <select name="vars[${varIndex}][type]" 
                        class="block w-full rounded border-slate-300 text-xs px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="text" ${type === 'text' ? 'selected' : ''}>Text</option>
                    <option value="secret" ${type === 'secret' ? 'selected' : ''}>Secret (Password)</option>
                    <option value="number" ${type === 'number' ? 'selected' : ''}>Number</option>
                    <option value="select" ${type === 'select' ? 'selected' : ''}>Dropdown</option>
                    <option value="boolean" ${type === 'boolean' ? 'selected' : ''}>Boolean</option>
                </select>
            </td>
            <td class="py-2 pr-2 align-top">
                <input type="text" name="vars[${varIndex}][default_value]" value="${defaultValue}" 
                       class="block w-full rounded border-slate-300 text-xs px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500">
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
            document.getElementById(`row-${index}`).remove();
            if (document.getElementById('variablesContainer').children.length === 0) {
                document.getElementById('emptyState').style.display = 'block';
            }
        }

        // INIT: Load Existing Variables dari Controller
        document.addEventListener('DOMContentLoaded', () => {
            const existingVars = @json($stack->variables);

            if (existingVars.length > 0) {
                existingVars.forEach(variable => {
                    addVariableRow(variable);
                });
            } else {
                // Jika kosong (tapi jarang terjadi), tampilkan empty state
                document.getElementById('emptyState').style.display = 'block';
            }
        });

        function confirmUpdate() {
            Swal.fire({
                title: 'Update Master Stack?',
                html: `
            <div class="text-left text-sm text-slate-600">
                <p class="mb-3">You are about to update a Stack Template. Please confirm:</p>
                <ul class="list-disc pl-4 space-y-1 mb-3 text-amber-700">
                    <li>Did you rename any <b>ENV Keys</b>?</li>
                    <li>Did you remove any <b>Required Variables</b>?</li>
                </ul>
                <p>Changes may cause deployment failures for existing projects using this stack.</p>
            </div>
        `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0f172a', // Slate-900
                cancelButtonColor: '#64748b', // Slate-500
                confirmButtonText: 'Yes, I understand',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-xl border border-slate-200 shadow-xl',
                    title: 'text-slate-800 font-bold',
                    htmlContainer: 'text-slate-600',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user yakin, baru kita submit form secara manual via JS
                    document.getElementById('stackForm').submit();
                }
            })
        }
    </script>
@endpush
