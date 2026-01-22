<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $request->ticket_number }}</title>
    <style>
        @page {
            margin: 0cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #ffffff;
            color: #334155;
            margin: 0;
            padding: 0;
            font-size: 9pt;
            line-height: 1.4;
        }

        /* --- HEADER FIXED --- */
        .header-wrapper {
            background-color: #0f172a;
            color: white;
            padding: 25px 40px;
            height: 80px;
            border-bottom: 5px solid {{ $request->status == "approved" ? "#10b981" : ($request->status == "rejected" ? "#f43f5e" : "#f59e0b") }};
            position: relative;
            overflow: hidden;
        }

        /* PATTERN */
        .header-pattern-layer {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            opacity: 0.4;
        }

        .shard {
            position: absolute;
            background-color: #1e293b;
            transform: rotate(45deg);
        }

        .s1 {
            width: 500px;
            height: 500px;
            top: -350px;
            left: -150px;
        }

        .s2 {
            width: 300px;
            height: 300px;
            bottom: -200px;
            right: -80px;
            background-color: #334155;
            transform: rotate(30deg);
        }

        .header-content-layer {
            position: relative;
            z-index: 10;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
            border: none;
        }

        .logo-text {
            font-size: 22pt;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #ffffff;
        }

        .logo-sub {
            font-size: 8pt;
            opacity: 0.8;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #e2e8f0;
        }

        .qr-label {
            font-size: 7pt;
            text-transform: uppercase;
            margin-bottom: 5px;
            opacity: 0.9;
            text-align: right;
            color: #e2e8f0;
        }

        .qr-box {
            background: white;
            padding: 3px;
            border-radius: 2px;
            display: inline-block;
        }

        /* --- CONTENT --- */
        .container {
            padding: 30px 40px;
        }

        /* HEADER PER SECTION (NOMOR 01, 02, 03) */
        .section-header {
            border-bottom: 2px solid #e2e8f0;
            color: #0f172a;
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 30px;
            /* Jarak antar section */
            margin-bottom: 15px;
            padding-bottom: 5px;
        }

        /* TABEL DATA */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 8px 5px;
            vertical-align: top;
            border-bottom: 1px dashed #e2e8f0;
        }

        .label {
            font-size: 7pt;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
            font-weight: bold;
        }

        .value {
            font-size: 10pt;
            font-weight: 600;
            color: #1e293b;
        }

        .mono {
            font-family: 'Courier New', monospace;
        }

        /* --- TRACKING BOX (SECTION 2) --- */
        .tracking-box {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
        }

        /* Approved Style */
        .track-approved {
            background-color: #ecfdf5;
            border-color: #10b981;
        }

        .track-title-approved {
            color: #047857;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        /* Rejected Style */
        .track-rejected {
            background-color: #fff1f2;
            border-color: #f43f5e;
        }

        .track-title-rejected {
            color: #be123c;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        /* Pending Style */
        .track-pending {
            background-color: #fffbeb;
            border-color: #f59e0b;
        }

        .track-title-pending {
            color: #b45309;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        /* Credential Box Inner */
        .cred-box {
            background: white;
            border: 1px dashed #cbd5e1;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }

        /* --- SIGNATURE CARDS (SECTION 3) --- */
        .sig-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
            height: 190px;
        }

        .sig-bar {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 6px;
        }

        .bar-blue {
            background-color: #6366f1;
        }

        .bar-green {
            background-color: #10b981;
        }

        .bar-red {
            background-color: #f43f5e;
        }

        .bar-orange {
            background-color: #f59e0b;
        }

        .sig-content {
            padding: 15px 15px 15px 25px;
        }

        .sig-role {
            font-size: 7pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .sig-name {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .sig-email {
            font-size: 8pt;
            color: #6366f1;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .sig-meta {
            font-size: 7pt;
            color: #94a3b8;
            line-height: 1.3;
        }

        /* System Auth Box */
        .sys-auth-box {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #e2e8f0;
        }

        .auth-label {
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .auth-val {
            font-family: 'Courier New', monospace;
            font-size: 8pt;
            color: #334155;
            font-weight: bold;
        }

        .hash-code {
            font-family: 'Courier New', monospace;
            font-size: 6pt;
            color: #94a3b8;
            margin-top: 4px;
            word-break: break-all;
        }

        .text-blue {
            color: #4338ca;
        }

        .text-green {
            color: #047857;
        }

        .text-red {
            color: #be123c;
        }

        .text-orange {
            color: #b45309;
        }

        .watermark {
            position: fixed;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 70pt;
            font-weight: 900;
            z-index: -1;
            white-space: nowrap;
            opacity: 0.08;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            padding-top: 10px;
            font-size: 7pt;
            color: #94a3b8;
        }
    </style>
</head>

<body>

    {{-- DYNAMIC WATERMARK --}}
    @if ($request->status == "approved")
        <div class="watermark" style="color: #10b981;">ACCESS GRANTED</div>
    @elseif($request->status == "rejected")
        <div class="watermark" style="color: #f43f5e;">REJECTED</div>
    @else
        <div class="watermark" style="color: #f59e0b; opacity: 0.05;">PENDING REVIEW</div>
    @endif

    {{-- HEADER --}}
    <div class="header-wrapper">
        <div class="header-pattern-layer">
            <div class="shard s1"></div>
            <div class="shard s2"></div>
        </div>

        <div class="header-content-layer">
            <table class="header-table">
                <tr>
                    <td style="width: 70%;">
                        <div class="logo-text">KEYSTONE</div>
                        <div class="logo-sub">Infrastructure Core</div>
                    </td>
                    <td style="width: 30%; text-align: right;">
                        <div class="qr-label">Scan to Verify</div>
                        <div class="qr-box">
                            <img alt="Main QR" height="55" src="{{ $qrCode }}" width="55">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="container">

        {{-- TICKET INFO --}}
        <div style="background: #f8fafc; padding: 12px 20px; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
            <table width="100%">
                <tr>
                    <td>
                        <div class="label">Ticket Reference Number</div>
                        <div class="value mono" style="font-size: 12pt; color: #0f172a;">{{ $request->ticket_number }}</div>
                    </td>
                    <td style="text-align: right;">
                        <div class="label">Submission Timestamp</div>
                        <div class="value">{{ $request->created_at->format("d F Y, H:i") }} UTC</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- ========================================================= --}}
        {{-- SECTION 1: REQUEST DETAILS --}}
        {{-- ========================================================= --}}
        <div class="section-header">01. Request Details</div>
        <table class="data-table">
            <tr>
                <td width="60%">
                    <div class="label">Applicant Name</div>
                    <div class="value">{{ strtoupper($request->name) }}</div>
                </td>
                <td width="40%">
                    <div class="label">Department</div>
                    <div class="value">{{ strtoupper($request->department) }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="label">Email Address</div>
                    <div class="value mono">{{ $request->email }}</div>
                </td>
                <td>
                    <div class="label">Request Type</div>
                    <div class="value">{{ $request->type_label }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: none; padding-top: 15px;">
                    <div class="label">Business Justification</div>
                    <div style="background: #ffffff; padding: 10px; border: 1px solid #e2e8f0; border-left: 3px solid #cbd5e1; border-radius: 4px; color: #475569; font-size: 9pt;">
                        {{ $request->reason }}
                    </div>
                </td>
            </tr>
        </table>

        {{-- ========================================================= --}}
        {{-- SECTION 2: ADMINISTRATIVE DECISION --}}
        {{-- ========================================================= --}}
        <div class="section-header">02. Administrative Decision</div>

        {{-- KOTAK STATUS DINAMIS --}}
        @if ($request->status == "approved")
            {{-- STATUS: APPROVED --}}
            <div class="tracking-box track-approved">
                <table width="100%">
                    <tr>
                        <td style="vertical-align: top;">
                            <div class="track-title-approved">Request Status: APPROVED</div>

                            {{-- LOGIKA PEMBEDA ISI --}}
                            @if (in_array($request->request_type, ["new_account", "reset_password"]))
                                <div style="font-size: 9pt; color: #065f46;">
                                    This request has been reviewed and approved by the Systems Administrator. <br>
                                    Access credentials have been automatically generated below.
                                </div>

                                <div class="cred-box">
                                    <div class="label" style="color: #047857; margin-bottom: 5px;">LOGIN CREDENTIALS</div>
                                    <div style="font-family: 'Courier New', monospace; font-size: 10pt; color: #1e293b;">
                                        Username: <strong>{{ $request->email }}</strong>
                                    </div>
                                    <div style="font-family: 'Courier New', monospace; font-size: 10pt; color: #1e293b; margin-top: 3px;">
                                        Password: <strong>Keystone2026!</strong>
                                    </div>
                                    <div style="font-size: 7pt; color: #ef4444; margin-top: 5px; font-weight: bold;">
                                        *IMPORTANT: Change this password immediately upon first login.
                                    </div>
                                </div>
                            @else
                                <div style="font-size: 9pt; color: #065f46;">
                                    Your request for <strong>{{ $request->type_label }}</strong> has been verified.
                                    Your current account has been granted the necessary permissions.
                                </div>
                                <div class="cred-box" style="background-color: #f0fdf4; border-color: #10b981; border-style: solid;">
                                    <div class="label" style="color: #047857;">AUTHORIZATION NOTE</div>
                                    <div style="font-size: 9pt; color: #1e293b; margin-top: 5px; line-height: 1.4;">
                                        Access to requested resources has been synchronized with your profile.
                                        <strong>No password change required.</strong> You may now use your existing credentials to log in.
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td style="width: 80px; text-align: center; vertical-align: middle;">
                            {{-- FIX: Pakai font DejaVu Sans agar ikon muncul --}}
                            <div style="font-family: 'DejaVu Sans', sans-serif; font-size: 35pt; color: #10b981;">&#10003;</div>
                            <div style="font-size: 7pt; font-weight: bold; color: #059669; text-transform: uppercase;">Complete</div>
                        </td>
                    </tr>
                </table>
            </div>
        @elseif($request->status == "rejected")
            {{-- STATUS: REJECTED --}}
            <div class="tracking-box track-rejected">
                <table width="100%">
                    <tr>
                        <td style="vertical-align: top;">
                            <div class="track-title-rejected">Request Status: REJECTED</div>
                            <div style="font-size: 9pt; color: #9f1239;">
                                This request has been declined by the Systems Administrator.<br>
                                No access credentials were generated.
                            </div>

                            <div class="cred-box" style="border-color: #fda4af;">
                                <div class="label" style="color: #be123c;">ADMINISTRATIVE NOTE</div>
                                <div style="font-size: 9pt; color: #881337;">
                                    The request does not meet the current infrastructure security policy or lacks sufficient justification. Please contact IT Support for clarification.
                                </div>
                            </div>
                        </td>
                        <td style="width: 80px; text-align: center; vertical-align: middle;">
                            {{-- FIX: Pakai font DejaVu Sans --}}
                            <div style="font-family: 'DejaVu Sans', sans-serif; font-size: 35pt; color: #f43f5e;">&#10007;</div>
                            <div style="font-size: 7pt; font-weight: bold; color: #be123c; text-transform: uppercase;">Declined</div>
                        </td>
                    </tr>
                </table>
            </div>
        @else
            {{-- STATUS: PENDING --}}
            <div class="tracking-box track-pending">
                <table width="100%">
                    <tr>
                        <td style="vertical-align: top;">
                            <div class="track-title-pending">Request Status: PENDING REVIEW</div>
                            <div style="font-size: 9pt; color: #92400e;">
                                This request has been submitted and is currently in the queue for Administrator review.<br>
                                Please allow 24-48 hours for processing.
                            </div>

                            <div class="cred-box" style="border-color: #fcd34d; background: #fffbeb;">
                                <div class="label" style="color: #b45309;">NEXT STEP</div>
                                <div style="font-size: 9pt; color: #92400e;">
                                    Digital signature required from System Administrator. Once approved, credentials will appear here.
                                </div>
                            </div>
                        </td>
                        <td style="width: 80px; text-align: center; vertical-align: middle;">
                            {{-- FIX: Pakai font DejaVu Sans --}}
                            <div style="font-family: 'DejaVu Sans', sans-serif; font-size: 35pt; color: #f59e0b;">&#8987;</div>
                            <div style="font-size: 7pt; font-weight: bold; color: #b45309; text-transform: uppercase;">Waiting</div>
                        </td>
                    </tr>
                </table>
            </div>
        @endif

        {{-- ========================================================= --}}
        {{-- SECTION 3: DIGITAL AUTHORIZATION --}}
        {{-- ========================================================= --}}
        <div class="section-header">03. Digital Authorization</div>

        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                {{-- [KIRI] APPLICANT CARD --}}
                <td style="vertical-align: top; border: none;" width="48%">
                    <div class="sig-card">
                        <div class="sig-bar bar-blue"></div>
                        <div class="sig-content">
                            <div class="sig-role">REQUESTED BY</div>
                            <div class="sig-name">{{ strtoupper($request->name) }}</div>
                            <div class="sig-email text-blue">{{ $request->email }}</div>

                            <div class="sig-meta">
                                Signed: {{ $request->created_at->format("Y-m-d H:i:s") }}<br>
                                IP Addr: 127.0.0.1 (Recorded)
                            </div>

                            {{-- SYSTEM AUTH BELOW NAME --}}
                            <div class="sys-auth-box">
                                <table width="100%">
                                    <tr>
                                        <td style="border: none; vertical-align: top;">
                                            <div class="auth-label text-blue">System Authorization</div>
                                            <div class="auth-val">Keystone Security Core</div>
                                            <div class="hash-code">
                                                HASH: {{ md5($request->created_at . $request->ticket_number) }}
                                            </div>
                                        </td>
                                        <td style="border: none; text-align: right; width: 45px; vertical-align: middle;">
                                            <img alt="QR" height="45" src="{{ $qrCode }}" width="45">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </td>

                <td style="border: none;" width="4%"></td>

                {{-- [KANAN] APPROVER CARD --}}
                <td style="vertical-align: top; border: none;" width="48%">

                    @if ($request->status == "approved")
                        <div class="sig-card">
                            <div class="sig-bar bar-green"></div>
                            <div class="sig-content">
                                {{-- AMBIL NAMA & EMAIL DARI RELASI APPROVER --}}
                                <div class="sig-role text-green">AUTHORIZED BY</div>
                                <div class="sig-name">{{ strtoupper($request->approver->name ?? "SYSTEM ADMINISTRATOR") }}</div>
                                <div class="sig-email text-green">{{ strtoupper($request->approver->email ?? "ADMIN@KEYSTONE.COM") }}</div>

                                <div class="sig-meta">
                                    Date: {{ $request->updated_at->format("Y-m-d H:i:s") }}<br>
                                    Action: <strong>Access Granting</strong>
                                </div>

                                <div class="sys-auth-box">
                                    <table width="100%">
                                        <tr>
                                            <td style="border: none; vertical-align: top;">
                                                <div class="auth-label text-green">System Authorization</div>
                                                <div class="auth-val">Keystone Security Core</div>
                                                <div class="hash-code">
                                                    {{-- Hash menggunakan ID Admin agar lebih unik --}}
                                                    HASH: {{ md5("APP_" . $request->approved_by . $request->updated_at) }}
                                                </div>
                                            </td>
                                            <td style="border: none; text-align: right; width: 45px; vertical-align: middle;">
                                                <img alt="QR" height="45" src="{{ $qrCode }}" width="45">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @elseif($request->status == "rejected")
                        <div class="sig-card">
                            <div class="sig-bar bar-red"></div>
                            <div class="sig-content">
                                {{-- AMBIL NAMA & EMAIL DARI RELASI APPROVER --}}
                                <div class="sig-role text-red">REJECTED BY</div>
                                <div class="sig-name">{{ strtoupper($request->approver->name ?? "SYSTEM ADMINISTRATOR") }}</div>
                                <div class="sig-email text-red">{{ strtoupper($request->approver->email ?? "ADMIN@KEYSTONE.COM") }}</div>

                                <div class="sig-meta">
                                    Date: {{ $request->updated_at->format("Y-m-d") }}<br>
                                    Reason: Administrative Decision
                                </div>

                                <div class="sys-auth-box">
                                    <table width="100%">
                                        <tr>
                                            <td style="border: none; vertical-align: top;">
                                                <div class="auth-label text-red">Status Update</div>
                                                <div class="auth-val">Request Declined</div>
                                                <div class="hash-code">HASH: {{ md5("REJ_" . $request->approved_by . $request->updated_at) }}</div>
                                            </td>
                                            <td style="border: none; text-align: right; width: 45px; vertical-align: middle;">
                                                <img height="45" src="{{ $qrCode }}" style="opacity: 0.5" width="45">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- PENDING CARD --}}
                        <div class="sig-card" style="background-color: #f8fafc; border: 1px dashed #cbd5e1;">
                            <div class="sig-bar bar-orange"></div>
                            <div class="sig-content" style="opacity: 0.6;">
                                <div class="sig-role text-orange">PENDING APPROVAL</div>
                                <div class="sig-name" style="color: #94a3b8;">WAITING FOR REVIEW</div>
                                <div style="height: 35px;"></div>

                                <div class="sig-meta">
                                    This request is currently under review by the infrastructure team.
                                </div>
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        <div style="margin-top: 20px; text-align: center; font-size: 6pt; color: #cbd5e1;">
            Securely generated by Keystone Core | Verify at {{ route("request.verify", $request->ticket_number) }}
        </div>

    </div>

    <div class="footer">
        Page 1 of 1 &bull; Keystone Infrastructure Core &bull; {{ date("Y") }}
    </div>

</body>

</html>
