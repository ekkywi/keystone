@extends("layouts.app")

@section("title", "Documentation")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-lg text-slate-800">Help Center</h2>
            <div class="h-6 w-px bg-slate-200 mx-2"></div>
            <p class="text-sm text-slate-500 font-medium">Documentation & Guides</p>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8 pb-12 relative">

        {{-- SIDEBAR NAVIGATION (Sticky) --}}
        <div class="lg:col-span-1 hidden lg:block">
            <div class="sticky top-6 space-y-8">

                {{-- Table of Contents --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <h3 class="font-bold text-slate-900 text-xs uppercase tracking-widest mb-4 px-2">Table of Contents</h3>
                    <nav class="space-y-1">
                        <a class="group flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition" href="#servers">
                            <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-bold group-hover:bg-indigo-600 group-hover:text-white transition">1</span>
                            Server & SSH
                        </a>
                        <a class="group flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 hover:text-rose-600 transition" href="#projects">
                            <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-rose-50 text-rose-600 text-[10px] font-bold group-hover:bg-rose-600 group-hover:text-white transition">2</span>
                            Projects
                        </a>
                        <a class="group flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 hover:text-amber-600 transition" href="#stacks">
                            <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-amber-50 text-amber-600 text-[10px] font-bold group-hover:bg-amber-600 group-hover:text-white transition">3</span>
                            Stack Templates
                        </a>
                        <a class="group flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 hover:text-emerald-600 transition" href="#services">
                            <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-bold group-hover:bg-emerald-600 group-hover:text-white transition">4</span>
                            Services & Deploy
                        </a>
                        <a class="group flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 hover:text-blue-600 transition" href="#tools">
                            <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-bold group-hover:bg-blue-600 group-hover:text-white transition">5</span>
                            Console & Logs
                        </a>
                        <a class="group flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 hover:text-violet-600 transition" href="#users">
                            <span class="flex items-center justify-center w-6 h-6 rounded-lg bg-violet-50 text-violet-600 text-[10px] font-bold group-hover:bg-violet-600 group-hover:text-white transition">6</span>
                            Team Roles
                        </a>
                    </nav>
                </div>

                {{-- Quick Links --}}
                <div class="bg-slate-900 rounded-2xl p-5 text-white shadow-lg">
                    <h4 class="font-bold text-sm mb-2">Need Support?</h4>
                    <p class="text-xs text-slate-400 mb-4 leading-relaxed">
                        If you encounter issues not covered here, please contact the system administrator.
                    </p>
                    <a class="flex items-center justify-center gap-2 w-full bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl py-2 text-xs font-bold transition" href="{{ route("internal.requests.create") }}">
                        Contact Support
                    </a>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="lg:col-span-3 space-y-12">

            {{-- 1. SERVER MANAGEMENT --}}
            <section class="scroll-mt-24" id="servers">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">1. Server Management</h2>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="prose prose-sm max-w-none text-slate-600 mb-6">
                        <p>Keystone manages your infrastructure by connecting to your VPS via SSH. Before deploying any application, you must connect at least one server.</p>
                    </div>

                    {{-- DIAGRAM: Connection Flow --}}
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4h16v16H4z" />
                            </svg>
                        </div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Connection Workflow</h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm relative">
                                <span class="absolute -top-3 -left-3 w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold ring-4 ring-white">1</span>
                                <h5 class="font-bold text-slate-800 text-sm mb-1">Add Server</h5>
                                <p class="text-xs text-slate-500">Input IP, User (root), and Port. Keystone generates a unique SSH Keypair.</p>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm relative">
                                <span class="absolute -top-3 -left-3 w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold ring-4 ring-white">2</span>
                                <h5 class="font-bold text-slate-800 text-sm mb-1">Install Key</h5>
                                <p class="text-xs text-slate-500">Copy the <strong>Public Key</strong> shown and paste it into <code class="bg-slate-100 px-1 rounded">~/.ssh/authorized_keys</code> on your VPS.</p>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm relative">
                                <span class="absolute -top-3 -left-3 w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold ring-4 ring-white">3</span>
                                <h5 class="font-bold text-slate-800 text-sm mb-1">Test Connection</h5>
                                <p class="text-xs text-slate-500">Click <strong>"Test Connection"</strong>. If successful, you can check Uptime & Disk Usage.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 2. PROJECTS --}}
            <section class="scroll-mt-24" id="projects">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-xl bg-rose-500 text-white flex items-center justify-center shadow-lg shadow-rose-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2 2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">2. Projects & Environments</h2>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-600 mb-4">Projects categorize your applications. Each project is bound to a specific environment lifecycle.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-200 text-emerald-800 mb-2">DEV</span>
                            <h4 class="font-bold text-emerald-900 text-sm">Development</h4>
                            <p class="text-xs text-emerald-700 mt-1">For rapid prototyping and internal testing.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-amber-50 border border-amber-100">
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-200 text-amber-800 mb-2">STAGING</span>
                            <h4 class="font-bold text-amber-900 text-sm">Staging</h4>
                            <p class="text-xs text-amber-700 mt-1">Pre-production environment for QA.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-100">
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-rose-200 text-rose-800 mb-2">PROD</span>
                            <h4 class="font-bold text-rose-900 text-sm">Production</h4>
                            <p class="text-xs text-rose-700 mt-1">Live environment for end-users.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 3. STACK TEMPLATES --}}
            <section class="scroll-mt-24" id="stacks">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">3. Stack Templates</h2>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-6">
                    <div class="flex gap-4">
                        <div class="w-1 bg-amber-500 rounded-full"></div>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            <strong>Stacks</strong> are reusable blueprints for services. Instead of writing Docker Compose files from scratch every time, you define a Master Stack once (e.g., "Postgres 16", "Node.js App") and reuse it across multiple projects.
                        </p>
                    </div>

                    <div class="bg-slate-900 rounded-xl p-5 text-slate-300 font-mono text-xs overflow-x-auto">
                        <div class="flex justify-between items-center border-b border-slate-700 pb-2 mb-2">
                            <span class="text-slate-400">Example: docker-compose.yml template</span>
                            <span class="bg-indigo-500 text-white px-2 py-0.5 rounded text-[10px]">Dynamic Variables</span>
                        </div>
                        <pre>services:
  <span class="text-indigo-400">${SERVICE_NAME}</span>:
    image: postgres:<span class="text-indigo-400">${DB_VERSION}</span>
    environment:
      POSTGRES_PASSWORD: <span class="text-indigo-400">${DB_PASSWORD}</span>
    volumes:
      - <span class="text-indigo-400">${SERVICE_NAME}</span>_data:/var/lib/postgresql/data</pre>
                    </div>
                    <p class="text-xs text-slate-500">Variables like <code class="bg-slate-100 px-1 rounded">${DB_PASSWORD}</code> will be converted into input fields when a user deploys this stack.</p>
                </div>
            </section>

            {{-- 4. SERVICES & DEPLOYMENT --}}
            <section class="scroll-mt-24" id="services">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">4. Services & Deployment</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Git Deployment --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="p-2 bg-orange-50 rounded-lg text-orange-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg></div>
                            <h4 class="font-bold text-slate-800">Application (Git)</h4>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            Connect your GitHub/GitLab repository. Keystone will pull the code, build the Docker image, and deploy it.
                        </p>
                        <ul class="text-xs text-slate-500 space-y-1 ml-1">
                            <li class="flex items-center gap-2"><svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg> Requires Repo URL (HTTPS)</li>
                            <li class="flex items-center gap-2"><svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg> Specify Branch (e.g., main)</li>
                        </ul>
                    </div>

                    {{-- Database Service --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg></div>
                            <h4 class="font-bold text-slate-800">Database & Cache</h4>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            Deploy pre-configured images like MySQL, Postgres, or Redis using Stack Templates.
                        </p>
                        <ul class="text-xs text-slate-500 space-y-1 ml-1">
                            <li class="flex items-center gap-2"><svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg> Configure Password/User via ENV</li>
                            <li class="flex items-center gap-2"><svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg> Persistent Volumes managed auto</li>
                        </ul>
                    </div>
                </div>
            </section>

            {{-- 5. CONSOLE & LOGS --}}
            <section class="scroll-mt-24" id="tools">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">5. Console & Live Logs</h2>
                </div>

                <div class="bg-slate-900 rounded-2xl p-1 shadow-sm overflow-hidden">
                    <div class="flex bg-slate-800/50 px-4 py-2 text-xs font-mono text-slate-400 border-b border-slate-700 justify-between">
                        <span>root@container:/var/www/html</span>
                        <div class="flex gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                        </div>
                    </div>
                    <div class="p-6 font-mono text-sm text-slate-300 space-y-2">
                        <p class="opacity-50"># You can run artisan/npm commands directly</p>
                        <p><span class="text-emerald-400">$</span> php artisan migrate --force</p>
                        <p class="text-slate-400">Migrating: 2024_01_01_000000_create_users_table</p>
                        <p class="text-emerald-400">Migrated: 2024_01_01_000000_create_users_table (32ms)</p>
                        <p><span class="text-emerald-400">$</span> <span class="animate-pulse">_</span></p>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-3 p-4 bg-white border border-slate-200 rounded-xl">
                        <div class="p-2 bg-slate-100 rounded text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l4 4a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg></div>
                        <div>
                            <h5 class="font-bold text-slate-800 text-sm">Live Logs</h5>
                            <p class="text-xs text-slate-500">Real-time container output stream</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-white border border-slate-200 rounded-xl">
                        <div class="p-2 bg-slate-100 rounded text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg></div>
                        <div>
                            <h5 class="font-bold text-slate-800 text-sm">Terminal</h5>
                            <p class="text-xs text-slate-500">Execute commands inside container</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 6. USER ROLES --}}
            <section class="scroll-mt-24" id="users">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-10 w-10 rounded-xl bg-violet-600 text-white flex items-center justify-center shadow-lg shadow-violet-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">6. Team Roles & Access</h2>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase text-[10px]">
                            <tr>
                                <th class="px-6 py-4 font-bold">Role</th>
                                <th class="px-6 py-4 font-bold">Manage Servers</th>
                                <th class="px-6 py-4 font-bold">Deploy Apps</th>
                                <th class="px-6 py-4 font-bold">Manage Users</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">System Admin</span>
                                </td>
                                <td class="px-6 py-4 text-emerald-600 font-bold">✓ Full</td>
                                <td class="px-6 py-4 text-emerald-600 font-bold">✓ Full</td>
                                <td class="px-6 py-4 text-emerald-600 font-bold">✓ Full</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">Developer</span>
                                </td>
                                <td class="px-6 py-4 text-slate-400">View Only</td>
                                <td class="px-6 py-4 text-emerald-600 font-bold">✓ Deploy & Logs</td>
                                <td class="px-6 py-4 text-slate-400">No Access</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-orange-50 text-orange-700 border border-orange-100">QA / Viewer</span>
                                </td>
                                <td class="px-6 py-4 text-slate-400">View Only</td>
                                <td class="px-6 py-4 text-slate-400">View Logs Only</td>
                                <td class="px-6 py-4 text-slate-400">No Access</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>
@endsection
