@extends("layouts.app")

@section("header")
    <div class="flex items-center gap-3 h-full">
        <a class="text-slate-400 hover:text-slate-600 transition" href="{{ route("users.index") }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
        </a>
        <h2 class="font-bold text-lg text-slate-800">Create New User</h2>
    </div>
@endsection

@section("content")
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-base font-semibold text-slate-900">Account Details</h3>
                <p class="text-sm text-slate-500 mt-1">Fill in the information to grant platform access.</p>
            </div>

            <form action="{{ route("users.store") }}" method="POST">
                @csrf
                <div class="p-8 space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Full Name</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 transition-colors" name="name" required type="text" value="{{ old("name") }}">
                            @error("name")
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700">Email Address</label>
                            <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 transition-colors" name="email" required type="email" value="{{ old("email") }}">
                            @error("email")
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700">System Role</label>
                        <select class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-white" name="role">
                            <option value="developer">Developer</option>
                            <option value="quality_assurance">Quality Assurance</option>
                            <option value="system_administrator">System Administrator</option>
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Controls the permission level within the dashboard.</p>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-slate-700">Password</label>
                                <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5" name="password" required type="password">
                                @error("password")
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-slate-700">Confirm Password</label>
                                <input class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5" name="password_confirmation" required type="password">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
                    <a class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors" href="{{ route("users.index") }}">
                        Cancel
                    </a>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-slate-900 rounded-lg hover:bg-slate-800 shadow-lg shadow-slate-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all" type="submit">
                        Create Member
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
