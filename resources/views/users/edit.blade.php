@extends("layouts.app")

@section("header")
    <div class="flex items-center gap-3 h-full">
        <a class="text-slate-400 hover:text-slate-600 transition" href="{{ route("users.index") }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </a>
        <div class="flex flex-col">
            <h2 class="font-bold text-lg text-slate-800 leading-tight">Edit Profile</h2>
            <p class="text-xs text-slate-500 font-mono">{{ $user->name }}</p>
        </div>
    </div>
@endsection

@section("content")
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            <form action="{{ route("users.update", $user) }}" method="POST">
                @csrf
                @method("PUT")

                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Full Name</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5" name="name" required type="text" value="{{ old("name", $user->name) }}">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Email Address</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5" name="email" required type="email" value="{{ old("email", $user->email) }}">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700">System Role</label>
                        <select class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-white" name="role">
                            <option {{ $user->role == "developer" ? "selected" : "" }} value="developer">Developer</option>
                            <option {{ $user->role == "quality_assurance" ? "selected" : "" }} value="quality_assurance">Quality Assurance</option>
                            <option {{ $user->role == "system_administrator" ? "selected" : "" }} value="system_administrator">System Administrator</option>
                        </select>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <div class="bg-amber-50 rounded-lg border border-amber-100 p-5">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="p-2 bg-amber-100 rounded-md text-amber-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-amber-900">Security Update</h4>
                                    <p class="text-xs text-amber-700 mt-0.5">Leave these fields empty if you don't want to change the password.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input class="block w-full rounded-lg border-amber-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm px-4 py-2.5 bg-white" name="password" placeholder="New Password" type="password">
                                <input class="block w-full rounded-lg border-amber-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm px-4 py-2.5 bg-white" name="password_confirmation" placeholder="Confirm Password" type="password">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
                    <a class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors" href="{{ route("users.index") }}">
                        Cancel
                    </a>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 shadow-lg shadow-slate-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all" type="submit">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
