@extends("layouts.app")

@push("styles")
    <style>
        /* 1. Animasi Flash/Glow */
        @keyframes flash-success {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
                transform: scale(1);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
                transform: scale(1.02);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
                transform: scale(1);
            }
        }

        @keyframes flash-error {
            0% {
                box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.7);
                transform: scale(1);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(225, 29, 72, 0);
                transform: scale(1.02);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(225, 29, 72, 0);
                transform: scale(1);
            }
        }

        .animate-flash-success {
            animation: flash-success 1s ease-out;
            border-color: #10b981 !important;
            z-index: 50;
        }

        .animate-flash-error {
            animation: flash-error 1s ease-out;
            border-color: #e11d48 !important;
            z-index: 50;
        }
    </style>
@endpush

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-4">
            <a class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition" href="{{ route("projects.index") }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </a>
            <div class="h-8 w-px bg-slate-200"></div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="font-bold text-lg text-slate-800 leading-none">{{ $project->name }}</h2>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border {{ $project->environment == "production" ? "bg-rose-50 text-rose-700 border-rose-100" : ($project->environment == "staging" ? "bg-amber-50 text-amber-700 border-amber-100" : "bg-emerald-50 text-emerald-700 border-emerald-100") }}">{{ $project->environment }}</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">{{ $project->description ?? "Single server deployment" }}</p>
            </div>
        </div>
        <a class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2" href="{{ route("projects.services.create", $project) }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Add Service
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-8">
        @if ($project->services->count() == 0)
            <div class="bg-slate-50 border border-dashed border-slate-300 rounded-xl p-12 text-center">
                <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Project is empty</h3>
                <p class="text-slate-500 max-w-sm mx-auto mt-2 mb-6">Start by adding a service like a Database (Postgres/MySQL) or an Application (Node/PHP).</p>
                <a class="inline-flex items-center text-indigo-600 font-semibold text-sm hover:underline" href="{{ route("projects.services.create", $project) }}">Deploy first service &rarr;</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
                @foreach ($project->services as $service)
                    {{-- CARD CONTAINER (Updated Design: Colored Headers) --}}
                    <div class="service-card group relative flex flex-col h-full rounded-2xl border transition-all duration-300 hover:shadow-lg
                                {{ $service->status == "running" ? "border-emerald-200 bg-white" : ($service->status == "building" ? "border-blue-200 bg-white ring-2 ring-blue-100" : ($service->status == "stopping" ? "border-amber-200 bg-white ring-2 ring-amber-100" : ($service->status == "failed" ? "border-rose-200 bg-white" : "border-slate-200 bg-slate-50"))) }}" data-id="{{ $service->id }}" data-refresh-url="{{ route("services.refresh-status", $service) }}" data-status="{{ $service->status }}">

                        {{-- HEADER BAR (Warna Dinamis) --}}
                        <div class="px-5 py-4 border-b rounded-t-2xl transition-colors duration-500
                             {{ $service->status == "running" ? "bg-emerald-50/50 border-emerald-100" : ($service->status == "building" ? "bg-blue-50/50 border-blue-100" : ($service->status == "stopping" ? "bg-amber-50/50 border-amber-100" : ($service->status == "failed" ? "bg-rose-50/50 border-rose-100" : "bg-white border-slate-100"))) }}" id="card-header-{{ $service->id }}">

                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    {{-- Icon Stack --}}
                                    <div class="h-10 w-10 rounded-xl shadow-sm flex items-center justify-center font-bold text-sm text-white transition-colors duration-500
                                                {{ $service->status == "running" ? "bg-emerald-500" : ($service->status == "building" ? "bg-blue-500" : ($service->status == "stopping" ? "bg-amber-500" : ($service->status == "failed" ? "bg-rose-500" : "bg-slate-400"))) }}" id="stack-icon-{{ $service->id }}">
                                        {{ substr($service->stack->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 text-base leading-tight">{{ $service->name }}</h3>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $service->stack->name }}</p>
                                    </div>
                                </div>

                                {{-- Status Pill --}}
                                <div class="flex items-center gap-2">
                                    <button class="text-slate-400 hover:text-indigo-600 transition p-1.5 rounded-full hover:bg-white" id="refresh-btn-{{ $service->id }}" onclick="window.manualRefresh('{{ $service->id }}')" title="Check Status">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </button>

                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border shadow-sm transition-all duration-500 flex items-center gap-1.5
                                          {{ $service->status == "running" ? "bg-white text-emerald-700 border-emerald-200" : ($service->status == "building" ? "bg-white text-blue-700 border-blue-200" : ($service->status == "stopping" ? "bg-white text-amber-700 border-amber-200" : ($service->status == "failed" ? "bg-white text-rose-700 border-rose-200" : "bg-white text-slate-600 border-slate-200"))) }}" id="status-badge-{{ $service->id }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $service->status == "building" || $service->status == "stopping" ? "bg-current animate-ping" : ($service->status == "running" ? "bg-emerald-500" : "bg-slate-400") }}"></span>
                                        <span class="status-text">{{ $service->status }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- BODY --}}
                        <div class="p-5 flex-1 relative">
                            {{-- Info Grid (Tampil jika Normal) --}}
                            <div class="space-y-3 {{ in_array($service->status, ["building", "stopping"]) ? "hidden" : "" }}" id="info-grid-{{ $service->id }}">
                                {{-- Info Grid (Normal View) --}}
                                <div class="space-y-3 {{ in_array($service->status, ["building", "stopping"]) ? "hidden" : "" }}" id="info-grid-{{ $service->id }}">
                                    <div class="flex justify-between text-xs border-b border-dashed border-slate-100 pb-2">
                                        <span class="text-slate-400">Server</span>
                                        <span class="font-mono font-medium text-slate-600">{{ $service->server->name }}</span>
                                    </div>

                                    {{-- PERBAIKAN: Ganti Public Port dengan Internal Hostname --}}
                                    <div class="flex justify-between text-xs border-b border-dashed border-slate-100 pb-2">
                                        <span class="text-slate-400" title="Gunakan nama ini untuk koneksi antar container">Internal Host</span>
                                        <div class="flex items-center gap-1">
                                            <span class="font-mono font-medium text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded select-all cursor-pointer" onclick="navigator.clipboard.writeText('{{ Str::slug($service->name) }}'); const el=this; el.classList.add('bg-emerald-100', 'text-emerald-700'); setTimeout(()=>el.classList.remove('bg-emerald-100', 'text-emerald-700'), 500);" title="Click to Copy">
                                                {{ Str::slug($service->name) }}
                                            </span>
                                        </div>
                                    </div>
                                    {{-- END PERBAIKAN --}}

                                    <div class="flex justify-between text-xs">
                                        <span class="text-slate-400">Last Deploy</span>
                                        <span class="font-medium text-slate-600">{{ $service->last_deployed_at ? $service->last_deployed_at->diffForHumans() : "Never" }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Building Indicator (Tampil jika Deploying) --}}
                            <div class="{{ $service->status == "building" ? "flex" : "hidden" }} flex-col justify-center items-center h-full min-h-[100px] text-center" id="building-indicator-{{ $service->id }}">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-full border-4 border-blue-100 border-t-blue-500 animate-spin mb-3"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </div>
                                </div>
                                <h4 class="text-sm font-bold text-slate-700">Deploying...</h4>
                                <p class="text-[10px] text-slate-400 mt-1 px-4">Configuring container & running build scripts.</p>
                            </div>

                            {{-- Stopping Indicator (BARU: Tampil jika Stopping) --}}
                            <div class="{{ $service->status == "stopping" ? "flex" : "hidden" }} flex-col justify-center items-center h-full min-h-[100px] text-center" id="stopping-indicator-{{ $service->id }}">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-full border-4 border-amber-100 border-t-amber-500 animate-spin mb-3"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            <path d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </div>
                                </div>
                                <h4 class="text-sm font-bold text-slate-700">Stopping...</h4>
                                <p class="text-[10px] text-slate-400 mt-1 px-4">Gracefully shutting down container.</p>
                            </div>

                            {{-- FLASH OVERLAY (Pesan Sukses di Tengah Card) --}}
                            <div class="hidden absolute inset-0 bg-white/90 backdrop-blur-[2px] z-10 flex-col items-center justify-center rounded-b-2xl transition-opacity duration-500" id="flash-overlay-{{ $service->id }}">
                                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-2 shadow-lg scale-110">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-emerald-700" id="flash-message-{{ $service->id }}">Success!</span>
                            </div>
                        </div>

                        {{-- FOOTER BUTTONS --}}
                        <div class="px-5 py-4 bg-slate-50/50 border-t border-slate-100 rounded-b-2xl flex justify-between items-center gap-3 mt-auto">
                            <div class="flex-1">
                                <div class="{{ in_array($service->status, ["building", "stopping"]) ? "hidden" : "flex items-center gap-2" }}" id="actions-{{ $service->id }}">

                                    {{-- Start --}}
                                    <form action="{{ route("services.deploy", $service) }}" class="deploy-service-form w-full {{ $service->status == "running" ? "hidden" : "" }}" id="btn-start-{{ $service->id }}" method="POST">
                                        @csrf
                                        <button class="w-full py-1.5 px-3 bg-white border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 rounded-lg text-xs font-bold transition shadow-sm flex justify-center items-center gap-2" type="submit">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path clip-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" fill-rule="evenodd" />
                                            </svg> Start
                                        </button>
                                    </form>

                                    {{-- Redeploy --}}
                                    <form action="{{ route("services.deploy", $service) }}" class="deploy-service-form w-full {{ $service->status != "running" ? "hidden" : "" }}" id="btn-redeploy-{{ $service->id }}" method="POST">
                                        @csrf
                                        <button class="w-full py-1.5 px-3 bg-white border border-slate-200 hover:border-amber-300 hover:bg-amber-50 text-slate-600 hover:text-amber-700 rounded-lg text-xs font-bold transition shadow-sm flex justify-center items-center gap-2" type="submit">
                                            <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg> Redeploy
                                        </button>
                                    </form>

                                    {{-- Stop (DIPERBAIKI: Pakai AJAX Class khusus 'stop-service-form-ajax') --}}
                                    <form action="{{ route("services.stop", $service) }}" class="stop-service-form-ajax w-auto {{ $service->status != "running" ? "hidden" : "" }}" id="btn-stop-{{ $service->id }}" method="POST">
                                        @csrf
                                        <button class="py-1.5 px-3 bg-white border border-slate-200 hover:border-rose-300 hover:bg-rose-50 text-slate-600 hover:text-rose-700 rounded-lg text-xs font-bold transition shadow-sm" title="Stop Service" type="submit">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path clip-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" fill-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 border-l border-slate-200 pl-3">
                                <button class="text-slate-400 hover:text-indigo-600 transition" onclick="window.openLogsModal('{{ $service->name }}', '{{ route("services.logs", $service) }}')" title="Logs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l4 4a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </button>
                                <a class="text-slate-400 hover:text-indigo-600 transition" href="{{ route("services.edit", $service) }}" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </a>
                                <form action="{{ route("services.destroy", $service) }}" class="inline-flex delete-service-form" method="POST">
                                    @csrf @method("DELETE")
                                    <button class="text-slate-400 hover:text-rose-600 transition" title="Delete" type="submit">
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

    {{-- MODAL LOGS (TETAP ADA) --}}
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 hidden transition-opacity opacity-0 flex items-center justify-center p-4" id="logsModalBackdrop">
        <div class="bg-[#1e1e1e] w-full max-w-5xl h-[80vh] rounded-xl shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-transform duration-200" id="logsModalPanel">
            <div class="flex justify-between items-center px-4 py-3 bg-[#252526] border-b border-black/20">
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
@endsection

@push("scripts")
    <script>
        // --- GLOBAL VARIABLES ---
        window.pollIntervals = {};
        window.logsInterval = null;

        // --- 1. FUNGSI FLASH ANIMATION (BARU) ---
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

        // --- 2. UPDATE UI (Handling: Building, Stopping, Running, Failed) ---
        window.updateServiceCardUI = function(serviceId, status) {
            const card = document.querySelector(`.service-card[data-id="${serviceId}"]`);
            if (!card) return;

            const oldStatus = card.dataset.status;
            card.dataset.status = status;

            // Trigger flash if status changes from transition to stable
            if ((oldStatus === 'building' || oldStatus === 'stopping') && (status === 'running' || status === 'stopped' || status === 'failed')) {
                window.flashCard(serviceId, status === 'failed' ? 'error' : 'success');
            }

            // --- COLORS & CLASSES ---
            const colors = {
                running: {
                    bg: 'bg-emerald-50/50',
                    border: 'border-emerald-100',
                    icon: 'bg-emerald-500',
                    text: 'text-emerald-700',
                    badge_border: 'border-emerald-200'
                },
                stopped: {
                    bg: 'bg-white',
                    border: 'border-slate-100',
                    icon: 'bg-slate-400',
                    text: 'text-slate-600',
                    badge_border: 'border-slate-200'
                },
                failed: {
                    bg: 'bg-rose-50/50',
                    border: 'border-rose-100',
                    icon: 'bg-rose-500',
                    text: 'text-rose-700',
                    badge_border: 'border-rose-200'
                },
                building: {
                    bg: 'bg-blue-50/50',
                    border: 'border-blue-100',
                    icon: 'bg-blue-500',
                    text: 'text-blue-700',
                    badge_border: 'border-blue-200'
                },
                stopping: {
                    bg: 'bg-amber-50/50',
                    border: 'border-amber-100',
                    icon: 'bg-amber-500',
                    text: 'text-amber-700',
                    badge_border: 'border-amber-200'
                },
            };

            const current = colors[status] || colors['stopped'];

            // Update Header & Icon
            const header = document.getElementById(`card-header-${serviceId}`);
            const icon = document.getElementById(`stack-icon-${serviceId}`);

            if (header) header.className = `px-5 py-4 border-b rounded-t-2xl transition-colors duration-500 ${current.bg} ${current.border}`;
            if (icon) icon.className = `h-10 w-10 rounded-xl shadow-sm flex items-center justify-center font-bold text-sm text-white transition-colors duration-500 ${current.icon}`;

            // Update Badge
            const badge = document.getElementById(`status-badge-${serviceId}`);
            if (badge) {
                let dotClass = (status === 'building' || status === 'stopping') ? 'bg-current animate-ping' : current.icon;
                if (status === 'stopped') dotClass = 'bg-slate-400';

                badge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full ${dotClass}"></span> <span class="status-text">${status}</span>`;
                badge.className = `text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border shadow-sm transition-all duration-500 flex items-center gap-1.5 bg-white ${current.text} ${current.badge_border}`;
            }

            // --- TOGGLE CONTENT ---
            const infoGrid = document.getElementById(`info-grid-${serviceId}`);
            const buildInd = document.getElementById(`building-indicator-${serviceId}`);
            const stopInd = document.getElementById(`stopping-indicator-${serviceId}`);
            const actions = document.getElementById(`actions-${serviceId}`);

            // Reset
            if (infoGrid) infoGrid.classList.add('hidden');
            if (buildInd) {
                buildInd.classList.remove('flex');
                buildInd.classList.add('hidden');
            }
            if (stopInd) {
                stopInd.classList.remove('flex');
                stopInd.classList.add('hidden');
            }
            if (actions) actions.classList.add('hidden');

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
            } else {
                // Normal State
                if (infoGrid) infoGrid.classList.remove('hidden');
                if (actions) actions.classList.remove('hidden');

                // Buttons Logic
                const btnStart = document.getElementById(`btn-start-${serviceId}`);
                const btnRedeploy = document.getElementById(`btn-redeploy-${serviceId}`);
                const btnStop = document.getElementById(`btn-stop-${serviceId}`);

                if (status === 'running') {
                    if (btnStart) btnStart.classList.add('hidden');
                    if (btnRedeploy) btnRedeploy.classList.remove('hidden');
                    if (btnStop) btnStop.classList.remove('hidden');
                } else {
                    if (btnStart) btnStart.classList.remove('hidden');
                    if (btnRedeploy) btnRedeploy.classList.add('hidden');
                    if (btnStop) btnStop.classList.add('hidden');
                }
            }
        };

        // --- 3. POLLING SYSTEM ---
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
                        // Stop polling only if status becomes STABLE and matches UI update
                        if (data.status === 'success' && stableStates.includes(data.new_status)) {
                            // Cek apakah UI saat ini masih 'building' atau 'stopping'. Jika ya, update.
                            // Jika tidak, biarkan saja (mungkin user sudah manual refresh)
                            const card = document.querySelector(`.service-card[data-id="${serviceId}"]`);
                            if (card.dataset.status === 'building' || card.dataset.status === 'stopping') {
                                clearInterval(window.pollIntervals[serviceId]);
                                delete window.pollIntervals[serviceId];
                                window.updateServiceCardUI(serviceId, data.new_status);

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
                            }
                        }
                    }).catch(console.error);
            }, 4000);
        };

        // --- 4. MANUAL REFRESH ---
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
                    if (data.status === 'success') window.updateServiceCardUI(serviceId, data.new_status);
                })
                .finally(() => btn.querySelector('svg').classList.remove('animate-spin'));
        };

        // --- 5. LOGS FUNCTIONS (KEMBALI KE VERSI ASLI YANG LENGKAP) ---
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

        // --- 6. EVENT LISTENERS ---
        document.addEventListener('DOMContentLoaded', function() {
            // Deploy Forms
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
                        confirmButtonText: 'Yes, Deploy!'
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

            // STOP Forms (UPDATED AJAX)
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
                        confirmButtonText: 'Yes, Stop'
                    }).then((res) => {
                        if (res.isConfirmed) {
                            window.updateServiceCardUI(serviceId, 'stopping'); // UI langsung berubah
                            fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            }).catch(console.error);
                            window.startPolling(serviceId, card.dataset.refreshUrl); // Mulai cek status
                        }
                    });
                });
            });

            // Delete Forms
            document.querySelectorAll('.delete-service-form').forEach(form => form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Delete Service?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'DELETE'
                }).then((res) => {
                    if (res.isConfirmed) this.submit();
                });
            }));

            // Init Polling for Active Transitions
            document.querySelectorAll('.service-card').forEach(card => {
                const status = card.dataset.status;
                if (status === 'building' || status === 'stopping') {
                    window.startPolling(card.dataset.id, card.dataset.refreshUrl);
                }
            });

            const backdrop = document.getElementById('logsModalBackdrop');
            if (backdrop) backdrop.addEventListener('click', (e) => {
                if (e.target === backdrop) window.closeLogsModal();
            });
        });
    </script>
@endpush
