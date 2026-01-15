@extends("layouts.guest")

{{-- CUSTOM CSS: ANIMASI & SHIMMER --}}
@push("styles")
    <style>
        .terminal-cursor {
            animation: blink 1s step-end infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        /* FIXED: Class Shimmer ditambahkan */
        .shimmer-text {
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            to { background-position: 200% center; }
        }
    </style>
@endpush

@section("content")
    <div class="min-h-screen flex bg-white">

        <div class="hidden lg:flex w-1/2 bg-slate-950 relative overflow-hidden flex-col justify-between p-12 lg:p-16">
            
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute inset-0" style="background-image: radial-gradient(rgba(99, 102, 241, 0.15) 1px, transparent 1px); background-size: 32px 32px;"></div>
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-indigo-600/30 rounded-full blur-[128px] mix-blend-screen"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-cyan-600/20 rounded-full blur-[128px] mix-blend-screen"></div>
            </div>

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

            <div class="relative z-10">
                <h2 class="text-3xl font-bold text-white leading-tight mb-6">
                    Deploy faster, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-400 via-slate-200 to-slate-400">break things less.</span>
                </h2>

                <div class="relative bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-2xl max-w-md overflow-hidden ring-1 ring-indigo-500/20 shadow-2xl">
                    <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
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

            <div class="relative z-10 flex items-center gap-2 text-xs font-mono text-slate-500">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 inline-block"></span>
                System Operational / v1.0.0
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white relative">
            
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-500 lg:hidden"></div>

            <div class="w-full max-w-[400px]">
                
                <div class="lg:hidden mb-8 flex items-center gap-2">
                    <div class="h-8 w-8 bg-slate-900 rounded-lg flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" /></svg>
                    </div>
                    <span class="font-bold text-slate-900 tracking-wide">KEYSTONE</span>
                </div>

                <div class="mb-10">
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Welcome back</h1>
                    <p class="text-slate-500 text-sm mt-2">Sign in to access your infrastructure console.</p>
                </div>

                <form id="loginForm" action="{{ route("login.process") }}" class="space-y-5" method="POST">
                    @csrf

                    <div class="space-y-1.5 relative">
                        <label class="block text-sm font-semibold text-slate-700" for="email">Work Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" /></svg>
                            </div>
                            <input autofocus class="block w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all shadow-sm" id="email" name="email" placeholder="engineer@company.com" required type="email" value="{{ old("email") }}">
                        </div>
                    </div>

                    <div class="space-y-1.5 relative">
                        <div class="flex justify-between items-center">
                            <label class="block text-sm font-semibold text-slate-700" for="password">Password</label>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" /></svg>
                            </div>
                            
                            <input class="block w-full pl-11 pr-12 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all shadow-sm" id="password" name="password" placeholder="••••••••" required type="password">

                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
                                <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg id="eyeOffIcon" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-colors" name="remember" type="checkbox">
                            <span class="text-sm font-medium text-slate-600 group-hover:text-slate-800 transition-colors">Remember me</span>
                        </label>
                        <a class="text-sm font-medium text-indigo-600 hover:text-indigo-700 hover:underline transition-colors" href="#">Forgot password?</a>
                    </div>

                    <button id="submitBtn" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-slate-900 hover:bg-gradient-to-r hover:from-slate-900 hover:to-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-900 transition-all duration-300 shadow-lg shadow-slate-900/20 hover:shadow-xl hover:shadow-indigo-900/30 active:scale-[0.98] relative overflow-hidden disabled:opacity-70 disabled:cursor-not-allowed" type="submit">
                        <span class="absolute inset-0 bg-white/10 opacity-0 hover:opacity-100 transition-opacity"></span>
                        
                        <span id="btnText" class="relative">Sign In to Console</span>
                        
                        <span id="btnLoading" class="hidden relative items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Authenticating...
                        </span>
                    </button>
                </form>

                <div class="mt-10 pt-6 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-500">
                        Don't have an account?
                        <a class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors" href="#">Contact Admin</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        // 1. Toggle Password Visibility
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

        // 2. Loading State pada Tombol Submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');

            // Disable tombol dan ganti konten
            btn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            btnLoading.classList.add('flex'); // Agar spinner dan text sejajar
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
                    popup: 'rounded-xl border border-rose-100 shadow-xl',
                    title: 'text-rose-800 font-bold',
                    htmlContainer: 'text-sm text-rose-600'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: 'Access Denied',
                html: `
                <ul class="list-disc pl-4 text-left">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `
            })
        </script>
    @endif
@endpush