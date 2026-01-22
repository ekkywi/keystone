{{-- resources/views/profile/edit.blade.php --}}
@extends("layouts.app")

@section("title", "My Profile")

@section("header")
    <h2 class="font-bold text-xl text-slate-800 tracking-tight">Account Settings</h2>
    <p class="text-xs text-slate-500 mt-0.5">Manage your personal information and security</p>
@endsection

@section("content")
    <div class="max-w-4xl mx-auto pb-20">
        <form action="{{ route("profile.update") }}" method="POST">
            @csrf
            @method("PATCH")

            <div class="space-y-8">
                {{-- PERSONAL INFORMATION --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Personal Information</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Full Name</label>
                            <input class="w-full rounded-xl border-slate-200 text-sm px-4 py-3" name="name" type="text" value="{{ old("name", $user->name) }}">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Email Address (Read-only)</label>
                            <input class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-400 text-sm px-4 py-3" readonly type="email" value="{{ $user->email }}">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Department</label>
                            <input class="w-full rounded-xl border-slate-200 text-sm px-4 py-3" name="department" type="text" value="{{ old("department", $user->department) }}">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Role</label>
                            <span class="inline-flex items-center px-3 py-1 mt-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ ucwords(str_replace("_", " ", $user->role)) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- SECURITY --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Update Password</h3>
                        <span class="text-[10px] bg-amber-50 text-amber-600 px-2 py-0.5 rounded border border-amber-100 font-bold uppercase">Security</span>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">New Password</label>
                            <input class="w-full rounded-xl border-slate-200 text-sm px-4 py-3" name="password" placeholder="••••••••" type="password">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Confirm New Password</label>
                            <input class="w-full rounded-xl border-slate-200 text-sm px-4 py-3" name="password_confirmation" placeholder="••••••••" type="password">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button class="bg-indigo-600 text-white px-10 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95" type="submit">
                        Save Profile Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
