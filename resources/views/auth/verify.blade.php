<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Document Verification - Keystone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Space+Mono:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .font-mono {
            font-family: 'Space Mono', monospace;
        }

        .bg-pattern {
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>

<body class="bg-slate-50 bg-pattern min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">

        {{-- HEADER: VALID STATUS --}}
        <div class="bg-slate-900 p-6 text-center relative overflow-hidden">
            {{-- Background Effect --}}
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-500"></div>

            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 mb-4 ring-1 ring-emerald-500/50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </div>

            <h1 class="text-xl font-bold text-white tracking-tight">DOCUMENT VERIFIED</h1>
            <p class="text-slate-400 text-xs mt-1 uppercase tracking-widest">Keystone Security Core</p>
        </div>

        {{-- CONTENT --}}
        <div class="p-6 space-y-6">

            {{-- TICKET ID --}}
            <div class="text-center">
                <div class="text-[10px] text-slate-500 uppercase font-bold tracking-wider mb-1">Reference ID</div>
                <div class="text-lg font-mono font-bold text-slate-800 bg-slate-100 py-2 px-4 rounded-lg inline-block border border-slate-200">
                    {{ $request->ticket_number }}
                </div>
            </div>

            {{-- DETAILS GRID --}}
            <div class="border-t border-slate-100 pt-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-[10px] text-slate-400 uppercase font-bold">Applicant Name</div>
                        <div class="text-sm font-semibold text-slate-700">{{ $request->name }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] text-slate-400 uppercase font-bold">Department</div>
                        <div class="text-sm font-semibold text-slate-700">{{ $request->department }}</div>
                    </div>
                </div>

                <div>
                    <div class="text-[10px] text-slate-400 uppercase font-bold">Request Type</div>
                    <div class="text-sm font-semibold text-slate-700">{{ $request->type_label }}</div>
                </div>

                <div>
                    <div class="text-[10px] text-slate-400 uppercase font-bold mb-1">Current Status</div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                        @if ($request->status == "pending") bg-amber-100 text-amber-800
                        @elseif($request->status == "approved") bg-emerald-100 text-emerald-800
                        @else bg-rose-100 text-rose-800 @endif">
                        {{ $request->status }}
                    </span>
                </div>
            </div>

            {{-- TIMESTAMP --}}
            <div class="bg-indigo-50 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
                <div>
                    <div class="text-xs font-bold text-indigo-900">Digital Timestamp</div>
                    <div class="text-[10px] text-indigo-700 font-mono mt-0.5">
                        Created: {{ $request->created_at->format("Y-m-d H:i:s") }} UTC
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="bg-slate-50 p-4 border-t border-slate-200 text-center">
            <p class="text-[10px] text-slate-400">
                &copy; {{ date("Y") }} Keystone Infrastructure Core.<br>This is a system generated verification page.
            </p>
        </div>
    </div>

</body>

</html>
