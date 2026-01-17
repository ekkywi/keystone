@extends("layouts.app")

@section("header")
    <div class="flex items-center gap-3 h-full">
        <a class="text-slate-400 hover:text-slate-600 transition" href="{{ route("projects.show", $project) }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </a>
        <div class="flex flex-col">
            <h2 class="font-bold text-lg text-slate-800 leading-tight">Add New Service</h2>
            <p class="text-xs text-slate-500 font-mono">Project: {{ $project->name }}</p>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-3xl mx-auto">

        <form action="{{ route("projects.services.store", $project) }}" method="POST">
            @csrf

            <div class="space-y-6">

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">1. Configuration</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Service Name</label>
                            <input class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5" name="name" placeholder="e.g. Primary Database" required type="text">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Service Template (Stack)</label>
                            <select class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5" id="stackSelect" name="stack_id" onchange="renderVariables()" required>
                                <option disabled selected value="">-- Select Stack --</option>
                                @foreach ($stacks as $stack)
                                    <option value="{{ $stack->id }}">{{ $stack->name }} ({{ $stack->type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Target Server</label>
                            <select class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5" name="server_id" required>
                                @foreach ($servers as $server)
                                    <option value="{{ $server->id }}">{{ $server->name }} ({{ $server->ip_address }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6" id="variablesSection" style="display: none;">
                    <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-2">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">2. Environment Variables</h3>
                        <span class="text-xs text-slate-400 italic">Auto-generated from stack</span>
                    </div>

                    <div class="space-y-4" id="dynamicInputs"></div>
                </div>

                <div class="flex justify-end pt-2">
                    <button class="bg-slate-900 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20" type="submit">
                        Save & Add Service
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection

@push("scripts")
    <script>
        // 1. Simpan Data Stacks (termasuk variables) ke dalam Variable JS
        const stacksData = @json($stacks);

        function renderVariables() {
            const stackId = document.getElementById('stackSelect').value;
            const container = document.getElementById('dynamicInputs');
            const section = document.getElementById('variablesSection');

            // Cari stack yang dipilih
            const selectedStack = stacksData.find(s => s.id == stackId);

            // Reset container
            container.innerHTML = '';

            if (selectedStack && selectedStack.variables.length > 0) {
                section.style.display = 'block'; // Tampilkan section

                // Loop variables dan buat input field
                selectedStack.variables.forEach(v => {
                    let inputHtml = '';
                    const fieldName = `vars[${v.env_key}]`; // Format nama array: vars[DB_PASS]

                    // Tentukan tipe input HTML berdasarkan tipe variable stack
                    if (v.type === 'select') {
                        // Logic untuk Dropdown
                        const options = v.default_value.split(',').map(opt => `<option value="${opt.trim()}">${opt.trim()}</option>`).join('');
                        inputHtml = `
                        <select name="${fieldName}" class="block w-full rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2">
                            ${options}
                        </select>
                    `;
                    } else {
                        // Logic untuk Text / Secret / Number
                        const typeAttr = v.type === 'secret' ? 'password' : (v.type === 'number' ? 'number' : 'text');
                        const valAttr = v.default_value ? `value="${v.default_value}"` : '';
                        inputHtml = `
                        <input type="${typeAttr}" name="${fieldName}" ${valAttr} class="block w-full rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2" placeholder="${v.label}">
                    `;
                    }

                    // Masukkan ke dalam Wrapper (Label + Input)
                    const wrapper = document.createElement('div');
                    wrapper.className = "grid grid-cols-1 md:grid-cols-3 gap-4 items-center";
                    wrapper.innerHTML = `
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-slate-700">${v.label}</label>
                        <code class="text-[10px] text-indigo-500 font-mono bg-indigo-50 px-1 rounded">${v.env_key}</code>
                    </div>
                    <div class="md:col-span-2">
                        ${inputHtml}
                    </div>
                `;
                    container.appendChild(wrapper);
                });
            } else {
                section.style.display = 'none'; // Sembunyikan jika tidak ada variable
            }
        }
    </script>
@endpush
