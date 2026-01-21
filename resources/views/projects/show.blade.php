@extends("layouts.app")

@section("title", $project->name)

@push("styles")
    <style>
        /* Flash Animations */
        @keyframes flash-success {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
                transform: scale(1);
            }

            50% {
                box-shadow: 0 0 0 12px rgba(16, 185, 129, 0);
                transform: scale(1.02);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
                transform: scale(1);
            }
        }

        @keyframes flash-error {
            0% {
                box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.4);
                transform: scale(1);
            }

            50% {
                box-shadow: 0 0 0 12px rgba(225, 29, 72, 0);
                transform: scale(1.02);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(225, 29, 72, 0);
                transform: scale(1);
            }
        }

        .animate-flash-success {
            animation: flash-success 0.8s ease-out;
            z-index: 20;
        }

        .animate-flash-error {
            animation: flash-error 0.8s ease-out;
            z-index: 20;
        }
    </style>
@endpush

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-4">
            {{-- Back Button --}}
            <a class="group p-2 rounded-xl border border-transparent hover:bg-white hover:border-slate-200 text-slate-400 hover:text-slate-600 transition shadow-sm hover:shadow" href="{{ route("projects.index") }}">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </a>

            <div class="h-8 w-px bg-slate-200"></div>

            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-bold text-xl text-slate-800 tracking-tight">{{ $project->name }}</h2>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border 
                        {{ $project->environment == "production" ? "bg-rose-50 text-rose-600 border-rose-100" : ($project->environment == "staging" ? "bg-amber-50 text-amber-600 border-amber-100" : "bg-emerald-50 text-emerald-600 border-emerald-100") }}">
                        {{ $project->environment }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-2">
                    <span class="truncate max-w-[300px]">{{ $project->description ?? "Single server deployment" }}</span>
                </p>
            </div>
        </div>

        <a class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" href="{{ route("projects.services.create", $project) }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Add Service
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-8 pb-12">
        @if ($project->services->count() == 0)
            {{-- EMPTY STATE --}}
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-center bg-white/50 backdrop-blur-sm rounded-3xl border border-dashed border-slate-300">
                <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 mb-6 relative">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                    </svg>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center border-4 border-slate-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-slate-900">No services deployed</h3>
                <p class="text-slate-500 max-w-md mt-2 mb-8 leading-relaxed">
                    This project is empty. Add a database or application service to get started.
                </p>
                <a class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20" href="{{ route("projects.services.create", $project) }}">
                    Deploy First Service
                </a>
            </div>
        @else
            {{-- GRID SERVICES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
                @foreach ($project->services as $service)
                    {{-- SERVICE CARD --}}
                    {{-- Note: 'ring-1' menggantikan border tebal agar lebih modern --}}
                    <div class="service-card group relative flex flex-col h-full rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/5
                                {{ $service->status == "running" ? "bg-white ring-1 ring-emerald-500/30" : ($service->status == "building" ? "bg-white ring-1 ring-blue-500/30" : ($service->status == "stopping" ? "bg-white ring-1 ring-amber-500/30" : ($service->status == "failed" ? "bg-white ring-1 ring-rose-500/30" : "bg-slate-50 ring-1 ring-slate-200"))) }}" data-id="{{ $service->id }}" data-refresh-url="{{ route("services.refresh-status", $service) }}" data-status="{{ $service->status }}">

                        {{-- HEADER --}}
                        <div class="px-5 py-5 flex items-start justify-between" id="card-header-{{ $service->id }}">
                            <div class="flex items-center gap-3">
                                {{-- Icon Stack --}}
                                <div class="h-12 w-12 rounded-2xl shadow-sm flex items-center justify-center font-bold text-sm text-white transition-colors duration-500
                                            {{ $service->status == "running" ? "bg-gradient-to-br from-emerald-400 to-emerald-600" : ($service->status == "building" ? "bg-gradient-to-br from-blue-400 to-blue-600" : ($service->status == "stopping" ? "bg-gradient-to-br from-amber-400 to-amber-600" : ($service->status == "failed" ? "bg-gradient-to-br from-rose-400 to-rose-600" : "bg-gradient-to-br from-slate-400 to-slate-500"))) }}" id="stack-icon-{{ $service->id }}">
                                    {{ substr($service->stack->name, 0, 2) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base leading-tight">{{ $service->name }}</h3>
                                    <p class="text-xs text-slate-500 mt-1 font-medium">{{ $service->stack->name }}</p>
                                </div>
                            </div>

                            {{-- Actions Top Right --}}
                            <div class="flex items-center gap-1">
                                <button class="text-slate-300 hover:text-indigo-600 transition p-1.5 rounded-lg hover:bg-indigo-50" id="refresh-btn-{{ $service->id }}" onclick="window.manualRefresh('{{ $service->id }}')" title="Refresh Status">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </button>
                                <a class="text-slate-300 hover:text-indigo-600 transition p-1.5 rounded-lg hover:bg-indigo-50" href="{{ route("services.edit", $service) }}" title="Settings">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- BODY --}}
                        <div class="px-5 pb-5 flex-1 relative">

                            {{-- Status Badge (Capsule) --}}
                            <div class="mb-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border shadow-sm transition-all duration-500
                                      {{ $service->status == "running" ? "bg-emerald-50 text-emerald-700 border-emerald-100" : ($service->status == "building" ? "bg-blue-50 text-blue-700 border-blue-100" : ($service->status == "stopping" ? "bg-amber-50 text-amber-700 border-amber-100" : ($service->status == "failed" ? "bg-rose-50 text-rose-700 border-rose-100" : "bg-slate-100 text-slate-600 border-slate-200"))) }}" id="status-badge-{{ $service->id }}">
                                    <span class="w-2 h-2 rounded-full {{ $service->status == "building" || $service->status == "stopping" ? "bg-current animate-ping" : ($service->status == "running" ? "bg-emerald-500" : "bg-slate-400") }}"></span>
                                    <span class="status-text">{{ $service->status }}</span>
                                </span>
                            </div>

                            {{-- ERROR ALERT --}}
                            <div class="{{ $service->status == "failed" ? "block" : "hidden" }} mb-4 bg-rose-50 border border-rose-100 rounded-xl p-4" id="error-alert-{{ $service->id }}">
                                <div class="flex gap-3">
                                    <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                    <div>
                                        <h4 class="text-xs font-bold text-rose-800 uppercase tracking-wide">Deployment Failed</h4>
                                        <p class="text-xs text-rose-600 mt-1 font-mono break-all leading-relaxed bg-rose-100/50 p-2 rounded-lg border border-rose-200/50" id="error-message-{{ $service->id }}">
                                            {{ $service->deployment_error ?? "Unknown error. Check logs." }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- INFO GRID --}}
                            <div class="space-y-4 {{ in_array($service->status, ["building", "stopping", "failed"]) ? "hidden" : "" }}" id="info-grid-{{ $service->id }}">

                                {{-- Internal Host --}}
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Internal Hostname</span>
                                    <div class="flex items-center group/copy cursor-pointer" onclick="navigator.clipboard.writeText('{{ Str::slug($service->name) }}'); const el=this; el.querySelector('code').classList.add('bg-emerald-100', 'text-emerald-700', 'border-emerald-200'); setTimeout(()=>el.querySelector('code').classList.remove('bg-emerald-100', 'text-emerald-700', 'border-emerald-200'), 500);">
                                        <code class="text-xs font-mono text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-1.5 rounded-lg w-full transition-colors flex justify-between items-center">
                                            {{ Str::slug($service->name) }}
                                            <svg class="w-3.5 h-3.5 text-indigo-300 group-hover/copy:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                        </code>
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5 block">Server</span>
                                        <span class="text-xs font-medium text-slate-700">{{ $service->server->name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5 block">Last Deploy</span>
                                        <span class="text-xs font-medium text-slate-700">{{ $service->last_deployed_at ? $service->last_deployed_at->diffForHumans() : "Never" }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- LOADING INDICATORS --}}
                            <div class="{{ $service->status == "building" ? "flex" : "hidden" }} flex-col justify-center items-center h-32 text-center" id="building-indicator-{{ $service->id }}">
                                <div class="relative mb-3">
                                    <div class="w-10 h-10 rounded-full border-4 border-blue-100 border-t-blue-500 animate-spin"></div>
                                </div>
                                <h4 class="text-sm font-bold text-slate-700">Deploying...</h4>
                                <p class="text-[10px] text-slate-400 mt-1">Configuring container</p>
                            </div>

                            <div class="{{ $service->status == "stopping" ? "flex" : "hidden" }} flex-col justify-center items-center h-32 text-center" id="stopping-indicator-{{ $service->id }}">
                                <div class="relative mb-3">
                                    <div class="w-10 h-10 rounded-full border-4 border-amber-100 border-t-amber-500 animate-spin"></div>
                                </div>
                                <h4 class="text-sm font-bold text-slate-700">Stopping...</h4>
                                <p class="text-[10px] text-slate-400 mt-1">Graceful shutdown</p>
                            </div>

                            {{-- Flash Overlay --}}
                            <div class="hidden absolute inset-0 bg-white/95 backdrop-blur-[1px] z-10 flex-col items-center justify-center rounded-2xl transition-opacity duration-300" id="flash-overlay-{{ $service->id }}">
                                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-2 shadow-lg animate-bounce">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-emerald-700" id="flash-message-{{ $service->id }}">Success!</span>
                            </div>
                        </div>

                        {{-- FOOTER BUTTONS --}}
                        <div class="px-5 py-4 bg-slate-50 border-t border-slate-100/50 rounded-b-2xl flex justify-between items-center mt-auto">

                            {{-- LEFT: Action (Start/Stop) --}}
                            <div class="{{ in_array($service->status, ["building", "stopping"]) ? "opacity-50 pointer-events-none" : "" }}" id="actions-{{ $service->id }}">

                                {{-- Start --}}
                                <form action="{{ route("services.deploy", $service) }}" class="deploy-service-form {{ $service->status == "running" ? "hidden" : "" }}" id="btn-start-{{ $service->id }}" method="POST">
                                    @csrf
                                    <button class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-md shadow-emerald-200" type="submit">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path clip-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" fill-rule="evenodd" />
                                        </svg>
                                        Start
                                    </button>
                                </form>

                                {{-- Redeploy --}}
                                <form action="{{ route("services.deploy", $service) }}" class="deploy-service-form {{ $service->status != "running" ? "hidden" : "" }}" id="btn-redeploy-{{ $service->id }}" method="POST">
                                    @csrf
                                    <button class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-200 rounded-lg text-xs font-bold transition shadow-sm" type="submit">
                                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                        Redeploy
                                    </button>
                                </form>
                            </div>

                            {{-- RIGHT: Tools (Logs, Console, Stop, Delete) --}}
                            <div class="flex items-center gap-1">

                                {{-- Logs --}}
                                <button class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition" onclick="window.openLogsModal('{{ $service->name }}', '{{ route("services.logs", $service) }}')" title="View Logs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l4 4a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </button>

                                {{-- Console --}}
                                <button class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition" onclick="window.openConsoleModal('{{ $service->id }}', '{{ $service->name }}', '{{ route("services.execute", $service) }}')" title="Terminal">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </button>

                                {{-- Stop (Only if Running) --}}
                                <form action="{{ route("services.stop", $service) }}" class="stop-service-form-ajax {{ $service->status != "running" ? "hidden" : "inline-block" }}" id="btn-stop-{{ $service->id }}" method="POST">
                                    @csrf
                                    <button class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition" title="Stop Service" type="submit">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path clip-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" fill-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route("services.destroy", $service) }}" class="delete-service-form inline-block ml-1 pl-1 border-l border-slate-200" method="POST">
                                    @csrf @method("DELETE")
                                    <button class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition" title="Delete Service" type="submit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- MODAL LOGS & CONSOLE (Keep Existing HTML Logic) --}}
    {{-- MODAL LOGS --}}
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 hidden transition-opacity opacity-0 flex items-center justify-center p-4" id="logsModalBackdrop">
        <div class="bg-[#1e1e1e] w-full max-w-5xl h-[80vh] rounded-xl shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-transform duration-200 ring-1 ring-white/10" id="logsModalPanel">
            <div class="flex justify-between items-center px-4 py-3 bg-[#252526] border-b border-black/50">
                <div class="flex items-center gap-3">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                    </div>
                    <span class="font-mono text-sm font-bold text-slate-400 ml-2" id="logsTitle">Service Logs</span>
                </div>
                <button class="text-slate-500 hover:text-white transition" onclick="window.closeLogsModal()"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg></button>
            </div>
            <div class="flex-1 p-4 overflow-auto bg-[#1e1e1e] font-mono text-xs leading-relaxed" id="logsContainer">
                <pre class="text-slate-300 whitespace-pre-wrap break-all" id="logsContent"></pre>
            </div>
            <div class="px-4 py-2 bg-[#007acc] text-white text-[10px] font-bold flex justify-between items-center">
                <div class="flex items-center gap-2"><span class="animate-pulse w-2 h-2 rounded-full bg-white"></span> LIVE STREAMING (Polling 3s)</div>
                <span class="opacity-80" id="logsTimestamp">--:--:--</span>
            </div>
        </div>
    </div>

    {{-- MODAL CONSOLE --}}
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 hidden transition-opacity opacity-0 flex items-center justify-center p-4" id="consoleModalBackdrop">
        <div class="bg-[#1e1e1e] w-full max-w-3xl rounded-xl shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-transform duration-200 border border-slate-700" id="consoleModalPanel">
            <div class="flex justify-between items-center px-4 py-3 bg-[#2d2d2d] border-b border-black/50">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                    <span class="font-mono text-sm font-bold text-slate-300" id="consoleTitle">Console</span>
                </div>
                <button class="text-slate-500 hover:text-white transition" onclick="window.closeConsoleModal()"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg></button>
            </div>
            <div class="flex-1 p-4 overflow-auto bg-[#1e1e1e] font-mono text-xs leading-relaxed min-h-[300px] max-h-[500px]" id="consoleOutputContainer">
                <div class="text-slate-500 mb-2"># Welcome to Keystone Console.</div>
                <pre class="text-emerald-400 whitespace-pre-wrap break-all font-mono" id="consoleOutput"></pre>
            </div>
            <div class="p-3 bg-[#2d2d2d] border-t border-black/50">
                <form class="flex gap-0" id="consoleForm" onsubmit="window.submitCommand(event)">
                    <span class="flex items-center px-3 bg-[#1e1e1e] text-emerald-500 font-mono text-sm border border-r-0 border-slate-600 rounded-l-lg">$</span>
                    <input autocomplete="off" class="flex-1 bg-[#1e1e1e] text-white font-mono text-sm border border-slate-600 rounded-r-lg px-3 py-2 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none" id="consoleInput" placeholder="e.g. php artisan migrate --force" type="text">
                    <button class="ml-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2" type="submit">
                        <span id="btnText">Run</span>
                        <svg class="w-4 h-4 animate-spin hidden" fill="none" id="btnSpin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4" stroke="currentColor"></circle>
                            <path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" fill="currentColor"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        // --- GLOBAL VARIABLES (SAMA SEPERTI SEBELUMNYA) ---
        window.pollIntervals = {};
        window.logsInterval = null;
        window.currentConsoleUrl = '';

        // --- 1. FUNGSI FLASH (TETAP) ---
        window.flashCard = function(serviceId, type) {
            const card = document.querySelector(`.service-card[data-id="${serviceId}"]`);
            const overlay = document.getElementById(`flash-overlay-${serviceId}`);
            const message = document.getElementById(`flash-message-${serviceId}`);

            if (!card) return;

            card.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            const flashClass = type === 'success' ? 'animate-flash-success' : 'animate-flash-error';
            card.classList.add(flashClass);

            if (overlay && message) {
                message.innerText = type === 'success' ? (card.dataset.status === 'running' ? 'Deployed!' : 'Stopped!') : 'Failed!';
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                setTimeout(() => {
                    overlay.classList.add('opacity-0');
                    setTimeout(() => {
                        overlay.classList.add('hidden');
                        overlay.classList.remove('flex', 'opacity-0');
                    }, 500);
                }, 2000);
            }
            setTimeout(() => {
                card.classList.remove(flashClass);
            }, 1500);
        };

        // --- 2. UPDATE UI (DISEDERHANAKAN AGAR SESUAI DESAIN BARU) ---
        window.updateServiceCardUI = function(serviceId, status, errorMsg = null) {
            const card = document.querySelector(`.service-card[data-id="${serviceId}"]`);
            if (!card) return;

            const oldStatus = card.dataset.status;
            card.dataset.status = status;

            if ((oldStatus === 'building' || oldStatus === 'stopping') && (status === 'running' || status === 'stopped' || status === 'failed')) {
                window.flashCard(serviceId, status === 'failed' ? 'error' : 'success');
            }

            // Colors & Classes Config
            const config = {
                running: {
                    card: 'bg-white ring-1 ring-emerald-500/30',
                    icon: 'bg-gradient-to-br from-emerald-400 to-emerald-600',
                    badge: 'bg-emerald-50 text-emerald-700 border-emerald-100',
                    dot: 'bg-emerald-500'
                },
                stopped: {
                    card: 'bg-slate-50 ring-1 ring-slate-200',
                    icon: 'bg-gradient-to-br from-slate-400 to-slate-500',
                    badge: 'bg-slate-100 text-slate-600 border-slate-200',
                    dot: 'bg-slate-400'
                },
                failed: {
                    card: 'bg-white ring-1 ring-rose-500/30',
                    icon: 'bg-gradient-to-br from-rose-400 to-rose-600',
                    badge: 'bg-rose-50 text-rose-700 border-rose-100',
                    dot: 'bg-rose-500'
                },
                building: {
                    card: 'bg-white ring-1 ring-blue-500/30',
                    icon: 'bg-gradient-to-br from-blue-400 to-blue-600',
                    badge: 'bg-blue-50 text-blue-700 border-blue-100',
                    dot: 'bg-current animate-ping'
                },
                stopping: {
                    card: 'bg-white ring-1 ring-amber-500/30',
                    icon: 'bg-gradient-to-br from-amber-400 to-amber-600',
                    badge: 'bg-amber-50 text-amber-700 border-amber-100',
                    dot: 'bg-current animate-ping'
                },
            };

            const current = config[status] || config['stopped'];

            // Apply Classes
            card.className = `service-card group relative flex flex-col h-full rounded-2xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/5 ${current.card}`;

            const icon = document.getElementById(`stack-icon-${serviceId}`);
            if (icon) icon.className = `h-12 w-12 rounded-2xl shadow-sm flex items-center justify-center font-bold text-sm text-white transition-colors duration-500 ${current.icon}`;

            const badge = document.getElementById(`status-badge-${serviceId}`);
            if (badge) {
                badge.className = `inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border shadow-sm transition-all duration-500 ${current.badge}`;
                badge.innerHTML = `<span class="w-2 h-2 rounded-full ${current.dot}"></span> <span class="status-text">${status}</span>`;
            }

            // Toggle Content Areas
            const infoGrid = document.getElementById(`info-grid-${serviceId}`);
            const buildInd = document.getElementById(`building-indicator-${serviceId}`);
            const stopInd = document.getElementById(`stopping-indicator-${serviceId}`);
            const actions = document.getElementById(`actions-${serviceId}`);
            const errorAlert = document.getElementById(`error-alert-${serviceId}`);
            const errorMessage = document.getElementById(`error-message-${serviceId}`);

            if (infoGrid) infoGrid.classList.add('hidden');
            if (buildInd) {
                buildInd.classList.remove('flex');
                buildInd.classList.add('hidden');
            }
            if (stopInd) {
                stopInd.classList.remove('flex');
                stopInd.classList.add('hidden');
            }
            if (actions) actions.classList.add('opacity-50', 'pointer-events-none');
            if (errorAlert) errorAlert.classList.add('hidden');

            if (status === 'building') {
                if (buildInd) {
                    buildInd.classList.remove('hidden');
                    buildInd.classList.add('flex');
                }
            } else if (status === 'stopping') {
                if (stopInd) {
                    stopInd.classList.remove('hidden');
                    stopInd.classList.add('flex');
                }
            } else if (status === 'failed') {
                if (errorAlert) {
                    errorAlert.classList.remove('hidden');
                    if (errorMsg) errorMessage.innerText = errorMsg;
                }
                if (actions) actions.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                // Normal
                if (infoGrid) infoGrid.classList.remove('hidden');
                if (actions) actions.classList.remove('opacity-50', 'pointer-events-none');
            }

            // Button Logic
            const btnStart = document.getElementById(`btn-start-${serviceId}`);
            const btnRedeploy = document.getElementById(`btn-redeploy-${serviceId}`);
            const btnStop = document.getElementById(`btn-stop-${serviceId}`);

            if (status === 'running') {
                if (btnStart) btnStart.classList.add('hidden');
                if (btnRedeploy) btnRedeploy.classList.remove('hidden');
                if (btnStop) {
                    btnStop.classList.remove('hidden');
                    btnStop.classList.add('inline-block');
                }
            } else {
                if (btnStart) btnStart.classList.remove('hidden');
                if (btnRedeploy) btnRedeploy.classList.add('hidden');
                if (btnStop) {
                    btnStop.classList.add('hidden');
                    btnStop.classList.remove('inline-block');
                }
            }
        };

        // --- 3. POLLING & MANUAL REFRESH (TETAP SAMA) ---
        window.startPolling = function(serviceId, url) {
            if (window.pollIntervals[serviceId]) return;
            window.pollIntervals[serviceId] = setInterval(() => {
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!window.pollIntervals[serviceId]) return;
                        const stableStates = ['running', 'stopped', 'failed'];
                        if (data.status === 'success' && stableStates.includes(data.new_status)) {
                            const card = document.querySelector(`.service-card[data-id="${serviceId}"]`);
                            if (card.dataset.status === 'building' || card.dataset.status === 'stopping' || card.dataset.status !== data.new_status) {
                                clearInterval(window.pollIntervals[serviceId]);
                                delete window.pollIntervals[serviceId];
                                window.updateServiceCardUI(serviceId, data.new_status, data.deployment_error);
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                if (data.new_status === 'running') Toast.fire({
                                    icon: 'success',
                                    title: 'Service is Running'
                                });
                                else if (data.new_status === 'stopped') Toast.fire({
                                    icon: 'info',
                                    title: 'Service Stopped'
                                });
                                else if (data.new_status === 'failed') Toast.fire({
                                    icon: 'error',
                                    title: 'Deployment Failed'
                                });
                            }
                        }
                    }).catch(console.error);
            }, 4000);
        };

        window.manualRefresh = function(serviceId) {
            const btn = document.getElementById(`refresh-btn-${serviceId}`);
            const card = document.querySelector(`.service-card[data-id="${serviceId}"]`);
            if (!card || !btn) return;
            btn.querySelector('svg').classList.add('animate-spin');
            fetch(card.dataset.refreshUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') window.updateServiceCardUI(serviceId, data.new_status, data.deployment_error);
                })
                .finally(() => btn.querySelector('svg').classList.remove('animate-spin'));
        };

        // --- 4. LOGS & CONSOLE (KEEP EXISTING) ---
        window.openLogsModal = function(name, url) {
            const modalBackdrop = document.getElementById('logsModalBackdrop');
            const modalPanel = document.getElementById('logsModalPanel');
            const logsContent = document.getElementById('logsContent');
            const logsTitle = document.getElementById('logsTitle');
            const logsTimestamp = document.getElementById('logsTimestamp');
            if (!modalBackdrop) return;
            modalBackdrop.classList.remove('hidden');
            setTimeout(() => {
                modalBackdrop.classList.remove('opacity-0');
                modalPanel.classList.remove('scale-95');
            }, 10);
            logsTitle.innerText = `root@keystone:~/services/${name} $ docker logs -f`;
            logsContent.innerText = "Connecting to server...\nFetching latest logs...";
            const fetchLogs = () => {
                fetch(url).then(res => res.json()).then(data => {
                    if (data.status === 'success') {
                        logsContent.innerText = data.logs || "Waiting for container logs...";
                        logsTimestamp.innerText = "Last Update: " + new Date().toLocaleTimeString();
                        const container = document.getElementById('logsContainer');
                        if (container.scrollTop + container.clientHeight >= container.scrollHeight - 200) container.scrollTop = container.scrollHeight;
                    } else {
                        logsContent.innerText = `[ERROR] Failed to fetch logs:\n${data.logs}`;
                    }
                }).catch(err => {
                    logsContent.innerText = `[CONNECTION ERROR] Could not reach Keystone server.\n${err}`;
                });
            };
            fetchLogs();
            window.logsInterval = setInterval(fetchLogs, 3000);
        };

        window.closeLogsModal = function() {
            const modalBackdrop = document.getElementById('logsModalBackdrop');
            const modalPanel = document.getElementById('logsModalPanel');
            if (window.logsInterval) clearInterval(window.logsInterval);
            if (modalBackdrop) {
                modalBackdrop.classList.add('opacity-0');
                modalPanel.classList.add('scale-95');
                setTimeout(() => {
                    modalBackdrop.classList.add('hidden');
                    document.getElementById('logsContent').innerText = "";
                }, 300);
            }
        };

        window.openConsoleModal = function(serviceId, serviceName, url) {
            window.currentConsoleUrl = url;
            const modalBackdrop = document.getElementById('consoleModalBackdrop');
            const modalPanel = document.getElementById('consoleModalPanel');
            const title = document.getElementById('consoleTitle');
            const output = document.getElementById('consoleOutput');
            const input = document.getElementById('consoleInput');
            if (!modalBackdrop) return;
            title.innerText = `root@${serviceName.toLowerCase()}:/var/www/html`;
            output.innerText = "";
            input.value = "";
            modalBackdrop.classList.remove('hidden');
            setTimeout(() => {
                modalBackdrop.classList.remove('opacity-0');
                modalPanel.classList.remove('scale-95');
                input.focus();
            }, 10);
        };

        window.closeConsoleModal = function() {
            const modalBackdrop = document.getElementById('consoleModalBackdrop');
            const modalPanel = document.getElementById('consoleModalPanel');
            if (modalBackdrop) {
                modalBackdrop.classList.add('opacity-0');
                modalPanel.classList.add('scale-95');
                setTimeout(() => {
                    modalBackdrop.classList.add('hidden');
                }, 300);
            }
        };

        window.submitCommand = function(e) {
            e.preventDefault();
            const input = document.getElementById('consoleInput');
            const output = document.getElementById('consoleOutput');
            const btnText = document.getElementById('btnText');
            const btnSpin = document.getElementById('btnSpin');
            const command = input.value.trim();
            if (!command) return;
            input.disabled = true;
            btnText.innerText = "Running...";
            btnSpin.classList.remove('hidden');
            output.innerText += `\n$ ${command}\n`;
            document.getElementById('consoleOutputContainer').scrollTop = document.getElementById('consoleOutputContainer').scrollHeight;
            fetch(window.currentConsoleUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        command: command
                    })
                })
                .then(res => res.json()).then(data => {
                    if (data.status === 'success') output.innerText += data.output + "\n";
                    else output.innerText += "[ERROR] " + data.output + "\n";
                })
                .catch(err => output.innerText += "[CONNECTION ERROR] " + err + "\n")
                .finally(() => {
                    input.disabled = false;
                    input.value = "";
                    input.focus();
                    btnText.innerText = "Run";
                    btnSpin.classList.add('hidden');
                    document.getElementById('consoleOutputContainer').scrollTop = document.getElementById('consoleOutputContainer').scrollHeight;
                });
        };

        // --- 7. EVENT LISTENERS ---
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deploy-service-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const card = this.closest('.service-card');
                    const serviceId = card.dataset.id;
                    Swal.fire({
                        title: 'Ready to Deploy?',
                        text: "Keystone will build and start your application.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Yes, Deploy!',
                        heightAuto: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.updateServiceCardUI(serviceId, 'building');
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            Toast.fire({
                                icon: 'info',
                                title: 'Deployment started in background...'
                            });
                            fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            }).catch(console.error);
                            window.startPolling(serviceId, card.dataset.refreshUrl);
                        }
                    });
                });
            });

            document.querySelectorAll('.stop-service-form-ajax').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const card = this.closest('.service-card');
                    const serviceId = card.dataset.id;
                    Swal.fire({
                        title: 'Stop Service?',
                        text: "App will be inaccessible.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f59e0b',
                        confirmButtonText: 'Yes, Stop',
                        heightAuto: false
                    }).then((res) => {
                        if (res.isConfirmed) {
                            window.updateServiceCardUI(serviceId, 'stopping');
                            fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            }).catch(console.error);
                            window.startPolling(serviceId, card.dataset.refreshUrl);
                        }
                    });
                });
            });

            document.querySelectorAll('.delete-service-form').forEach(form => form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Delete Service?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'DELETE',
                    heightAuto: false
                }).then((res) => {
                    if (res.isConfirmed) this.submit();
                });
            }));

            document.querySelectorAll('.service-card').forEach(card => {
                const status = card.dataset.status;
                if (status === 'building' || status === 'stopping') {
                    window.startPolling(card.dataset.id, card.dataset.refreshUrl);
                }
            });

            const logsBackdrop = document.getElementById('logsModalBackdrop');
            if (logsBackdrop) logsBackdrop.addEventListener('click', (e) => {
                if (e.target === logsBackdrop) window.closeLogsModal();
            });
            const consoleBackdrop = document.getElementById('consoleModalBackdrop');
            if (consoleBackdrop) consoleBackdrop.addEventListener('click', (e) => {
                if (e.target === consoleBackdrop) window.closeConsoleModal();
            });
        });
    </script>
@endpush
