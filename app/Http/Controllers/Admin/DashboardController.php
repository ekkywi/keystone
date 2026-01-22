<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'    => AccessRequest::count(),
            'pending'  => AccessRequest::where('status', 'pending')->count(),
            'approved' => AccessRequest::where('status', 'approved')->count(),
            'rejected' => AccessRequest::where('status', 'rejected')->count(),
        ];

        $requests = AccessRequest::latest()->paginate(10);

        return view('admin.dashboard', compact('stats', 'requests'));
    }

    public function approve(Request $request, $id)
    {
        $req = AccessRequest::findOrFail($id);

        if ($req->status != 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        try {
            DB::transaction(function () use ($req) {
                // 1. Eksekusi Logika Bisnis
                switch ($req->request_type) {
                    case 'new_account':
                        $this->handleNewAccount($req);
                        break;
                    case 'reset_password':
                        $this->handleResetPassword($req);
                        break;
                }

                // 2. Update Status (Pastikan kolom approved_by sesuai migrasi)
                $req->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id()
                ]);

                // 3. Muat relasi & Generate PDF Baru
                $req->load('approver');
                $this->generateRequestPdf($req);
            });

            return back()->with('success', "Request #{$req->ticket_number} approved and document updated.");
        } catch (\Exception $e) {
            Log::error("Approval Error: " . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $req = AccessRequest::findOrFail($id);

        if ($req->status != 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        try {
            DB::transaction(function () use ($req) {
                $req->update([
                    'status' => 'rejected',
                    'approved_by' => auth()->id()
                ]);

                $req->load('approver');
                $this->generateRequestPdf($req);
            });

            return back()->with('success', 'Request has been rejected and document updated.');
        } catch (\Exception $e) {
            Log::error("Rejection Error: " . $e->getMessage());
            return back()->with('error', 'Failed to reject: ' . $e->getMessage());
        }
    }

    /**
     * Helper untuk Generate & Save PDF
     * Agar kode tidak berulang di approve & reject
     */
    private function generateRequestPdf(AccessRequest $req)
    {
        // A. Generate QR Code
        $verifyUrl = route('request.verify', $req->ticket_number);
        $qrImage = QrCode::format('png')
            ->size(200)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($verifyUrl);

        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrImage);

        // B. Render PDF
        $pdf = Pdf::loadView('pdf.access_request', [
            'request' => $req,
            'qrCode'  => $qrBase64
        ])->setOption(['isRemoteEnabled' => true]);

        // C. Simpan ke Storage (Timpa file lama)
        // Jika belum ada pdf_path, buat namanya secara otomatis
        $fileName = str_replace('/', '-', $req->ticket_number) . '.pdf';
        $filePath = 'requests/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        // Update path jika sebelumnya kosong
        if (!$req->pdf_path) {
            $req->update(['pdf_path' => $filePath]);
        }
    }

    private function handleNewAccount($req)
    {
        if (User::where('email', $req->email)->exists()) {
            throw new \Exception("User with email {$req->email} already exists.");
        }

        User::create([
            'name'       => $req->name,
            'email'      => $req->email,
            'password'   => Hash::make('Keystone2026!'),
            'role'       => 'developer',
            'department' => $req->department,
            'status'     => 'active',
        ]);
    }

    private function handleResetPassword($req)
    {
        $user = User::where('email', $req->email)->first();

        if (!$user) {
            throw new \Exception("Target user for password reset not found.");
        }

        $user->update([
            'password' => Hash::make('Keystone2026!')
        ]);
    }
}
