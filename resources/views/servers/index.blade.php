@extends("layouts.app")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">Server Inventory</h2>
            <span class="text-slate-300 text-xl font-light">/</span>
            <p class="text-sm text-slate-500 font-medium">Infrastructure Nodes</p>
        </div>
        <a class="bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20 flex items-center gap-2" href="{{ route("servers.create") }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Connect New Server
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($servers as $server)
                <div class="bg-white rounded-xl border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:border-indigo-300 transition group p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 01-2 2v4a2 2 0 012 2h14a2 2 0 012-2v-4a2 2 0 01-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">{{ $server->name }}</h3>
                                <div class="flex items-center gap-2 text-xs text-slate-500 font-mono mt-0.5">
                                    <span>{{ $server->user }}@</span><span class="bg-slate-100 px-1 rounded">{{ $server->ip_address }}</span>
                                </div>
                            </div>
                        </div>

                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                            Active
                        </span>
                    </div>

                    <div class="border-t border-slate-100 pt-4 mt-2 flex justify-between items-center">
                        <span class="text-xs text-slate-400 font-mono">SSH Port: {{ $server->ssh_port }}</span>

                        <div class="flex items-center gap-3">
                            <a class="text-xs font-medium text-slate-600 hover:text-indigo-600 transition" href="{{ route("servers.edit", $server) }}">
                                Edit
                            </a>

                            <span class="text-slate-300">/</span>
                            <form action="{{ route("servers.destroy", $server) }}" class="inline-flex" id="delete-form-{{ $server->id }}" method="POST">
                                @csrf
                                @method("DELETE")

                                <button class="text-xs font-medium text-rose-600 hover:text-rose-700 transition" onclick="confirmDisconnect('{{ $server->id }}', '{{ $server->name }}')" type="button">
                                    Disconnect
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-slate-50 border border-dashed border-slate-300 rounded-xl p-12 text-center">
                    <p class="text-slate-500 mb-4">No servers connected yet.</p>
                    <a class="text-indigo-600 font-medium text-sm hover:underline" href="{{ route("servers.create") }}">Add your first server</a>
                </div>
            @endforelse
        </div>

        {{ $servers->links() }}
    </div>
@endsection

@push("scripts")
    <script>
        function confirmDisconnect(serverId, serverName) {
            Swal.fire({
                title: 'Disconnect Server?',
                html: `Are you sure you want to remove <b>${serverName}</b> from your inventory?<br><span class="text-sm text-slate-500">Active deployments on this server might become unmanaged.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Disconnect',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-xl border border-slate-200 shadow-xl',
                    title: 'text-slate-800 font-bold',
                    htmlContainer: 'text-slate-600',
                    confirmButton: 'rounded-lg px-4 py-2 font-medium',
                    cancelButton: 'rounded-lg px-4 py-2 font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + serverId).submit();
                }
            })
        }
    </script>
@endpush
