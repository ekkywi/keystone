<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NewAccessRequestNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PublicRequestController extends Controller
{
    // 1. Tampilkan Halaman Form
    public function create()
    {
        return view('auth.request-access');
    }

    // 2. Proses Simpan & Generate PDF
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'department' => 'required|string|max:100',
            'request_type' => 'required|in:new_account,reset_password,access_grant,other',
            'reason' => 'required|string|max:1000',
        ]);

        // Generate Nomor Surat
        $ticketNumber = AccessRequest::generateTicketNumber();

        // Simpan Data
        $accessRequest = AccessRequest::create([
            'ticket_number' => $ticketNumber,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'department' => $validated['department'],
            'request_type' => $validated['request_type'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        // GENERATE PDF
        $pdf = Pdf::loadView('pdf.access_request', ['request' => $accessRequest]);
        $fileName = 'requests/' . str_replace('/', '-', $ticketNumber) . '.pdf';
        Storage::put('public/' . $fileName, $pdf->output());

        // Update path PDF di database
        $accessRequest->update(['pdf_path' => $fileName]);

        // KIRIM NOTIFIKASI KE SEMUA SYSTEM ADMINISTRATOR
        $admins = User::where('role', 'system_administrator')->get();
        // Notification::send($admins, new NewAccessRequestNotification($accessRequest));

        return redirect()->route('login')->with('success', "Request submitted successfully! Your Ticket Number is #{$ticketNumber}. We have generated a formal letter for this request.");
    }
}
