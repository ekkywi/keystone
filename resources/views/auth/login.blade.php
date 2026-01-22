@extends("layouts.guest")

@section("title", "Login")

@push("styles")
    {{-- Import Font Poppins --}}
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .terminal-cursor {
            animation: blink 1s step-end infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            to {
                background-position: 200% center;
            }
        }
    </style>
@endpush

@section("content")
    <div class="min-h-screen flex bg-white">

        {{-- LEFT SIDE: BRANDING & VISUAL (Desktop Only) --}}
        <div class="hidden lg:flex w-1/2 bg-[#0B1120] relative overflow-hidden flex-col justify-between p-12 lg:p-16">

            {{-- Background Effects --}}
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute inset-0" style="background-image: radial-gradient(rgba(99, 102, 241, 0.15) 1px, transparent 1px); background-size: 32px 32px;"></div>
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-indigo-600/20 rounded-full blur-[128px] mix-blend-screen"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-emerald-600/10 rounded-full blur-[128px] mix-blend-screen"></div>
            </div>

            {{-- Logo --}}
            <div class="relative z-10 flex items-center gap-4">
                <div class="h-11 w-11 bg-white/5 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/10 shadow-2xl shadow-indigo-500/20 group cursor-pointer overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    <svg class="h-6 w-6 text-indigo-400 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-white tracking-tight leading-none">KEYSTONE</span>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="h-px w-3 bg-indigo-500"></div>
                        <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-white to-indigo-300 shimmer-text">
                            INFRASTRUCTURE CORE
                        </span>
                    </div>
                </div>
            </div>

            {{-- Hero Content --}}
            <div class="relative z-10">
                <h2 class="text-3xl font-bold text-white leading-tight mb-6">
                    Deploy faster, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-400 via-slate-200 to-slate-400">break things less.</span>
                </h2>

                <div class="relative bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-2xl max-w-md overflow-hidden ring-1 ring-indigo-500/20 shadow-2xl">
                    <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                    {{-- Fake Terminal --}}
                    <div class="flex items-center gap-2 mb-4 opacity-50">
                        <div class="w-2.5 h-2.5 rounded-full bg-rose-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                    </div>
                    <p class="font-mono text-sm text-slate-300 leading-relaxed">
                        <span class="text-emerald-400">$</span> <span class="text-cyan-300">keystone</span> init infrastructure<br>
                        <span class="text-slate-500">[info] Loading modules...</span><br>
                        <span class="text-emerald-400">✓</span> Multi-server orchestration ready.<br>
                        <span class="text-emerald-400">✓</span> Security policies enforced.<br>
                        <span class="text-indigo-400">$</span> Awaiting commands<span class="terminal-cursor text-indigo-400">_</span>
                    </p>
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="relative z-10 flex items-center gap-2 text-xs font-mono text-slate-500">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                System Operational / v1.0.0
            </div>
        </div>

        {{-- RIGHT SIDE: LOGIN FORM --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white relative">

            {{-- Mobile Top Bar Gradient --}}
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-500 lg:hidden"></div>

            <div class="w-full max-w-[400px]">

                {{-- Mobile Logo --}}
                <div class="lg:hidden mb-8 flex items-center gap-2">
                    <div class="h-8 w-8 bg-slate-900 rounded-lg flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <span class="font-bold text-slate-900 tracking-wide text-lg">KEYSTONE</span>
                </div>

                {{-- Heading --}}
                <div class="mb-10">
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Welcome back</h1>
                    <p class="text-slate-500 text-sm mt-2">Sign in to access your infrastructure console.</p>
                </div>

                <form action="{{ route("login.process") }}" class="space-y-5" id="loginForm" method="POST">
                    @csrf

                    {{-- Email Input --}}
                    <div class="space-y-1.5 relative">
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1" for="email">Work Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                            <input autofocus class="block w-full pl-11 pr-4 py-3 rounded-xl border-slate-200 text-slate-900 text-sm placeholder:text-slate-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm" id="email" name="email" placeholder="engineer@company.com" required type="email" value="{{ old("email") }}">
                        </div>
                    </div>

                    {{-- Password Input --}}
                    <div class="space-y-1.5 relative">
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-bold uppercase text-slate-500" for="password">Password</label>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>

                            <input class="block w-full pl-11 pr-12 py-3 rounded-xl border-slate-200 text-slate-900 text-sm placeholder:text-slate-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm" id="password" name="password" placeholder="••••••••" required type="password">

                            <button class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none" onclick="togglePassword()" type="button">
                                <svg class="h-5 w-5" fill="none" id="eyeIcon" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                                <svg class="h-5 w-5 hidden" fill="none" id="eyeOffIcon" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center gap-2 cursor-pointer group select-none">
                            <div class="relative">
                                <input class="peer sr-only" name="remember" type="checkbox">
                                <div class="w-4 h-4 border border-slate-300 rounded bg-white peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all"></div>
                                <svg class="w-3 h-3 text-white absolute top-0.5 left-0.5 opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">Remember me</span>
                        </label>
                        <a class="text-xs font-bold text-indigo-600 hover:text-indigo-800 hover:underline transition-colors" href="{{ route("request.create") }}">Forgot password?</a>
                    </div>

                    {{-- Submit Button --}}
                    <button class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all duration-300 shadow-lg shadow-slate-900/20 hover:shadow-xl hover:shadow-indigo-900/10 active:scale-[0.98] relative overflow-hidden disabled:opacity-70 disabled:cursor-not-allowed" id="submitBtn" type="submit">
                        <span class="absolute inset-0 bg-white/10 opacity-0 hover:opacity-100 transition-opacity"></span>

                        <span class="relative" id="btnText">Sign In to Console</span>

                        <span class="hidden relative items-center gap-2" id="btnLoading">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4" stroke="currentColor"></circle>
                                <path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" fill="currentColor"></path>
                            </svg>
                            Authenticating...
                        </span>
                    </button>
                </form>

                <div class="mt-10 pt-6 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-400">
                        Don't have an account?
                        <a class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors ml-1" href="{{ route("request.create") }}">
                            Request Access
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
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
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-xl border border-rose-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]',
                    title: 'text-sm font-bold text-rose-700',
                    htmlContainer: 'text-xs text-rose-500'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: 'Authentication Failed',
                html: `<ul class="list-disc pl-4 text-left">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`
            })
        </script>
    @endif

    @if (session("success"))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Request Submitted!',
                text: "{{ session("success") }}",
                confirmButtonColor: '#0f172a',
                confirmButtonText: 'Understood',
                background: '#fff',
                color: '#334155',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold'
                },
                timer: 8000,
                timerProgressBar: true
            });
        </script>
    @endif
@endpush
