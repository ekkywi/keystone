@extends("layouts.app")

@section("title", "Edit Service")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-4">
            {{-- Back Button --}}
            <a class="group p-2 rounded-xl border border-transparent hover:bg-white hover:border-slate-200 text-slate-400 hover:text-slate-600 transition shadow-sm hover:shadow" href="{{ route("projects.show", $service->project) }}">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </a>

            <div class="h-8 w-px bg-slate-200"></div>

            <div class="flex items-center gap-3">
                {{-- Stack Icon --}}
                <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm">
                    {{ substr($service->stack->name, 0, 2) }}
                </div>
                <div>
                    <h2 class="font-bold text-xl text-slate-800 tracking-tight">Edit Service</h2>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $service->name }} ({{ $service->stack->name }})</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-4xl mx-auto pb-20">

        <form action="{{ route("services.update", $service) }}" method="POST">
            @csrf
            @method("PUT")

            <div class="space-y-8">

                {{-- 1. GENERAL INFORMATION --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">1. General Information</h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Service Name --}}
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Service Name</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all placeholder:text-slate-300" name="name" required type="text" value="{{ old("name", $service->name) }}">
                            <p class="text-[10px] text-slate-400 mt-1.5 ml-1">Used for internal identification.</p>
                        </div>

                        {{-- Target Server (Read-only) --}}
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Target Server</label>
                            <div class="relative">
                                <input class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-500 text-sm px-4 py-3 shadow-sm pl-10 cursor-not-allowed" disabled type="text" value="{{ $service->server->name }} ({{ $service->server->ip_address }})">
                                <div class="absolute left-3 top-3.5 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1.5 ml-1">Server cannot be changed after creation.</p>
                        </div>
                    </div>
                </div>

                {{-- 2. SOURCE CODE (Only for Apps) --}}
                @if ($service->stack->type === "application")
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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
                                <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all font-mono text-slate-600" name="repository_url" placeholder="https://github.com/user/repo.git" required type="url" value="{{ old("repository_url", $service->repository_url) }}">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Branch</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </span>
                                    <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm pl-10 pr-4 py-3 shadow-sm transition-all font-mono text-slate-600" name="branch" required type="text" value="{{ old("branch", $service->branch ?? "main") }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- 3. ENVIRONMENT VARIABLES --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            @foreach ($service->stack->variables as $var)
                                @php
                                    // Ambil value yang tersimpan atau default
                                    $savedValue = $service->input_variables[$var->env_key] ?? null;
                                    $defaultValue = $var->default_value;
                                    $finalValue = $savedValue ?? ($defaultValue ?? "");

                                    // Class Style Variables
                                    $inputClass = "w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all font-mono text-slate-600";
                                    $selectClass = "w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all appearance-none bg-white cursor-pointer";
                                @endphp

                                <div class="relative group">
                                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2 flex justify-between items-center">
                                        <span>{{ $var->label }}</span>
                                        <span class="font-mono text-[10px] text-indigo-500 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100">{{ $var->env_key }}</span>
                                    </label>

                                    {{-- LOGIC UNTUK INPUT VS SELECT --}}
                                    @if ($var->type === "select")
                                        {{-- JIKA TIPE SELECT (Dropdown) --}}
                                        <div class="relative">
                                            <select class="{{ $selectClass }}" name="vars[{{ $var->env_key }}]">
                                                @foreach (explode(",", $var->default_value) as $option)
                                                    @php $opt = trim($option); @endphp
                                                    <option {{ (string) $finalValue === (string) $opt ? "selected" : "" }} value="{{ $opt }}">
                                                        {{ $opt }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                </svg>
                                            </div>
                                        </div>
                                    @elseif($var->type === "boolean")
                                        {{-- JIKA TIPE BOOLEAN (Dropdown True/False) --}}
                                        <div class="relative">
                                            <select class="{{ $selectClass }}" name="vars[{{ $var->env_key }}]">
                                                <option {{ (string) $finalValue === "true" || $finalValue === true || $finalValue === "1" ? "selected" : "" }} value="true">True</option>
                                                <option {{ (string) $finalValue === "false" || $finalValue === false || $finalValue === "0" || $finalValue === "" ? "selected" : "" }} value="false">False</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        {{-- DEFAULT (Text/Number/Password) --}}
                                        <input class="{{ $inputClass }}" name="vars[{{ $var->env_key }}]" placeholder="{{ $var->default_value }}" type="{{ $var->type == "password" || $var->type == "secret" ? "text" : ($var->type == "number" ? "number" : "text") }}" value="{{ old("vars." . $var->env_key, $finalValue) }}">
                                    @endif

                                    <p class="text-[10px] text-slate-400 mt-1.5 ml-1">{{ $var->description ?? "Configure " . $var->label }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition" href="{{ route("projects.show", $service->project) }}">Cancel</a>
                    <button class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" type="submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                        Save Changes
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
