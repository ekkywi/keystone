@extends('layouts.app')

@section('title', 'Edit User')

@section('header')
    <div class="flex justify-between items-center h-full">
        <div class="flex items-center gap-4">
            {{-- Back Button --}}
            <a href="{{ route('users.index') }}" class="group p-2 rounded-xl border border-transparent hover:bg-white hover:border-slate-200 text-slate-400 hover:text-slate-600 transition shadow-sm hover:shadow">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            
            <div class="h-8 w-px bg-slate-200"></div>

            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white border border-slate-200 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="font-bold text-xl text-slate-800 tracking-tight">Edit Profile</h2>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto pb-20">

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-8">

                {{-- 1. USER PROFILE CARD --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">1. User Profile</h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Name --}}
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Full Name</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all placeholder:text-slate-300" 
                                   name="name" required type="text" value="{{ old('name', $user->name) }}">
                            @error('name')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-span-1">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Email Address</label>
                            <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all placeholder:text-slate-300" 
                                   name="email" required type="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="col-span-2">
                            <label class="block text-xs font-bold uppercase text-slate-500 mb-2">System Role</label>
                            <div class="relative">
                                <select class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all appearance-none bg-white cursor-pointer" name="role">
                                    <option value="developer" {{ $user->role == 'developer' ? 'selected' : '' }}>Developer</option>
                                    <option value="quality_assurance" {{ $user->role == 'quality_assurance' ? 'selected' : '' }}>Quality Assurance</option>
                                    <option value="system_administrator" {{ $user->role == 'system_administrator' ? 'selected' : '' }}>System Administrator</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. SECURITY CARD (Update Password) --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide">2. Security Update</h3>
                        </div>
                        <div class="px-2 py-1 bg-amber-50 border border-amber-100 rounded text-[10px] text-amber-700 font-bold">
                            Optional
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="mb-4 bg-amber-50 border border-amber-100 rounded-xl p-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <div class="text-xs text-amber-800 leading-relaxed">
                                <p class="font-bold mb-1">Changing Password?</p>
                                Leave the fields below <strong>empty</strong> if you want to keep the current password. Only fill them if you intend to change it.
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- New Password --}}
                            <div class="col-span-1">
                                <label class="block text-xs font-bold uppercase text-slate-500 mb-2">New Password</label>
                                <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all" 
                                       name="password" type="password" placeholder="••••••••">
                                @error('password')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-span-1">
                                <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Confirm Password</label>
                                <input class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 text-sm px-4 py-3 shadow-sm transition-all" 
                                       name="password_confirmation" type="password" placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition" href="{{ route('users.index') }}">Cancel</a>
                    <button class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20 flex items-center gap-2 transform active:scale-95 duration-200" type="submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Save Changes
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection