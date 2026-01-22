<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\NewAccessRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\AccessRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class AccessRequestController extends Controller
{
    public function index()
    {
        $requests = AccessRequest::where('email', auth()->user()->email)
            ->latest()
            ->paginate(10);

        return view('dashboard.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('auth.request-access');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'department' => 'required|string|max:100',
            'request_type' => 'required|in:new_account,reset_password,access_grant,other',
            'reason' => 'required|string|max:1000',
        ]);

        return DB::transaction(function () use ($validated) {

            $ticketNumber = AccessRequest::generateTicketNumber();

            $accessRequest = AccessRequest::create([
                'ticket_number' => $ticketNumber,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'department' => $validated['department'],
                'request_type' => $validated['request_type'],
                'reason' => $validated['reason'],
                'status' => 'pending',
            ]);

            $verifyUrl = url('/verify/' . $ticketNumber);

            $qrImage = QrCode::format('png')
                ->size(200)
                ->margin(1)
                ->errorCorrection('H')
                ->generate($verifyUrl);

            $qrBase64 = 'data:image/png;base64,' . base64_encode($qrImage);

            $pdf = Pdf::loadView('pdf.access_request', [
                'request' => $accessRequest,
                'qrCode'  => $qrBase64
            ]);

            $pdf->setOption(['isRemoteEnabled' => true]);

            $fileName = str_replace('/', '-', $ticketNumber) . '.pdf';
            $filePath = 'requests/' . $fileName;

            if (!Storage::disk('public')->exists('requests')) {
                Storage::disk('public')->makeDirectory('requests');
            }
            Storage::disk('public')->put($filePath, $pdf->output());

            $accessRequest->update(['pdf_path' => $filePath]);

            return redirect()->route('login')
                ->with('success', "Request submitted successfully! Your Ticket Number is #{$ticketNumber}. We have generated a formal letter for this request.");
        });
    }

    public function verifyQr($ticket_number)
    {
        $accessRequest = AccessRequest::where('ticket_number', $ticket_number)->first();

        if (!$accessRequest) {
            abort(404, 'Document Not Found');
        }

        return view('auth.verify', ['request' => $accessRequest]);
    }

    public function createInternal()
    {
        $user = auth()->user();
        return view('dashboard.requests.create', compact('user'));
    }

    public function storeInternal(Request $request)
    {
        $request->validate([
            'request_type' => 'required|in:reset_password,access_grant,other',
            'reason' => 'required|min:10',
        ]);

        $user = auth()->user();

        DB::transaction(function () use ($request, $user) {

            $ticketNumber = AccessRequest::generateTicketNumber();

            $accessRequest = AccessRequest::create([
                'ticket_number' => AccessRequest::generateTicketNumber(),
                'name' => $user->name,
                'email' => $user->email,
                'department' => $user->department,
                'request_type' => $request->request_type,
                'reason' => $request->reason,
                'status' => 'pending',
            ]);

            $verifyUrl = url('/verify/' . $ticketNumber);

            $qrImage = QrCode::format('png')
                ->size(200)
                ->margin(1)
                ->errorCorrection('H')
                ->generate($verifyUrl);

            $qrBase64 = 'data:image/png;base64,' . base64_encode($qrImage);

            $pdf = Pdf::loadView('pdf.access_request', [
                'request' => $accessRequest,
                'qrCode'  => $qrBase64
            ]);

            $pdf->setOption(['isRemoteEnabled' => true]);

            $fileName = str_replace('/', '-', $ticketNumber) . '.pdf';
            $filePath = 'requests/' . $fileName;

            if (!Storage::disk('public')->exists('requests')) {
                Storage::disk('public')->makeDirectory('requests');
            }
            Storage::disk('public')->put($filePath, $pdf->output());

            $accessRequest->update(['pdf_path' => $filePath]);

            return redirect()->route('internal.requests.index')
                ->with('success', "Request submitted! Ticket #{$ticketNumber} has been generated.");
        });

        return redirect()->route('internal.requests.index')->with('success', 'Internal request submitted successfully!');
    }
}
