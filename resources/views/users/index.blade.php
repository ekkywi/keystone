@extends("layouts.app")

@section("title", "Team Members")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">Team Members</h2>
            <div class="h-6 w-px bg-slate-200 mx-2"></div>
            <p class="text-sm text-slate-500 font-medium">Manage access & roles</p>
        </div>

        <a class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" href="{{ route("admin.users.create") }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Add Member
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-6 pb-12">

        {{-- SEARCH BAR --}}
        <div class="bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-2 transition-shadow focus-within:shadow-md focus-within:border-indigo-200">
            <div class="pl-2.5 text-slate-400 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </div>
            <input class="flex-1 border-0 focus:ring-0 text-sm text-slate-600 placeholder-slate-400 bg-transparent h-10" placeholder="Search by name or email address..." type="text">
            <div class="pr-1.5 shrink-0">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-50 text-slate-600 border border-slate-200 whitespace-nowrap">
                    <span>{{ $users->count() }}</span>
                    <span class="font-medium text-slate-400">Users</span>
                </span>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        {{-- SESUAIKAN JUMLAH TH DENGAN TD (6 KOLOM) --}}
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors group">

                            {{-- 1. Member Profile --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-indigo-200">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500 font-mono">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- 2. Department (Hanya menampilkan Dept) --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-slate-600">
                                    {{ $user->department ?? "N/A" }}
                                </span>
                            </td>

                            {{-- 3. Role --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $roleStyles = [
                                        "system_administrator" => "bg-purple-50 text-purple-700 border-purple-100",
                                        "developer" => "bg-blue-50 text-blue-700 border-blue-100",
                                        "quality_assurance" => "bg-orange-50 text-orange-700 border-orange-100",
                                        "viewer" => "bg-slate-50 text-slate-600 border-slate-200",
                                    ];
                                    $style = $roleStyles[$user->role] ?? $roleStyles["viewer"];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border {{ $style }}">
                                    {{ ucwords(str_replace("_", " ", $user->role)) }}
                                </span>
                            </td>

                            {{-- 4. Status Toggle --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center">
                                    @if (auth()->id() === $user->id)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 opacity-70 cursor-not-allowed" title="You cannot deactivate yourself">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                        </span>
                                    @else
                                        <form action="{{ route("admin.users.toggle-status", $user->id) }}" id="status-form-{{ $user->id }}" method="POST">
                                            @csrf @method("PATCH")
                                            {{-- PERBAIKAN: Gunakan $user->is_active (boolean) --}}
                                            <button class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 {{ $user->is_active ? "bg-emerald-500" : "bg-slate-200" }}" onclick="confirmStatusChange('{{ $user->id }}', '{{ $user->name }}', {{ $user->is_active ? "true" : "false" }})" type="button">
                                                <span aria-hidden="true" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $user->is_active ? "translate-x-5" : "translate-x-0" }}"></span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>

                            {{-- 5. Joined Date --}}
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 font-medium">
                                {{ $user->created_at->format("M d, Y") }}
                            </td>

                            {{-- 6. Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" href="{{ route("admin.users.edit", $user) }}" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </a>

                                    @if (auth()->id() !== $user->id)
                                        <form action="{{ route("admin.users.destroy", $user->id) }}" id="delete-form-{{ $user->id }}" method="POST">
                                            @csrf @method("DELETE")
                                            <button class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')" type="button">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push("scripts")
    {{-- Scripts tetap sama seperti kode Anda sebelumnya --}}
    <script>
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Remove Member?',
                html: `Are you sure you want to remove <b>${userName}</b>?<br><span class="text-sm text-slate-500">They will lose access to all projects immediately.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Remove',
                heightAuto: false,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            })
        }

        function confirmStatusChange(userId, userName, isActive) {
            Swal.fire({
                title: isActive ? 'Deactivate User?' : 'Activate User?',
                html: isActive ? `Revoke access for <b>${userName}</b>?` : `Grant access for <b>${userName}</b>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: isActive ? '#f59e0b' : '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: isActive ? 'Yes, Deactivate' : 'Yes, Activate',
                heightAuto: false,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('status-form-' + userId).submit();
                }
            })
        }
    </script>
@endpush
