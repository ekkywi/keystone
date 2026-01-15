@extends("layouts.app")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">
                Users
            </h2>
            <span class="text-slate-300 text-xl font-light">/</span>
            <p class="text-sm text-slate-500 font-medium">
                Team Management
            </p>
        </div>

        <a class="bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-slate-800 transition shadow-lg shadow-slate-900/20 flex items-center gap-2" href="{{ route("users.create") }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Add Member
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-6">

        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </div>
                <input class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Search by name or email..." type="text">
            </div>

            <div class="flex items-center gap-2 text-sm text-slate-500">
                <span>Showing <strong>{{ $users->count() }}</strong> members</span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">User Profile</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Role Access</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Joined Date</th>
                            <th class="relative px-6 py-4" scope="col"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @foreach ($users as $user)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-9 w-9 flex-shrink-0">
                                            <div class="h-9 w-9 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500 font-mono">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $badges = [
                                            "system_administrator" => "bg-purple-50 text-purple-700 border-purple-100 ring-purple-500/10",
                                            "quality_assurance" => "bg-orange-50 text-orange-700 border-orange-100 ring-orange-500/10",
                                            "developer" => "bg-blue-50 text-blue-700 border-blue-100 ring-blue-500/10",
                                        ];
                                        $labels = [
                                            "system_administrator" => "System Admin",
                                            "quality_assurance" => "QA Engineer",
                                            "developer" => "Developer",
                                        ];
                                        $roleClass = $badges[$user->role] ?? "bg-slate-50 text-slate-600 border-slate-100";
                                        $roleLabel = $labels[$user->role] ?? ucfirst($user->role);
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border ring-1 ring-inset {{ $roleClass }}">
                                        {{ $roleLabel }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (auth()->id() === $user->id)
                                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full w-fit bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-medium cursor-not-allowed opacity-75">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </div>
                                    @else
                                        <form action="{{ route("users.toggle-status", $user->id) }}" id="status-form-{{ $user->id }}" method="POST">
                                            @csrf
                                            @method("PATCH")
                                            <button class="group flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border transition-all focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-slate-400
                                                {{ $user->is_active ? "bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100" : "bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200" }}" onclick="confirmStatusChange('{{ $user->id }}', '{{ $user->name }}', {{ $user->is_active ? "true" : "false" }})" type="button">

                                                <span class="h-1.5 w-1.5 rounded-full transition-colors {{ $user->is_active ? "bg-emerald-500 animate-pulse" : "bg-slate-400" }}"></span>
                                                {{ $user->is_active ? "Active" : "Inactive" }}
                                            </button>
                                        </form>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 font-mono">
                                    {{ $user->created_at->format("M d, Y") }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a class="p-1 text-slate-400 hover:text-indigo-600 transition-colors" href="{{ route("users.edit", $user) }}" title="Edit User">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                        </a>

                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route("users.destroy", $user->id) }}" id="delete-form-{{ $user->id }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button class="p-1 text-slate-400 hover:text-rose-600 transition-colors" onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')" title="Delete User" type="button">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            </div>

            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Delete User?',
                html: `Are you sure you want to delete <b>${userName}</b>?<br><span class="text-sm text-slate-500">This action cannot be undone.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e', // Rose-500
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it',
                customClass: {
                    popup: 'rounded-xl border border-slate-200',
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
                text: isActive ? `Revoke access for ${userName}?` : `Grant access for ${userName}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: isActive ? '#f43f5e' : '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: isActive ? 'Yes, Deactivate' : 'Yes, Activate'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('status-form-' + userId).submit();
                }
            })
        }
    </script>
@endpush
