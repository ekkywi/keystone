@extends("layouts.app")

@section("header")
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-4">
            <a class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition" href="{{ route("projects.index") }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </a>

            <div class="h-8 w-px bg-slate-200"></div>

            <div>
                <div class="flex items-center gap-2">
                    <h2 class="font-bold text-lg text-slate-800 leading-none">{{ $project->name }}</h2>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border 
                        {{ $project->environment == "production" ? "bg-rose-50 text-rose-700 border-rose-100" : ($project->environment == "staging" ? "bg-amber-50 text-amber-700 border-amber-100" : "bg-emerald-50 text-emerald-700 border-emerald-100") }}">
                        {{ $project->environment }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">{{ $project->description ?? "Single server deployment" }}</p>
            </div>
        </div>

        <a class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2" href="{{ route("projects.services.create", $project) }}"> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Add Service
        </a>
    </div>
@endsection

@section("content")
    <div class="space-y-8">

        @if ($project->services->count() == 0)
            <div class="bg-slate-50 border border-dashed border-slate-300 rounded-xl p-12 text-center">
                <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Project is empty</h3>
                <p class="text-slate-500 max-w-sm mx-auto mt-2 mb-6">
                    Start by adding a service like a Database (Postgres/MySQL) or an Application (Node/PHP).
                </p>
                <a class="inline-flex items-center text-indigo-600 font-semibold text-sm hover:underline" href="{{ route("projects.services.create", $project) }}">
                    Deploy first service &rarr;
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($project->services as $service)
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:border-indigo-400 transition group relative overflow-hidden">

                        <div class="absolute top-0 inset-x-0 h-1 
                            {{ $service->status == "running" ? "bg-emerald-500" : ($service->status == "failed" ? "bg-rose-500" : "bg-slate-300") }}">
                        </div>

                        <div class="p-5">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-slate-50 text-slate-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($service->stack->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800">{{ $service->name }}</h3>
                                        <p class="text-xs text-slate-500">{{ $service->stack->name }}</p>
                                    </div>
                                </div>

                                <span class="flex items-center gap-1.5 px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border
                                    {{ $service->status == "running" ? "bg-emerald-50 text-emerald-700 border-emerald-100" : "bg-slate-50 text-slate-600 border-slate-100" }}">
                                    @if ($service->status == "running")
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    @else
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    @endif
                                    {{ $service->status }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-y-2 text-xs text-slate-500 mt-4 border-t border-slate-50 pt-4">
                                <div>
                                    <span class="block text-slate-400 mb-0.5">Target Server</span>
                                    <span class="font-mono text-slate-700">{{ $service->server->name }}</span>
                                </div>
                                <div>
                                    <span class="block text-slate-400 mb-0.5">Public Port</span>
                                    <span class="font-mono text-slate-700">{{ $service->public_port ?? "-" }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex justify-between items-center">

                            <div class="flex gap-2">
                                @if (in_array($service->status, ["stopped", "failed"]))
                                    <form action="{{ route("services.deploy", $service) }}" method="POST">
                                        @csrf
                                        <button class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition flex items-center gap-1" type="submit">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                            Deploy
                                        </button>
                                    </form>
                                @endif

                                @if (in_array($service->status, ["running", "building"]))
                                    <form action="{{ route("services.stop", $service) }}" method="POST">
                                        @csrf
                                        <button class="text-xs font-bold text-rose-600 hover:text-rose-800 transition flex items-center gap-1" type="submit">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                            Stop
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <span class="text-[10px] text-slate-400 font-mono">{{ $service->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
