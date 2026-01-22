<!DOCTYPE html>

@php
    // Hitung request milik user sendiri (untuk menu Support)
    $myPendingCount = \App\Models\AccessRequest::where("email", Auth::user()->email)
        ->where("status", "pending")
        ->count();

    // Hitung SEMUA request pending (untuk Admin)
    $totalSystemPending = \App\Models\AccessRequest::where("status", "pending")->count();
@endphp

<html class="h-full bg-slate-50" lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield("title", "Console") - {{ config("app.name", "Keystone") }}</title>

    @vite(["resources/css/app.css", "resources/js/app.js"])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .bg-grid-pattern {
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
    @stack("styles")
</head>

<body class="h-full text-slate-600 antialiased selection:bg-indigo-500 selection:text-white relative overflow-hidden">

    <div class="fixed inset-0 z-[-1] bg-grid-pattern opacity-40 pointer-events-none"></div>
    <div class="fixed top-[-10%] left-[-10%] w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="flex h-full">

        {{-- SIDEBAR --}}
        <aside class="w-72 bg-[#0B1120] text-slate-400 flex flex-col border-r border-white/5 shadow-2xl z-50 transition-all duration-300">

            {{-- LOGO --}}
            <div class="h-16 flex items-center px-6 border-b border-white/5 bg-[#0B1120]/50 backdrop-blur-sm">
                <a class="flex items-center gap-3 group" href="{{ route("dashboard") }}">
                    <div class="relative flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-600 to-violet-600 shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" />
                        </svg>
                        <div class="absolute inset-0 rounded-lg ring-1 ring-white/20"></div>
                    </div>
                    <div>
                        <h1 class="text-sm font-bold text-white tracking-wide">KEYSTONE</h1>
                        <div class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[10px] font-medium text-slate-500">Infrastructure Core</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- NAV LINKS --}}
            <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto no-scrollbar">

                {{-- GROUP 1: PLATFORM (User Biasa) --}}
                <div>
                    <h3 class="px-2 text-[10px] font-bold text-slate-600 uppercase tracking-widest mb-3">Platform</h3>
                    <div class="space-y-1">
                        {{-- Dashboard User --}}
                        <a class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs("dashboard") ? "bg-indigo-500/10 text-white shadow-[0_0_20px_rgba(99,102,241,0.1)] ring-1 ring-indigo-500/20" : "text-slate-400 hover:text-white hover:bg-white/5" }}" href="{{ route("dashboard") }}">
                            <svg class="w-5 h-5 transition-colors {{ request()->routeIs("dashboard") ? "text-indigo-400" : "text-slate-500 group-hover:text-slate-300" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Dashboard
                        </a>
                        {{-- Projects --}}
                        <a class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs("projects.*") ? "bg-indigo-500/10 text-white shadow-[0_0_20px_rgba(99,102,241,0.1)] ring-1 ring-indigo-500/20" : "text-slate-400 hover:text-white hover:bg-white/5" }}" href="{{ route("projects.index") }}">
                            <svg class="w-5 h-5 transition-colors {{ request()->routeIs("projects.*") ? "text-indigo-400" : "text-slate-500 group-hover:text-slate-300" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Projects
                        </a>
                    </div>
                </div>

                {{-- GROUP 2: INFRASTRUCTURE (User Biasa) --}}
                <div>
                    <h3 class="px-2 text-[10px] font-bold text-slate-600 uppercase tracking-widest mb-3">Infrastructure</h3>
                    <div class="space-y-1">
                        <a class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs("servers.*") ? "bg-indigo-500/10 text-white shadow-[0_0_20px_rgba(99,102,241,0.1)] ring-1 ring-indigo-500/20" : "text-slate-400 hover:text-white hover:bg-white/5" }}" href="{{ route("servers.index") }}">
                            <svg class="w-5 h-5 transition-colors {{ request()->routeIs("servers.*") ? "text-indigo-400" : "text-slate-500 group-hover:text-slate-300" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 01-2 2v4a2 2 0 012 2h14a2 2 0 012-2v-4a2 2 0 01-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Servers
                        </a>
                        <a class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs("stacks.*") ? "bg-indigo-500/10 text-white shadow-[0_0_20px_rgba(99,102,241,0.1)] ring-1 ring-indigo-500/20" : "text-slate-400 hover:text-white hover:bg-white/5" }}" href="{{ route("stacks.index") }}">
                            <svg class="w-5 h-5 transition-colors {{ request()->routeIs("stacks.*") ? "text-indigo-400" : "text-slate-500 group-hover:text-slate-300" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Stacks Template
                        </a>
                    </div>
                </div>

                {{-- GROUP 3: SUPPORT (Tersedia untuk Semua User) --}}
                <div>
                    <h3 class="px-2 text-[10px] font-bold text-slate-600 uppercase tracking-widest mb-3">Support</h3>
                    <div class="space-y-1">

                        {{-- REQUEST CENTER DENGAN BADGE --}}
                        <a class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs("internal.requests.*") ? "bg-indigo-500/10 text-white shadow-[0_0_20px_rgba(99,102,241,0.1)] ring-1 ring-indigo-500/20" : "text-slate-400 hover:text-white hover:bg-white/5" }}" href="{{ route("internal.requests.index") }}">

                            <svg class="w-5 h-5 transition-colors {{ request()->routeIs("internal.requests.*") ? "text-indigo-400" : "text-slate-500 group-hover:text-slate-300" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0112.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>

                            <span class="flex-1">Request Center</span>

                            {{-- BADGE NOTIFIKASI --}}
                            @if ($myPendingCount > 0)
                                <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold leading-none text-amber-500 bg-amber-500/10 border border-amber-500/20 rounded-full animate-pulse">
                                    {{ $myPendingCount }}
                                </span>
                            @endif
                        </a>

                    </div>
                </div>

                {{-- GROUP 4: ADMINISTRATION (Hanya Muncul untuk SYSTEM ADMINISTRATOR) --}}
                @if (Auth::user()->role === "system_administrator")
                    <div>
                        <h3 class="px-2 text-[10px] font-bold text-amber-500/80 uppercase tracking-widest mb-3 flex items-center gap-2">
                            <span>Administration</span>

                            {{-- LINGKARAN HANYA MUNCUL JIKA ADA REQUEST YANG BELUM DIPROSES --}}
                            @if ($totalSystemPending > 0)
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            @endif
                        </h3>
                        <div class="space-y-1">

                            {{-- 1. COMMAND CENTER (Admin Dashboard) --}}
                            <a class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs("admin.dashboard") ? "bg-amber-500/10 text-white shadow-[0_0_20px_rgba(245,158,11,0.1)] ring-1 ring-amber-500/20" : "text-slate-400 hover:text-white hover:bg-white/5" }}" href="{{ route("admin.dashboard") }}">

                                <svg class="w-5 h-5 transition-colors {{ request()->routeIs("admin.dashboard") ? "text-amber-500" : "text-slate-500 group-hover:text-slate-300" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>

                                <span class="flex-1">Command Center</span>

                                {{-- BADGE ANGKA UNTUK ADMIN --}}
                                @if ($totalSystemPending > 0)
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold leading-none text-white bg-amber-500 rounded-full shadow-lg shadow-amber-500/20">
                                        {{ $totalSystemPending }}
                                    </span>
                                @endif
                            </a>

                            {{-- 2. TEAM MEMBERS (Users) --}}
                            <a class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs("admin.users.*") ? "bg-amber-500/10 text-white shadow-[0_0_20px_rgba(245,158,11,0.1)] ring-1 ring-amber-500/20" : "text-slate-400 hover:text-white hover:bg-white/5" }}" href="{{ route("admin.users.index") }}">
                                <svg class="w-5 h-5 transition-colors {{ request()->routeIs("admin.users.*") ? "text-amber-500" : "text-slate-500 group-hover:text-slate-300" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                                Team Members
                            </a>

                        </div>
                    </div>
                @endif

            </nav>

            {{-- USER PROFILE --}}
            <div class="p-4 border-t border-white/5 bg-[#080d19]">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-9 w-9 rounded-lg bg-gradient-to-tr from-slate-700 to-slate-600 ring-1 ring-white/10 flex items-center justify-center text-white font-bold text-sm shadow-inner">
                        {{ substr(Auth::user()->name ?? "U", 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-slate-500 truncate uppercase tracking-wider font-bold">
                            {{-- Format Role Name (replace underscore) --}}
                            {{ ucwords(str_replace("_", " ", Auth::user()->role)) }}
                        </p>
                    </div>
                </div>

                <form action="{{ route("logout") }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-bold text-slate-400 bg-white/5 hover:bg-rose-500/10 hover:text-rose-400 hover:border-rose-500/20 border border-white/5 rounded-lg transition-all duration-200 group" type="submit">
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 flex flex-col h-full overflow-hidden relative z-10">
            <header class="h-16 flex items-center justify-between px-8 bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-20">
                <div class="flex-1">
                    @hasSection("header")
                        @yield("header")
                    @else
                        <h1 class="text-xl font-bold text-slate-800">Dashboard</h1>
                    @endif
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 no-scrollbar scroll-smooth">
                @yield("content")
            </div>
        </main>
    </div>

    {{-- SCRIPTS (SweetAlert Toast) --}}
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#1e293b',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            customClass: {
                popup: 'rounded-xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]',
                title: 'text-sm font-bold',
                timerProgressBar: 'bg-indigo-500'
            }
        });

        @if (session("success"))
            Toast.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session("success") }}"
            });
        @endif

        @if (session("error"))
            Toast.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session("error") }}"
            });
        @endif

        @if ($errors->any())
            Toast.fire({
                icon: 'error',
                title: 'Validation Issue',
                html: `<ul class="text-left text-xs list-disc pl-4 mt-1 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`
            });
        @endif
    </script>
    @stack("scripts")
</body>

</html>
