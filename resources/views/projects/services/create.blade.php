@extends("layouts.app")

@section("title", "Add New Service")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-4">
            {{-- Back Button --}}
            <a class="group p-2 rounded-xl border border-transparent hover:bg-white hover:border-slate-200 text-slate-400 hover:text-slate-600 transition shadow-sm hover:shadow" href="{{ route("projects.show", $project) }}">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </a>

            <div class="h-8 w-px bg-slate-200"></div>

            <div>
                <h2 class="font-bold text-xl text-slate-800 tracking-tight">Add New Service</h2>
                <p class="text-xs text-slate-500 mt-0.5">Project: {{ $project->name }}</p>
            </div>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-4xl mx-auto pb-20">

        <form action="{{ route("projects.services.store", $project) }}" method="POST">
            @csrf

            <div class="space-y-8">

                {{-- 1. CONFIGURATION CARD --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">1. Core Configuration</h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Service Name --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Service Name</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all placeholder:text-slate-300" name="name" placeholder="e.g. Primary Database" required type="text">
                        </div>

                        {{-- Target Server --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Target Server</label>
                            <div class="relative">
                                <select class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all appearance-none bg-white cursor-pointer" name="server_id" required>
                                    @foreach ($servers as $server)
                                        <option value="{{ $server->id }}">{{ $server->name }} ({{ $server->ip_address }})</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Stack Selection --}}
                        <div class="col-span-2 border-t border-slate-50 pt-6 mt-2">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Service Template (Stack)</label>
                            <div class="relative">
                                <select class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all appearance-none bg-white cursor-pointer" id="stackSelect" name="stack_id" onchange="renderVariables()" required>
                                    <option disabled selected value="">-- Choose a Technology Stack --</option>
                                    @foreach ($stacks as $stack)
                                        <option value="{{ $stack->id }}">{{ $stack->name }} ({{ ucfirst($stack->type) }})</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Description Box --}}
                            <div class="mt-3 flex gap-2 items-start text-xs text-slate-500 bg-slate-50 p-3 rounded-lg border border-slate-100 hidden" id="stackDescContainer">
                                <svg class="w-4 h-4 text-indigo-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                                <span id="stackDesc">Select a stack to see details.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. SOURCE CODE (Hidden by default) --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hidden transition-all" id="gitSection">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">2. Source Code</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Git Repository URL</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all font-mono text-slate-600" id="repoUrlInput" name="repository_url" placeholder="https://github.com/username/repo.git" type="url">
                            <p class="text-[10px] text-slate-400 mt-1.5 ml-1">Must be a public HTTPS URL.</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Branch</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </span>
                                <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm pl-10 pr-4 py-3 shadow-sm transition-all font-mono text-slate-600" id="branchInput" name="branch" type="text" value="main">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. ENV VARIABLES (Dynamic) --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hidden transition-all" id="variablesSection">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">3. Environment Variables</h3>
                        </div>
                        <span class="text-[10px] font-bold font-mono bg-slate-100 text-slate-500 px-2 py-1 rounded border border-slate-200">.env</span>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6" id="dynamicInputs">
                            {{-- JS will render inputs here --}}
                        </div>
                    </div>
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="flex items-center justify-end pt-4">
                    <button class="bg-indigo-600 text-white px-8 py-3.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" type="submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                        Create Service
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection

@push("scripts")
    <script>
        const stacksData = @json($stacks);

        function renderVariables() {
            const stackId = document.getElementById('stackSelect').value;

            // Elements
            const container = document.getElementById('dynamicInputs');
            const varSection = document.getElementById('variablesSection');
            const gitSection = document.getElementById('gitSection');
            const stackDesc = document.getElementById('stackDesc');
            const stackDescContainer = document.getElementById('stackDescContainer');

            // Inputs Git
            const repoInput = document.getElementById('repoUrlInput');
            const branchInput = document.getElementById('branchInput');

            // Find Stack
            const selectedStack = stacksData.find(s => s.id == stackId);

            // Reset
            container.innerHTML = '';

            if (selectedStack) {
                // Show Description
                stackDescContainer.classList.remove('hidden');
                stackDesc.innerText = selectedStack.description || "No description available for this stack.";

                // 1. GIT LOGIC
                if (selectedStack.type === 'application') {
                    gitSection.classList.remove('hidden');
                    repoInput.setAttribute('required', 'required');
                    branchInput.setAttribute('required', 'required');
                } else {
                    gitSection.classList.add('hidden');
                    repoInput.removeAttribute('required');
                    branchInput.removeAttribute('required');
                    repoInput.value = '';
                    branchInput.value = 'main';
                }

                // 2. ENV LOGIC
                if (selectedStack.variables.length > 0) {
                    varSection.classList.remove('hidden');

                    selectedStack.variables.forEach(v => {
                        const fieldName = `vars[${v.env_key}]`;
                        let inputElement = '';

                        // CSS Class yang konsisten dengan input statis (Upgrade Tampilan)
                        const inputClass = "w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all font-mono text-slate-600";
                        const selectClass = "w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all appearance-none bg-white cursor-pointer";

                        // A. TYPE: SELECT (Dropdown)
                        if (v.type === 'select') {
                            const options = v.default_value.split(',').map(opt => `<option value="${opt.trim()}">${opt.trim()}</option>`).join('');
                            inputElement = `
                                <div class="relative">
                                    <select name="${fieldName}" class="${selectClass}">
                                        ${options}
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>`;

                            // B. TYPE: BOOLEAN (True/False)
                        } else if (v.type === 'boolean') {
                            const isTrue = v.default_value === 'true' || v.default_value === '1';
                            inputElement = `
                                <div class="relative">
                                    <select name="${fieldName}" class="${selectClass}">
                                        <option value="true" ${isTrue ? 'selected' : ''}>True</option>
                                        <option value="false" ${!isTrue ? 'selected' : ''}>False</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>`;

                            // C. TYPE: TEXT/NUMBER/PASSWORD
                        } else {
                            const typeAttr = (v.type === 'secret' || v.type === 'password') ? 'text' : (v.type === 'number' ? 'number' : 'text');
                            const valAttr = v.default_value ? `value="${v.default_value}"` : '';
                            inputElement = `<input type="${typeAttr}" name="${fieldName}" ${valAttr} class="${inputClass}" placeholder="${v.label}">`;
                        }

                        // Wrapper HTML
                        const wrapper = document.createElement('div');
                        wrapper.className = "relative group";
                        wrapper.innerHTML = `
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2 flex justify-between items-center">
                                <span>${v.label}</span>
                                <span class="font-mono text-[10px] text-indigo-500 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100">${v.env_key}</span>
                            </label>
                            ${inputElement}
                            <p class="text-[10px] text-slate-400 mt-1.5 ml-1">Default: <span class="font-mono text-slate-500">${v.default_value || '(Empty)'}</span></p>
                        `;
                        container.appendChild(wrapper);
                    });
                } else {
                    varSection.classList.add('hidden');
                }
            } else {
                // No Stack Selected -> Hide All
                gitSection.classList.add('hidden');
                varSection.classList.add('hidden');
                stackDescContainer.classList.add('hidden');
            }
        }
    </script>
@endpush
