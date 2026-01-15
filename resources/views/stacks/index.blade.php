@extends("layouts.app")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">Stack Templates</h2>
            <span class="text-slate-300 text-xl font-light">/</span>
            <p class="text-sm text-slate-500 font-medium">Service Catalog</p>
        </div>
        <a class="bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20 flex items-center gap-2" href="{{ route("stacks.create") }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Create Master Stack
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-6">

        {{-- Nanti bisa ditambah fitur search di sini --}}

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($stacks as $stack)
                <div class="bg-white rounded-xl border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:border-indigo-300 transition group flex flex-col h-full">

                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <div class="h-10 w-10 rounded-lg {{ $stack->type == "database" ? "bg-amber-50 text-amber-600" : ($stack->type == "app" ? "bg-indigo-50 text-indigo-600" : "bg-slate-100 text-slate-600") }} flex items-center justify-center">
                                @if ($stack->type == "database")
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                @elseif($stack->type == "app")
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                @endif
                            </div>

                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md border 
                                {{ $stack->type == "database" ? "bg-amber-50 text-amber-700 border-amber-100" : ($stack->type == "app" ? "bg-indigo-50 text-indigo-700 border-indigo-100" : "bg-slate-50 text-slate-600 border-slate-100") }}">
                                {{ $stack->type }}
                            </span>
                        </div>

                        <h3 class="font-bold text-slate-800 text-lg mb-1">{{ $stack->name }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $stack->description ?? "No description provided." }}
                        </p>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/50 rounded-b-xl flex justify-between items-center">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            {{ $stack->variables()->count() }} Inputs
                        </div>

                        <div class="flex items-center gap-3">
                            <a class="text-xs font-semibold text-slate-600 hover:text-indigo-600 transition" href="{{ route("stacks.edit", $stack) }}">
                                Edit
                            </a>
                            <form action="{{ route("stacks.destroy", $stack) }}" id="delete-stack-{{ $stack->id }}" method="POST">
                                @csrf @method("DELETE")
                                <button class="text-xs font-semibold text-rose-600 hover:text-rose-700" onclick="confirmDeleteStack('{{ $stack->id }}', '{{ $stack->name }}')" type="button">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-slate-50 border border-dashed border-slate-300 rounded-xl p-12 text-center">
                    <div class="mx-auto w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900">No templates yet</h3>
                    <p class="text-slate-500 mb-4 mt-1 max-w-sm mx-auto">Get started by defining your first service stack like Postgres, Redis, or Node.js app.</p>
                    <a class="inline-flex items-center text-indigo-600 font-semibold text-sm hover:underline" href="{{ route("stacks.create") }}">
                        Create first stack &rarr;
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
                html: `Are you sure you want to delete <b>${stackName}</b>?<br><span class="text-xs text-slate-500">Projects using this stack will NOT be affected, but you can't create new ones.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete',
                customClass: {
                    popup: 'rounded-xl border border-slate-200 shadow-xl',
                    title: 'text-slate-800 font-bold',
                    htmlContainer: 'text-slate-600',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-stack-' + stackId).submit();
                }
            })
        }
    </script>
@endpush
