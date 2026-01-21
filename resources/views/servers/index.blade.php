@extends("layouts.app")

@section("title", "Server Inventory")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">Server Inventory</h2>
            <div class="h-6 w-px bg-slate-200 mx-2"></div>
            <p class="text-sm text-slate-500 font-medium">Infrastructure Nodes</p>
        </div>

        <a class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" href="{{ route("servers.create") }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Connect New Server
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-8 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($servers as $server)
                {{-- SERVER CARD --}}
                <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300 relative flex flex-col h-full hover:-translate-y-1">

                    {{-- HEADER --}}
                    <div class="p-6 pb-4 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            {{-- Icon Gradient --}}
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-violet-500 to-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 01-2 2v4a2 2 0 012 2h14a2 2 0 012-2v-4a2 2 0 01-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>

                            {{-- Status Badge --}}
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        </div>

                        {{-- Title & Details --}}
                        <h3 class="font-bold text-slate-800 text-lg mb-1">{{ $server->name }}</h3>

                        <div class="flex flex-col gap-1 mb-4">
                            <div class="flex items-center gap-2 text-xs text-slate-500 font-mono">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                                {{ $server->ip_address }}
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500 font-mono">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                                {{ $server->user }} <span class="text-slate-300">|</span> Port: {{ $server->ssh_port }}
                            </div>
                        </div>

                        <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 min-h-[2.5rem] border-t border-dashed border-slate-100 pt-3">
                            {{ $server->description ?? "No description provided." }}
                        </p>
                    </div>

                    {{-- FOOTER --}}
                    <div class="px-6 py-4 mt-auto border-t border-slate-50 bg-slate-50/50 rounded-b-2xl flex justify-between items-center">

                        {{-- LEFT: Test Connection --}}
                        <button class="flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-indigo-600 transition group/test" id="btn-test-{{ $server->id }}" onclick="testConnection('{{ $server->id }}', '{{ route("servers.test-connection", $server) }}')">
                            <svg class="w-4 h-4 text-slate-400 group-hover/test:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            <span>Test Connection</span>
                        </button>

                        {{-- RIGHT: Actions --}}
                        <div class="flex items-center gap-1 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">
                            {{-- Edit --}}
                            <a class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition" href="{{ route("servers.edit", $server) }}" title="Edit Server">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route("servers.destroy", $server) }}" class="delete-server-form block" method="POST">
                                @csrf @method("DELETE")
                                <button class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition" title="Disconnect" type="submit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                {{-- EMPTY STATE --}}
                <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100 mb-6 relative">
                        <div class="absolute inset-0 bg-violet-50 rounded-full animate-pulse opacity-50"></div>
                        <svg class="w-10 h-10 text-violet-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 01-2 2v4a2 2 0 012 2h14a2 2 0 012-2v-4a2 2 0 01-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">No servers connected</h3>
                    <p class="text-slate-500 max-w-md mt-2 mb-8 leading-relaxed">
                        Connect a VPS or dedicated server to start deploying your applications.
                    </p>
                    <a class="bg-slate-900 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20" href="{{ route("servers.create") }}">
                        Connect First Server
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $servers->links() }}
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        // FUNGSI TEST CONNECTION
        function testConnection(serverId, url) {
            const btn = document.getElementById(`btn-test-${serverId}`);
            const originalText = btn.innerHTML;

            // 1. Loading State
            btn.disabled = true;
            btn.innerHTML = `<svg class="w-4 h-4 animate-spin text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span class="text-indigo-600">Testing...</span>`;

            // 2. Fetch Request
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
                        // 3. Success Alert (Table View)
                        let detailsHtml = '<div class="text-left bg-slate-50 p-4 rounded-lg border border-slate-200 font-mono text-xs space-y-2">';
                        for (const [key, value] of Object.entries(data.details)) {
                            detailsHtml += `<div class="flex justify-between"><span class="text-slate-500">${key}:</span> <span class="font-bold text-slate-700">${value}</span></div>`;
                        }
                        detailsHtml += '</div>';

                        Swal.fire({
                            title: 'Connection Successful!',
                            html: detailsHtml,
                            icon: 'success',
                            confirmButtonText: 'Great',
                            confirmButtonColor: '#10b981',
                            heightAuto: false,
                            customClass: {
                                popup: 'rounded-2xl'
                            }
                        });
                    } else {
                        // 4. Error Alert
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Connection Failed',
                        text: error.message || "Could not reach the server via SSH.",
                        icon: 'error',
                        confirmButtonColor: '#e11d48',
                        heightAuto: false,
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    });
                })
                .finally(() => {
                    // 5. Reset Button
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        }

        // FUNGSI DELETE CONFIRMATION
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-server-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Disconnect Server?',
                        text: "Active deployments on this server might become unmanaged.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Disconnect',
                        heightAuto: false,
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl',
                            cancelButton: 'rounded-xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
