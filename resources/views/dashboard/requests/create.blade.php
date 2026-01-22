{{-- resources/views/dashboard/requests/create.blade.php --}}
@extends("layouts.app")

@section("header")
    <h2 class="font-bold text-lg text-slate-800">Internal Access Request</h2>
@endsection

@section("content")
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route("internal.requests.store") }}" class="p-8" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-6 mb-6">
                    {{-- Nama (Disabled) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Applicant Name</label>
                        <input class="w-full bg-slate-50 border-slate-200 rounded-lg text-slate-500 text-sm" readonly type="text" value="{{ $user->name }}">
                    </div>
                    {{-- Email (Disabled) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Registered Email</label>
                        <input class="w-full bg-slate-50 border-slate-200 rounded-lg text-slate-500 text-sm" readonly type="text" value="{{ $user->email }}">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2 text-indigo-600">Request Type</label>
                    <select class="w-full border-slate-200 rounded-lg text-sm focus:ring-indigo-500" name="request_type">
                        <option value="access_grant">Additional Access Rights</option>
                        <option value="reset_password">Password Reset</option>
                        <option value="other">Other Inquiry</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Justification</label>
                    <textarea class="w-full border-slate-200 rounded-lg text-sm focus:ring-indigo-500" name="reason" placeholder="Explain why you need this access..." rows="4"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <a class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-700 transition" href="{{ route("dashboard") }}">Cancel</a>
                    <button class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition" type="submit">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
