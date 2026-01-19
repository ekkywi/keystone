@extends("layouts.app")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">
                Help Center
            </h2>
            <span class="text-slate-300 text-xl font-light">/</span>
            <p class="text-sm text-slate-500 font-medium">
                Guides & Documentation
            </p>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8 pb-12">

        {{-- SIDEBAR MENU (Sticky) --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 sticky top-6">
                <h3 class="font-bold text-slate-900 mb-4 px-2">Table of Contents</h3>
                <nav class="space-y-1">
                    <a class="block px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 hover:text-indigo-600 transition flex items-center gap-2" href="#servers">
                        <span class="bg-indigo-100 text-indigo-600 w-5 h-5 flex items-center justify-center rounded text-[10px] font-bold">1</span>
                        Server Management
                    </a>
                    <a class="block px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 hover:text-indigo-600 transition flex items-center gap-2" href="#projects">
                        <span class="bg-rose-100 text-rose-600 w-5 h-5 flex items-center justify-center rounded text-[10px] font-bold">2</span>
                        Projects & Environments
                    </a>
                    <a class="block px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 hover:text-indigo-600 transition flex items-center gap-2" href="#services">
                        <span class="bg-emerald-100 text-emerald-600 w-5 h-5 flex items-center justify-center rounded text-[10px] font-bold">3</span>
                        Deploying Services
                    </a>
                    <a class="block px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:bg-slate-50 hover:text-indigo-600 transition flex items-center gap-2" href="#monitoring">
                        <span class="bg-amber-100 text-amber-600 w-5 h-5 flex items-center justify-center rounded text-[10px] font-bold">4</span>
                        Monitoring & Logs
                    </a>
                </nav>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="lg:col-span-3 space-y-8">

            {{-- SECTION 1: SERVERS --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8 scroll-mt-24" id="servers">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900">1. Server Management</h2>
                </div>

                {{-- INFOGRAFIS 1: CONNECTION FLOW --}}
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-6 mb-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest text-center mb-4">Connection Workflow</h4>
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        {{-- Step A --}}
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-white border border-slate-200 rounded-full flex items-center justify-center shadow-sm mb-2 text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-700">1. Add Server</span>
                            <span class="text-[10px] text-slate-500">Input IP Address</span>
                        </div>

                        {{-- Arrow --}}
                        <div class="flex-1 h-px bg-slate-300 w-full md:w-auto relative">
                            <div class="absolute inset-0 flex items-center justify-center -top-2">
                                <span class="bg-slate-50 px-2 text-[10px] text-slate-400">Generate Key</span>
                            </div>
                        </div>

                        {{-- Step B --}}
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-white border border-slate-200 rounded-full flex items-center justify-center shadow-sm mb-2 text-rose-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 19.464a.5.5 0 01-.496.075l-.418-.2a.5.5 0 01-.253-.296l-.375-1.75a.5.5 0 00-.286-.34l-2.022-.8a.5.5 0 01-.288-.475V15h.5a.5.5 0 00.447-.276l.662-1.325a.5.5 0 00-.223-.67l-.556-.278A5.986 5.986 0 0115 7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-700">2. Copy SSH Key</span>
                            <span class="text-[10px] text-slate-500">Keystone Public Key</span>
                        </div>

                        {{-- Arrow --}}
                        <div class="flex-1 h-px bg-slate-300 w-full md:w-auto relative">
                            <div class="absolute inset-0 flex items-center justify-center -top-2">
                                <span class="bg-slate-50 px-2 text-[10px] text-slate-400">Paste to VPS</span>
                            </div>
                        </div>

                        {{-- Step C --}}
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-white border border-slate-200 rounded-full flex items-center justify-center shadow-sm mb-2 text-emerald-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-700">3. Connected</span>
                            <span class="text-[10px] text-slate-500">Ready to Deploy</span>
                        </div>
                    </div>
                </div>

                <div class="prose prose-slate text-sm max-w-none text-slate-600">
                    <p>Sebelum melakukan deployment, Anda harus menghubungkan VPS (Virtual Private Server) Anda ke Keystone.</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>OS: Ubuntu 20.04 LTS atau 22.04 LTS (Direkomendasikan).</li>
                        <li>Fresh Install (Belum terinstall web server lain).</li>
                        <li>Memiliki akses <strong>Root</strong> dan terinstall <strong>Docker</strong>.</li>
                    </ul>
                </div>
            </div>

            {{-- SECTION 2: PROJECTS --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8 scroll-mt-24" id="projects">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900">2. Projects & Environments</h2>
                </div>

                {{-- INFOGRAFIS 2: ENVIRONMENTS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="border border-emerald-200 bg-emerald-50/50 rounded-xl p-4 flex items-start gap-4 hover:shadow-md transition">
                        <div class="bg-white p-2 rounded-lg shadow-sm text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-emerald-900 text-sm">Production</h4>
                            <p class="text-xs text-emerald-700 mt-1 leading-relaxed">
                                Lingkungan utama untuk user. Gunakan server performa tinggi.
                            </p>
                        </div>
                    </div>
                    <div class="border border-amber-200 bg-amber-50/50 rounded-xl p-4 flex items-start gap-4 hover:shadow-md transition">
                        <div class="bg-white p-2 rounded-lg shadow-sm text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-amber-900 text-sm">Staging / Test</h4>
                            <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                Tempat uji coba fitur baru. Bisa menggunakan server kecil (VPS murah).
                            </p>
                        </div>
                    </div>
                </div>

                <div class="prose prose-slate text-sm max-w-none text-slate-600">
                    <p>Project mengelompokkan layanan aplikasi Anda. Pastikan Anda memilih Environment yang tepat saat membuat project baru.</p>
                </div>
            </div>

            {{-- SECTION 3: SERVICES --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8 scroll-mt-24" id="services">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900">3. Deploying Services</h2>
                </div>

                {{-- INFOGRAFIS 3: DEPLOYMENT PIPELINE --}}
                <div class="relative mb-8 mt-2">
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -translate-y-1/2 rounded-full z-0"></div>
                    <div class="grid grid-cols-4 gap-2 relative z-10">
                        {{-- Step 1 --}}
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold border-4 border-white shadow-sm">1</div>
                            <span class="text-[10px] font-bold text-slate-800 mt-2 uppercase tracking-wide">Select Stack</span>
                        </div>
                        {{-- Step 2 --}}
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold border-4 border-white shadow-sm">2</div>
                            <span class="text-[10px] font-bold text-slate-800 mt-2 uppercase tracking-wide">Config Port</span>
                        </div>
                        {{-- Step 3 --}}
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold border-4 border-white shadow-sm ring-2 ring-indigo-100">3</div>
                            <span class="text-[10px] font-bold text-indigo-700 mt-2 uppercase tracking-wide">Deploy</span>
                        </div>
                        {{-- Step 4 --}}
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold border-4 border-white shadow-sm">4</div>
                            <span class="text-[10px] font-bold text-emerald-700 mt-2 uppercase tracking-wide">Live</span>
                        </div>
                    </div>
                </div>

                <div class="prose prose-slate text-sm max-w-none text-slate-600">
                    <p>Service adalah unit aplikasi yang berjalan di Docker (Nginx, MySQL, Redis, dll).</p>
                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mt-4 rounded-r-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            <div>
                                <p class="text-amber-800 font-bold text-xs">PENTING: Redeploy</p>
                                <p class="text-amber-700 text-xs mt-1">
                                    Jika Anda mengubah Environment Variables (ENV) setelah service berjalan, tekan tombol <strong>Redeploy</strong> agar perubahan diterapkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 4: MONITORING --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8 scroll-mt-24" id="monitoring">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900">4. Monitoring & Logs</h2>
                </div>

                {{-- INFOGRAFIS 4: FEATURES --}}
                <div class="flex flex-col sm:flex-row gap-4 mb-6">
                    <div class="flex-1 bg-slate-900 rounded-xl p-4 text-white relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-3 opacity-10">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h4 class="font-mono text-sm font-bold text-emerald-400 mb-1">Live Logs</h4>
                        <p class="text-xs text-slate-400 mb-3">Streaming real-time dari container.</p>
                        <div class="bg-black/50 rounded p-2 font-mono text-[10px] text-slate-300 border border-white/10">
                            > npm start<br>
                            > Server running on :80<br>
                            <span class="animate-pulse">_</span>
                        </div>
                    </div>

                    <div class="flex-1 bg-white border border-slate-200 rounded-xl p-4 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-3 opacity-5 text-rose-600">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm mb-1">Health Check</h4>
                        <p class="text-xs text-slate-500 mb-3">Sync status manual dengan server.</p>
                        <div class="flex items-center gap-2">
                            <span class="bg-slate-100 p-1 rounded-full"><svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg></span>
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-100">RUNNING</span>
                        </div>
                    </div>
                </div>

                <div class="prose prose-slate text-sm max-w-none text-slate-600">
                    <p>Keystone menyediakan fitur monitoring agar Anda tidak buta terhadap kondisi server.</p>
                </div>
            </div>

        </div>
    </div>
@endsection
