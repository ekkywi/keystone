<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Keystone Console</title>

    @vite(["resources/css/app.css", "resources/js/app.js"])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 transition-all duration-300 border-r border-slate-800">

            {{-- LOGO --}}
            <div class="h-16 flex items-center px-6 bg-slate-950/50 border-b border-white/5 relative">
                <div class="absolute top-0 left-0 w-20 h-full bg-indigo-500/10 blur-xl"></div>

                <div class="flex items-center gap-3 z-10">
                    <div class="h-8 w-8 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/20 ring-1 ring-white/10">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-sm font-bold text-white tracking-wide leading-none">KEYSTONE</h1>
                        <p class="text-[10px] text-slate-400 font-medium tracking-wider mt-0.5">Console v1.0</p>
                    </div>
                </div>
            </div>

            {{-- NAVIGATION LINKS --}}
            <nav class="flex-1 px-3 py-6 space-y-8 overflow-y-auto no-scrollbar">

                {{-- GROUP: PLATFORM --}}
                <div>
                    <h3 class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Platform</h3>
                    <div class="space-y-1">

                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
           {{ request()->routeIs("dashboard") ? "bg-indigo-600 text-white shadow-md shadow-indigo-900/20" : "text-slate-400 hover:bg-white/5 hover:text-white" }}" href="{{ route("dashboard") }}">
                            <svg class="h-5 w-5 {{ request()->routeIs("dashboard") ? "text-indigo-200" : "text-slate-500" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Dashboard
                        </a>

                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
           {{ request()->routeIs("projects.*") ? "bg-indigo-600 text-white shadow-md shadow-indigo-900/20" : "text-slate-400 hover:bg-white/5 hover:text-white" }}" href="{{ route("projects.index") }}">
                            <svg class="h-5 w-5 {{ request()->routeIs("projects.*") ? "text-indigo-200" : "text-slate-500" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Projects
                        </a>

                    </div>
                </div>

                {{-- GROUP: INFRASTRUCTURE --}}
                <div>
                    <h3 class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Infrastructure</h3>
                    <div class="space-y-1">

                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
           {{ request()->routeIs("servers.*") ? "bg-indigo-600 text-white shadow-md shadow-indigo-900/20" : "text-slate-400 hover:bg-white/5 hover:text-white" }}" href="{{ route("servers.index") }}">
                            <svg class="h-5 w-5 {{ request()->routeIs("servers.*") ? "text-indigo-200" : "text-slate-500" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 01-2 2v4a2 2 0 012 2h14a2 2 0 012-2v-4a2 2 0 01-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Servers
                        </a>

                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
           {{ request()->routeIs("stacks.*") ? "bg-indigo-600 text-white shadow-md shadow-indigo-900/20" : "text-slate-400 hover:bg-white/5 hover:text-white" }}" href="{{ route("stacks.index") }}">
                            <svg class="h-5 w-5 {{ request()->routeIs("stacks.*") ? "text-indigo-200" : "text-slate-500" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Stacks Template
                        </a>

                    </div>
                </div>

                {{-- GROUP: SYSTEM --}}
                <div>
                    <h3 class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">System</h3>
                    <div class="space-y-1">
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                           {{ request()->routeIs("users.*") ? "bg-indigo-600 text-white shadow-md shadow-indigo-900/20" : "text-slate-400 hover:bg-white/5 hover:text-white" }}" href="{{ route("users.index") }}">
                            <svg class="h-5 w-5 {{ request()->routeIs("users.*") ? "text-indigo-200" : "text-slate-500" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Team Members
                        </a>

                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-all duration-200" href="#">
                            <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Settings
                        </a>
                    </div>
                </div>

                {{-- GROUP: SUPPORT (BARU DITAMBAHKAN) --}}
                <div>
                    <h3 class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Support</h3>
                    <div class="space-y-1">
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200
                           {{ request()->routeIs("help.*") ? "bg-indigo-600 text-white shadow-md shadow-indigo-900/20" : "text-slate-400 hover:bg-white/5 hover:text-white" }}" href="{{ route("help.index") }}">
                            <svg class="h-5 w-5 {{ request()->routeIs("help.*") ? "text-indigo-200" : "text-slate-500" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                            Help & Guides
                        </a>
                    </div>
                </div>

            </nav>

            {{-- USER PROFILE BOTTOM --}}
            <div class="p-4 border-t border-slate-800 bg-slate-950/50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="h-9 w-9 rounded-lg bg-gradient-to-tr from-slate-700 to-slate-600 ring-1 ring-white/10 flex items-center justify-center text-white font-bold text-sm">
                        {{ substr(Auth::user()->name ?? "U", 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate capitalize">{{ str_replace("_", " ", Auth::user()->role) }}</p>
                    </div>
                </div>

                <form action="{{ route("logout") }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-medium text-slate-300 bg-slate-800 hover:bg-rose-600 hover:text-white rounded-lg transition-all duration-200 group" type="submit">
                        <svg class="w-3.5 h-3.5 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
            <header class="h-16 flex items-center px-8 bg-white border-b border-slate-200 flex-shrink-0 z-10 relative">
                @hasSection("header")
                    <div class="w-full h-full">
                        @yield("header")
                    </div>
                @else
                    <div class="flex items-center justify-between w-full">
                        <h1 class="text-xl font-bold text-slate-800">
                            Overview
                        </h1>
                        <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-medium border border-emerald-200">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            System Operational
                        </div>
                    </div>
                @endif
            </header>

            <div class="flex-1 overflow-y-auto p-8 no-scrollbar">
                @yield("content")
            </div>
        </main>
    </div>

    {{-- SCRIPTS & TOAST --}}
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            customClass: {
                popup: 'rounded-xl border border-slate-200 shadow-xl',
                title: 'text-sm font-bold text-slate-800',
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
                title: 'Validation Failed',
                html: `
                    <ul style="text-align: left; margin-left: 10px; list-style: disc; font-size: 0.9em;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `
            });
        @endif
    </script>

    @stack("scripts")

</body>

</html>