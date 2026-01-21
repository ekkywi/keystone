@extends("layouts.app")

@section("title", "Stack Templates")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">Stack Templates</h2>
            <div class="h-6 w-px bg-slate-200 mx-2"></div>
            <p class="text-sm text-slate-500 font-medium">Service Catalog</p>
        </div>
        <a class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" href="{{ route("stacks.create") }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Create Master Stack
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-8 pb-12">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($stacks as $stack)
                {{-- LOGIC DETEKSI TIPE --}}
                @php
                    $isCache = $stack->type == "cache" || Str::contains(strtolower($stack->name), "redis");
                    $isDb = $stack->type == "database";
                    $isApp = $stack->type == "application";
                    // Jika bukan ketiganya, dianggap 'service' (Generic)
                @endphp

                <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-100 transition-all duration-300 relative flex flex-col h-full hover:-translate-y-1">

                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-4">

                            {{-- ICON GRADIENT --}}
                            <div class="h-12 w-12 rounded-xl flex items-center justify-center font-bold text-white shadow-sm transition-colors duration-300
                                {{ $isApp ? "bg-gradient-to-br from-indigo-400 to-indigo-600" : ($isCache ? "bg-gradient-to-br from-rose-400 to-rose-600" : ($isDb ? "bg-gradient-to-br from-amber-400 to-amber-600" : "bg-gradient-to-br from-slate-400 to-slate-600")) }}">

                                @if ($isApp)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                @elseif ($isCache)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                @elseif ($isDb)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                @else
                                    {{-- Generic Service Icon --}}
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                @endif
                            </div>

                            {{-- BADGE TYPE --}}
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border 
                                {{ $isApp ? "bg-indigo-50 text-indigo-700 border-indigo-100" : ($isCache ? "bg-rose-50 text-rose-700 border-rose-100" : ($isDb ? "bg-amber-50 text-amber-700 border-amber-100" : "bg-slate-50 text-slate-600 border-slate-100")) }}">
                                {{ $isCache ? "CACHE" : ucfirst($stack->type) }}
                            </span>
                        </div>

                        <h3 class="font-bold text-slate-800 text-lg mb-2 group-hover:text-indigo-600 transition-colors">{{ $stack->name }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 min-h-[2.5rem]">
                            {{ $stack->description ?? "Standard configuration template." }}
                        </p>
                    </div>

                    {{-- FOOTER --}}
                    <div class="px-6 py-4 mt-auto border-t border-slate-50 bg-slate-50/50 rounded-b-2xl flex justify-between items-center">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 6h16M4 12h16M4 18h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            {{ $stack->variables()->count() }} Inputs
                        </div>

                        <div class="flex items-center gap-1 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">
                            {{-- Edit --}}
                            <a class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-lg transition" href="{{ route("stacks.edit", $stack) }}" title="Edit Template">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route("stacks.destroy", $stack) }}" class="block" id="delete-stack-{{ $stack->id }}" method="POST">
                                @csrf @method("DELETE")
                                <button class="p-2 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition" onclick="confirmDeleteStack('{{ $stack->id }}', '{{ $stack->name }}')" title="Delete Template" type="button">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
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
                        <div class="absolute inset-0 bg-indigo-50 rounded-full animate-pulse opacity-50"></div>
                        <svg class="w-10 h-10 text-indigo-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">No templates yet</h3>
                    <p class="text-slate-500 max-w-md mt-2 mb-8 leading-relaxed">
                        Start by creating a Stack Template to standardize your service deployments (e.g., Node.js, Postgres).
                    </p>
                    <a class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20" href="{{ route("stacks.create") }}">
                        Create First Stack
                    </a>
                </div>
            @endforelse
        </div>

        {{ $stacks->links() }}
    </div>
@endsection

@push("scripts")
    <script>
        function confirmDeleteStack(stackId, stackName) {
            Swal.fire({
                title: 'Delete Template?',
                html: `Are you sure you want to delete <b>${stackName}</b>?<br><span class="text-sm text-slate-500 mt-2 block">Projects already using this stack will NOT be affected.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete',
                heightAuto: false,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-stack-' + stackId).submit();
                }
            })
        }
    </script>
@endpush
