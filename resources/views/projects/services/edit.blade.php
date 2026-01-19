@extends("layouts.app")

@section("header")
    <div class="flex justify-between items-center h-full">
        <h2 class="font-bold text-lg text-slate-800">Edit Service: {{ $service->name }}</h2>
        <a class="text-sm font-medium text-slate-500 hover:text-slate-700 transition" href="{{ route("projects.show", $service->project) }}">Back to Project</a>
    </div>
@endsection

@section("content")
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">

            <form action="{{ route("services.update", $service) }}" class="space-y-6" method="POST">
                @csrf
                @method("PUT")

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Service Name</label>
                        <input class="w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2" name="name" required type="text" value="{{ old("name", $service->name) }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Target Server (Read-only)</label>
                        <input class="w-full rounded-lg border-slate-200 bg-slate-100 text-slate-500 sm:text-sm px-4 py-2" disabled type="text" value="{{ $service->server->name }} ({{ $service->server->ip_address }})">
                    </div>
                </div>

                <div class="border-t border-slate-100 my-6"></div>

                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                            {{ substr($service->stack->name, 0, 2) }}
                        </div>
                        <h3 class="font-bold text-slate-800">Configuration Variables</h3>
                    </div>

                    <div class="space-y-4 bg-slate-50 p-5 rounded-lg border border-slate-200">
                        @foreach ($service->stack->variables as $var)
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-500 mb-1">
                                    {{ $var->label }} <span class="text-slate-400 font-normal">({{ $var->env_key }})</span>
                                </label>

                                @php
                                    $savedValue = $service->input_variables[$var->env_key] ?? null;

                                    $defaultValue = $var->default_value;

                                    $finalValue = $savedValue ?? ($defaultValue ?? "");
                                @endphp

                                <input class="w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 font-mono text-slate-700" name="vars[{{ $var->env_key }}]" placeholder="Default: {{ $defaultValue }}" type="{{ $var->type == "password" ? "text" : ($var->type == "number" ? "number" : "text") }}" value="{{ old("vars." . $var->env_key, $finalValue) }}">
                                <p class="text-[10px] text-slate-400 mt-1">{{ $var->description ?? "Update this value if needed." }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition" href="{{ route("projects.show", $service->project) }}">Cancel</a>
                        <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20" type="submit">
                            Save Changes
                        </button>
                    </div>
            </form>
        </div>
    </div>
@endsection
