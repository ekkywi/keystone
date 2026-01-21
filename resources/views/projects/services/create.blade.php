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

                {{-- 1. MAIN CONFIGURATION --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">1. Configuration</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Service Name --}}
                        <div class="col-span-2 space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Service Name</label>
                            <input class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5" name="name" placeholder="e.g. Primary Database" required type="text">
                        </div>

                        {{-- STACK SELECTION --}}
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Service Template (Stack)</label>
                            <select class="block w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5" id="stackSelect" name="stack_id" onchange="renderVariables()" required>
                                <option disabled selected value="">-- Select Stack --</option>
                                @foreach ($stacks as $stack)
                                    <option value="{{ $stack->id }}">{{ $stack->name }} ({{ ucfirst($stack->type) }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- SERVER SELECTION --}}
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

                {{-- 2. SOURCE CODE CONFIGURATION (Hidden by default, shown via JS) --}}
                <div id="gitSection" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6" style="display: none;">
                    <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                        Source Code Configuration
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Input Repository --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Git Repository URL</label>
                            <input type="url" name="repository_url" id="repoUrlInput"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5" 
                                placeholder="https://github.com/user/repo.git">
                            <p class="text-xs text-gray-500 mt-1">HTTPS URL for public repositories.</p>
                        </div>

                        {{-- Input Branch --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Branch</label>
                            <input type="text" name="branch" id="branchInput" value="main"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5">
                        </div>
                    </div>
                </div>

                {{-- 3. ENVIRONMENT VARIABLES (Dynamic) --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6" id="variablesSection" style="display: none;">
                    <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-2">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Environment Variables</h3>
                        <span class="text-xs text-slate-400 italic">Auto-generated from stack</span>
                    </div>

                    <div class="space-y-4" id="dynamicInputs"></div>
                </div>

                {{-- SUBMIT BUTTON --}}
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
        // Mengambil data stack dari Controller PHP dan mengubahnya jadi JSON Object JavaScript
        const stacksData = @json($stacks);

        function renderVariables() {
            const stackId = document.getElementById('stackSelect').value;
            
            // Elements
            const container = document.getElementById('dynamicInputs');
            const varSection = document.getElementById('variablesSection');
            const gitSection = document.getElementById('gitSection');
            
            // Inputs Git (untuk toggle Required)
            const repoInput = document.getElementById('repoUrlInput');
            const branchInput = document.getElementById('branchInput');

            // Cari Stack yang dipilih
            const selectedStack = stacksData.find(s => s.id == stackId);

            // Bersihkan container variable lama
            container.innerHTML = '';

            if (selectedStack) {
                
                // ---------------------------------------------------------
                // 1. LOGIKA GIT CONFIGURATION (Show/Hide)
                // ---------------------------------------------------------
                if (selectedStack.type === 'application') {
                    // Jika tipe 'application', TAMPILKAN form Git
                    gitSection.style.display = 'block';
                    // Dan WAJIBKAN user mengisi (add required)
                    repoInput.setAttribute('required', 'required');
                    branchInput.setAttribute('required', 'required');
                } else {
                    // Jika tipe 'service' (Database), SEMBUNYIKAN form Git
                    gitSection.style.display = 'none';
                    // Dan HAPUS kewajiban mengisi (remove required) agar bisa submit
                    repoInput.removeAttribute('required');
                    branchInput.removeAttribute('required');
                    // Reset value agar bersih
                    repoInput.value = ''; 
                    branchInput.value = 'main';
                }

                // ---------------------------------------------------------
                // 2. LOGIKA ENVIRONMENT VARIABLES (Dynamic Render)
                // ---------------------------------------------------------
                if (selectedStack.variables.length > 0) {
                    varSection.style.display = 'block';

                    selectedStack.variables.forEach(v => {
                        let inputHtml = '';
                        const fieldName = `vars[${v.env_key}]`; 

                        // Tentukan Tipe Input
                        if (v.type === 'select') {
                            const options = v.default_value.split(',').map(opt => `<option value="${opt.trim()}">${opt.trim()}</option>`).join('');
                            inputHtml = `
                                <select name="${fieldName}" class="block w-full rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2">
                                    ${options}
                                </select>`;
                        } else {
                            const typeAttr = v.type === 'secret' ? 'password' : (v.type === 'number' ? 'number' : 'text');
                            const valAttr = v.default_value ? `value="${v.default_value}"` : '';
                            inputHtml = `
                                <input type="${typeAttr}" name="${fieldName}" ${valAttr} class="block w-full rounded-lg border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2" placeholder="${v.label}">`;
                        }

                        // Buat Wrapper Input
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
                    varSection.style.display = 'none';
                }
            }
        }
    </script>
@endpush