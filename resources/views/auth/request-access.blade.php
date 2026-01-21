@extends("layouts.guest")

@push("styles")
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-mono { font-family: 'Space Mono', monospace; }

        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer { to { background-position: 200% center; } }
    </style>
@endpush

@section("content")
    <div class="h-screen w-full flex bg-white overflow-hidden">

        {{-- LEFT SIDE: STANDARD INFO --}}
        <div class="hidden lg:flex w-1/2 bg-slate-900 relative flex-col justify-between p-12 lg:p-16 h-full z-10">

            {{-- Background Effects --}}
            <div class="absolute inset-0 pointer-events-none z-0">
                <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px); background-size: 32px 32px;"></div>
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px] mix-blend-screen"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-cyan-500/5 rounded-full blur-[100px] mix-blend-screen"></div>
            </div>

            {{-- 1. HEADER --}}
            <div class="relative z-10 flex items-center gap-4">
                <div class="h-11 w-11 bg-white/5 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/10 shadow-sm shrink-0">
                    <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-white tracking-tight leading-none">KEYSTONE</span>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="h-px w-3 bg-indigo-500"></div>
                        <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-indigo-200">
                            ACCESS CONTROL
                        </span>
                    </div>
                </div>
            </div>

            {{-- 2. CENTER: WORKFLOW --}}
            <div class="relative z-10 flex flex-col justify-center h-full">
                
                <div class="mb-10">
                    <h2 class="text-3xl font-bold text-white leading-tight">
                        Provisioning <br>
                        <span class="text-slate-400">Workflow.</span>
                    </h2>
                    <p class="text-slate-500 text-sm mt-2 max-w-sm">
                        Standard operating procedure for identity verification and access granting.
                    </p>
                </div>

                {{-- INFOGRAFIS ALUR --}}
                <div class="grid grid-cols-1 gap-6 relative">
                    <div class="absolute left-6 top-8 bottom-8 w-px border-l-2 border-dashed border-slate-700/50 z-0"></div>

                    {{-- Step 1 --}}
                    <div class="relative z-10 flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l4 4a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div class="pt-1">
                            <h4 class="text-sm font-bold text-white">1. Request Submission</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed max-w-xs">
                                Form data is validated and a unique <span class="font-mono text-slate-400">Ticket ID</span> is generated instantly.
                            </p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="relative z-10 flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <div class="pt-1">
                            <h4 class="text-sm font-bold text-white">2. Security Review</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed max-w-xs">
                                Admin reviews the request against departmental security policies.
                            </p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="relative z-10 flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 19.464a.5.5 0 01-.496.075l-.418-.2a.5.5 0 01-.253-.296l-.375-1.75a.5.5 0 00-.286-.34l-2.022-.8a.5.5 0 01-.288-.475V15h.5a.5.5 0 00.447-.276l.662-1.325a.5.5 0 00-.223-.67l-.556-.278A5.986 5.986 0 0115 7z" /></svg>
                        </div>
                        <div class="pt-1">
                            <h4 class="text-sm font-bold text-white">3. Access Grant</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed max-w-xs">
                                Credentials created & sent securely to your registered email.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- INFO STANDARD (REPLACED ENCRYPTION GIMMICK) --}}
                <div class="mt-10 p-4 rounded-xl bg-gradient-to-r from-indigo-500/10 to-transparent border border-indigo-500/20 flex items-center gap-4">
                    <div class="p-2 bg-indigo-500/20 rounded-lg">
                        {{-- Icon Shield Check --}}
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-white">Audit & Compliance</h5>
                        <p class="text-[10px] text-indigo-300/80">All requests are logged for security auditing purposes.</p>
                    </div>
                </div>

            </div>

            {{-- 3. FOOTER --}}
            <div class="relative z-10 border-t border-white/5 pt-4 flex justify-between items-center text-xs font-mono text-slate-500">
                <span>IT Security Division</span>
                <span>v1.0.0</span>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM INPUT --}}
        <div class="w-full lg:w-1/2 h-full flex items-center justify-center bg-white relative">
            
            <div class="w-full h-full overflow-y-auto px-6 py-8 flex items-center justify-center">

                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 to-cyan-500 lg:hidden"></div>

                <div class="w-full max-w-[420px]">

                    <div class="lg:hidden mb-6 flex items-center gap-2">
                        <div class="h-8 w-8 bg-slate-900 rounded-lg flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" /></svg>
                        </div>
                        <span class="font-bold text-slate-900 tracking-wide">KEYSTONE</span>
                    </div>

                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Submit Access Request</h1>
                        <p class="text-slate-500 text-sm mt-1">Fill out the details below to request privileges.</p>
                    </div>

                    <form action="{{ route("request.store") }}" class="space-y-4" id="requestForm" method="POST">
                        @csrf

                        <div class="space-y-3">
                            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-1">1. Identity</h3>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Full Name</label>
                                    <input class="block w-full px-3 py-2.5 rounded-lg border border-slate-200 text-slate-900 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all shadow-sm" name="name" placeholder="e.g. Jane Doe" required type="text">
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Email</label>
                                        <input class="block w-full px-3 py-2.5 rounded-lg border border-slate-200 text-slate-900 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all shadow-sm" name="email" placeholder="name@work.com" required type="email">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Unit / Dept</label>
                                        <input class="block w-full px-3 py-2.5 rounded-lg border border-slate-200 text-slate-900 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all shadow-sm" name="department" placeholder="e.g. IT Dev" required type="text">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-1 pt-1">2. Request Details</h3>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Request Type</label>
                                <div class="relative">
                                    <select class="block w-full px-3 py-2.5 rounded-lg border border-slate-200 text-slate-900 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all shadow-sm appearance-none bg-white cursor-pointer" name="request_type" required>
                                        <option disabled selected value="">-- Select Requirement --</option>
                                        <option value="new_account">New Account Creation</option>
                                        <option value="access_grant">Additional Access Rights</option>
                                        <option value="reset_password">Password Reset</option>
                                        <option value="other">Other Inquiry</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" /></svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Reason / Description</label>
                                <textarea class="block w-full px-3 py-2.5 rounded-lg border border-slate-200 text-slate-900 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all shadow-sm resize-none" name="reason" placeholder="Why do you need this access?" required rows="2"></textarea>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col gap-2">
                            <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-slate-900 hover:bg-gradient-to-r hover:from-slate-900 hover:to-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-900 transition-all duration-300 shadow-lg shadow-slate-900/20 active:scale-[0.98]" id="submitBtn" type="submit">
                                <span id="btnText">Submit Request</span>
                                <span class="hidden items-center gap-2" id="btnLoading">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4" stroke="currentColor"></circle><path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" fill="currentColor"></path></svg>
                                    Processing...
                                </span>
                            </button>

                            <a class="w-full flex justify-center py-2.5 px-4 rounded-xl text-xs font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-50 transition-colors" href="{{ route("login") }}">
                                Cancel & Return to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('requestForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');

            btn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            btnLoading.classList.add('flex');
        });
    </script>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `<ul class="text-left text-sm list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`,
                confirmButtonColor: '#0f172a'
            });
        </script>
    @endif
@endpush