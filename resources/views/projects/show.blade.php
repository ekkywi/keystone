@extends("layouts.app")

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
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border 
                        {{ $project->environment == "production" ? "bg-rose-50 text-rose-700 border-rose-100" : ($project->environment == "staging" ? "bg-amber-50 text-amber-700 border-amber-100" : "bg-emerald-50 text-emerald-700 border-emerald-100") }}">
                        {{ $project->environment }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">{{ $project->description ?? "Single server deployment" }}</p>
            </div>
        </div>

        <a class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2" href="{{ route("projects.services.create", $project) }}"> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <p class="text-slate-500 max-w-sm mx-auto mt-2 mb-6">
                    Start by adding a service like a Database (Postgres/MySQL) or an Application (Node/PHP).
                </p>
                <a class="inline-flex items-center text-indigo-600 font-semibold text-sm hover:underline" href="{{ route("projects.services.create", $project) }}">
                    Deploy first service &rarr;
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($project->services as $service)
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:border-indigo-400 transition group relative overflow-hidden">

                        <div class="absolute top-0 inset-x-0 h-1 
                            {{ $service->status == "running" ? "bg-emerald-500" : ($service->status == "failed" ? "bg-rose-500" : "bg-slate-300") }}">
                        </div>

                        <div class="p-5">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-slate-50 text-slate-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($service->stack->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800">{{ $service->name }}</h3>
                                        <p class="text-xs text-slate-500">{{ $service->stack->name }}</p>
                                    </div>
                                </div>

                                {{-- BAGIAN STATUS & REFRESH (UPDATED) --}}
                                <div class="flex flex-col items-end gap-1">

                                    <div class="flex items-center gap-2">
                                        {{-- TOMBOL REFRESH --}}
                                        <button class="text-slate-400 hover:text-indigo-600 transition p-1 rounded-full hover:bg-slate-100" id="refresh-btn-{{ $service->id }}" onclick="refreshServiceStatus('{{ $service->id }}', '{{ route("services.refresh-status", $service) }}')" title="Check Realtime Status from Server">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                        </button>

                                        {{-- STATUS BADGE --}}
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md border 
                                            {{ $service->status == "running" ? "bg-emerald-50 text-emerald-700 border-emerald-100" : "bg-slate-50 text-slate-700 border-slate-100" }}" id="status-badge-{{ $service->id }}">
                                            {{ $service->status }}
                                        </span>
                                    </div>

                                    @if ($service->last_deployed_at && $service->updated_at->gt($service->last_deployed_at))
                                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded flex items-center gap-1 animate-pulse" title="Configuration changed. Click Redeploy to apply.">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                            Changes Pending
                                        </span>
                                    @endif
                                </div>
                                {{-- END BAGIAN STATUS --}}

                            </div>

                            <div class="grid grid-cols-2 gap-y-2 text-xs text-slate-500 mt-4 border-t border-slate-50 pt-4">
                                <div>
                                    <span class="block text-slate-400 mb-0.5">Target Server</span>
                                    <span class="font-mono text-slate-700">{{ $service->server->name }}</span>
                                </div>
                                <div>
                                    <span class="block text-slate-400 mb-0.5">Public Port</span>
                                    <span class="font-mono text-slate-700">{{ $service->public_port ?? "-" }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER CARD --}}
                        <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex justify-between items-center">

                            <div class="flex items-center gap-2">
                                @if ($service->status !== "building")
                                    <form action="{{ route("services.deploy", $service) }}" class="deploy-service-form" method="POST">
                                        @csrf

                                        @if ($service->status == "running")
                                            <button class="text-xs font-bold text-amber-600 hover:text-amber-800 transition flex items-center gap-1" title="Apply new configuration" type="submit">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                </svg>
                                                Redeploy
                                            </button>
                                        @else
                                            <button class="text-xs font-bold text-emerald-600 hover:text-emerald-800 transition flex items-center gap-1" type="submit">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                    <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                </svg>
                                                Start
                                            </button>
                                        @endif
                                    </form>
                                @endif

                                @if ($service->status !== "building")
                                    <button class="text-xs font-bold text-slate-500 hover:text-indigo-600 transition flex items-center gap-1 mx-3" onclick="openLogsModal('{{ $service->name }}', '{{ route("services.logs", $service) }}')" title="View Container Logs" type="button">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                        Logs
                                    </button>
                                @endif

                                @if (in_array($service->status, ["running", "building"]))
                                    <form action="{{ route("services.stop", $service) }}" class="stop-service-form" method="POST">
                                        @csrf
                                        <button class="text-xs font-bold text-rose-600 hover:text-rose-800 transition flex items-center gap-1" type="submit">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                            Stop
                                        </button>
                                    </form>
                                @endif

                                <div class="h-3 w-px bg-slate-300 mx-1"></div>

                                <div class="flex items-center gap-1">
                                    <a class="text-slate-400 hover:text-indigo-600 transition p-1" href="{{ route("services.edit", $service) }}" title="Edit Configuration">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </a>

                                    <form action="{{ route("services.destroy", $service) }}" class="inline-flex delete-service-form" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button class="text-slate-400 hover:text-rose-600 transition" title="Delete Service" type="submit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <span class="text-[10px] text-slate-400 font-mono">{{ $service->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection

@push("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ... SweetAlert Deployment, Stop, Delete (sama seperti sebelumnya) ...
            const deployForms = document.querySelectorAll('.deploy-service-form');
            deployForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Ready to Deploy?',
                        text: "Keystone will connect to the server and start the container.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Deploy it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Deploying...',
                                text: 'Please wait while we set up your container.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            this.submit();
                        }
                    });
                });
            });

            const stopForms = document.querySelectorAll('.stop-service-form');
            stopForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Stop Service?',
                        text: "The application will stop running and become inaccessible.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f59e0b',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Stop it',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            const deleteForms = document.querySelectorAll('.delete-service-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Delete Service?',
                        text: "WARNING: This will remove the container and DELETE DATA permanently!",
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, DELETE it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

        });
    </script>

    {{-- MODAL LOGS --}}
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
                <button class="text-slate-500 hover:text-white transition" onclick="closeLogsModal()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 p-4 overflow-auto bg-[#1e1e1e] font-mono text-xs leading-relaxed" id="logsContainer">
                <pre class="text-slate-300 whitespace-pre-wrap break-all" id="logsContent"></pre>
            </div>
            <div class="px-4 py-2 bg-[#007acc] text-white text-[10px] font-bold flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="animate-pulse w-2 h-2 rounded-full bg-white"></span>
                    LIVE STREAMING (Polling 3s)
                </div>
                <span class="opacity-80" id="logsTimestamp">--:--:--</span>
            </div>
        </div>
    </div>

    {{-- SCRIPT: LOGS & STATUS REFRESH --}}
    <script>
        // --- LOGS LOGIC ---
        let logsInterval;
        const modalBackdrop = document.getElementById('logsModalBackdrop');
        const modalPanel = document.getElementById('logsModalPanel');
        const logsContent = document.getElementById('logsContent');
        const logsTitle = document.getElementById('logsTitle');
        const logsTimestamp = document.getElementById('logsTimestamp');

        function openLogsModal(name, url) {
            modalBackdrop.classList.remove('hidden');
            setTimeout(() => {
                modalBackdrop.classList.remove('opacity-0');
                modalPanel.classList.remove('scale-95');
            }, 10);

            logsTitle.innerText = `root@keystone:~/services/${name} $ docker logs -f`;
            logsContent.innerText = "Connecting to server...\nFetching latest logs...";

            const fetchLogs = () => {
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            logsContent.innerText = data.logs || "No logs available yet (Container starting...).";
                            logsTimestamp.innerText = "Last Update: " + new Date().toLocaleTimeString();
                        } else {
                            logsContent.innerText = `[ERROR] Failed to fetch logs:\n${data.logs}`;
                        }
                    })
                    .catch(err => {
                        logsContent.innerText = `[CONNECTION ERROR] Could not reach Keystone server.\n${err}`;
                    });
            };

            fetchLogs();
            logsInterval = setInterval(fetchLogs, 3000);
        }

        function closeLogsModal() {
            if (logsInterval) clearInterval(logsInterval);
            modalBackdrop.classList.add('opacity-0');
            modalPanel.classList.add('scale-95');
            setTimeout(() => {
                modalBackdrop.classList.add('hidden');
                logsContent.innerText = "";
            }, 300);
        }

        modalBackdrop.addEventListener('click', function(e) {
            if (e.target === modalBackdrop) {
                closeLogsModal();
            }
        });

        // --- NEW: REFRESH STATUS LOGIC ---
        function refreshServiceStatus(serviceId, url) {
            const btn = document.getElementById(`refresh-btn-${serviceId}`);
            const badge = document.getElementById(`status-badge-${serviceId}`);
            const icon = btn.querySelector('svg');

            // 1. Animasi Loading
            icon.classList.add('animate-spin');
            btn.disabled = true;

            // 2. Fetch ke Server
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // 3. Update Text & Warna Badge
                        badge.innerText = data.new_status;

                        if (data.new_status === 'running') {
                            badge.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md border transition-colors duration-300 bg-emerald-50 text-emerald-700 border-emerald-100";
                        } else {
                            badge.className = "text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md border transition-colors duration-300 bg-slate-50 text-slate-700 border-slate-100";
                        }

                        // Toast
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Status synced: ' + data.new_status
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('Error', 'Connection failed', 'error');
                })
                .finally(() => {
                    // 5. Matikan Animasi
                    icon.classList.remove('animate-spin');
                    btn.disabled = false;
                });
        }
    </script>
@endpush
