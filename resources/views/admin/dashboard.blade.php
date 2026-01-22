@extends("layouts.app")

@section("title", "Command Center")

{{-- HEADER SECTION (Konsisten dengan Page Lain) --}}
@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">Command Center</h2>
            <div class="h-6 w-px bg-slate-200 mx-2"></div>
            <p class="text-sm text-slate-500 font-medium">Infrastructure Overview & Approvals</p>
        </div>

        {{-- Right Side: Status Live System --}}
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold border border-indigo-100 flex items-center gap-2 shadow-sm">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                Live System
            </span>
        </div>
    </div>
@endsection

@section("content")
    <div class="min-h-screen font-sans">

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 pt-2">
            {{-- Card Total --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Total Requests</div>
                <div class="text-3xl font-bold text-slate-900">{{ $stats["total"] }}</div>
            </div>
            {{-- Card Pending (Highlighted) --}}
            <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-6 rounded-2xl shadow-lg shadow-orange-200 text-white relative overflow-hidden group">
                <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                </div>
                <div class="text-[10px] font-bold text-orange-100 uppercase tracking-wider mb-2">Pending Review</div>
                <div class="text-3xl font-bold text-white">{{ $stats["pending"] }}</div>
            </div>
            {{-- Card Approved --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-2">Access Granted</div>
                <div class="text-3xl font-bold text-emerald-600">{{ $stats["approved"] }}</div>
            </div>
            {{-- Card Rejected --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="text-[10px] font-bold text-rose-600 uppercase tracking-wider mb-2">Rejected</div>
                <div class="text-3xl font-bold text-rose-600">{{ $stats["rejected"] }}</div>
            </div>
        </div>

        {{-- TABLE SECTION --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-10">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Incoming Requests</h3>
                <div class="flex gap-2">
                    {{-- Search Placeholder --}}
                    <div class="relative">
                        <input class="pl-9 pr-4 py-2 text-xs border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 w-64 transition-all" placeholder="Search by Ticket ID or Name..." type="text">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 text-[11px] uppercase font-bold tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Ticket ID</th>
                            <th class="px-6 py-4">Identity</th>
                            <th class="px-6 py-4">Request Type</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Controls</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($requests as $req)
                            <tr class="group hover:bg-slate-50/80 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="font-mono text-xs font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded inline-block border border-slate-200">
                                        {{ $req->ticket_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold ring-2 ring-white">
                                            {{ substr($req->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800">{{ $req->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $req->department }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-600 font-medium">{{ $req->type_label }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs">
                                    {{ $req->created_at->format("d M Y") }}
                                    <span class="text-slate-300 mx-1">|</span>
                                    {{ $req->created_at->format("H:i") }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $req->status_badge }}">
                                        @if($req->status == 'pending')
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                        @endif
                                        {{ $req->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-100">
                                        {{-- PDF Button --}}
                                        <a href="{{ asset("storage/" . $req->pdf_path) }}" target="_blank" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors group/pdf relative" title="View PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        </a>

                                        {{-- MANAGE BUTTON (Active if Pending) --}}
                                        @if($req->status == 'pending')
                                            <button onclick="openProcessModal('{{ $req->id }}', '{{ $req->name }}', '{{ $req->ticket_number }}', '{{ $req->request_type }}')"
                                                class="px-3 py-1.5 bg-slate-900 hover:bg-indigo-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-md shadow-sm transition-all active:scale-95 flex items-center gap-1">
                                                <span>Process</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            </button>
                                        @else
                                            <span class="px-2 py-1 text-[10px] font-bold text-slate-300 bg-slate-50 rounded border border-slate-100 uppercase tracking-wider cursor-not-allowed">
                                                Locked
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-12 text-center" colspan="6">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <div class="bg-slate-50 p-4 rounded-full mb-3">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                        </div>
                                        <span class="text-sm font-medium">No requests found in the system.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($requests->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL PROCESS REQUEST (Hidden by Default)  --}}
    {{-- ========================================== --}}
    <div id="processModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeProcessModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200">
                    
                    {{-- Modal Header --}}
                    <div class="bg-white px-4 py-4 sm:px-6 border-b border-slate-100 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="bg-indigo-50 p-2 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <h3 class="text-base font-bold leading-6 text-slate-900">Process Request</h3>
                        </div>
                        <button onclick="closeProcessModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-md hover:bg-slate-100">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="px-6 py-6">
                        {{-- Info Card --}}
                        <div class="mb-6 bg-slate-50 p-4 rounded-xl border border-slate-200 flex items-start gap-4">
                            <div class="h-10 w-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-indigo-600 font-bold shadow-sm shrink-0">
                                <span id="modalUserInitials">U</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-900 truncate" id="modalUserName">User Name</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs font-mono bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded" id="modalTicket">REQ/...</span>
                                    <span class="text-xs text-slate-500 font-medium px-2 py-0.5 bg-slate-200 rounded-full" id="modalType">Type</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-sm text-slate-600 space-y-3">
                            <p>Please review the request details carefully before proceeding.</p>
                            
                            <div class="bg-amber-50 text-amber-800 p-3 rounded-lg text-xs border border-amber-100 flex gap-2">
                                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <div>
                                    <strong>Automated Action:</strong><br>
                                    Approving a "New Account" request will automatically create a user in the system with the default password.
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-8 grid grid-cols-2 gap-3">
                            {{-- REJECT FORM --}}
                            <form id="formReject" action="" method="POST">
                                @csrf
                                <button type="submit" class="w-full justify-center rounded-xl bg-white px-3 py-3 text-sm font-bold text-rose-600 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-rose-50 hover:ring-rose-200 transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Reject
                                </button>
                            </form>

                            {{-- APPROVE FORM --}}
                            <form id="formApprove" action="" method="POST">
                                @csrf
                                <button type="submit" class="w-full justify-center rounded-xl bg-slate-900 px-3 py-3 text-sm font-bold text-white shadow-lg hover:bg-indigo-600 hover:shadow-indigo-500/30 transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Approve & Execute
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT PENGENDALI MODAL --}}
    <script>
        function openProcessModal(id, name, ticket, type) {
            // 1. Isi Data ke Modal
            document.getElementById('modalUserName').innerText = name;
            document.getElementById('modalTicket').innerText = ticket;
            document.getElementById('modalType').innerText = type.replace('_', ' ').toUpperCase(); 
            document.getElementById('modalUserInitials').innerText = name.charAt(0);

            // 2. Set URL Action Form
            let baseApprove = "{{ route('admin.requests.approve', '999') }}";
            let baseReject = "{{ route('admin.requests.reject', '999') }}";

            document.getElementById('formApprove').action = baseApprove.replace('999', id);
            document.getElementById('formReject').action = baseReject.replace('999', id);

            // 3. Munculkan Modal
            let modal = document.getElementById('processModal');
            modal.classList.remove('hidden');
            
            setTimeout(() => {
                modal.querySelector('div[class*="transform"]').classList.remove('scale-95', 'opacity-0');
                modal.querySelector('div[class*="transform"]').classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeProcessModal() {
            let modal = document.getElementById('processModal');
            
            modal.querySelector('div[class*="transform"]').classList.remove('scale-100', 'opacity-100');
            modal.querySelector('div[class*="transform"]').classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    </script>
@endsection