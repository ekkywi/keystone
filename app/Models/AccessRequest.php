<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ticket_number',
        'name',
        'email',
        'department',
        'request_type',
        'reason',
        'status',
        'pdf_path',
        'processed_by',
        'approved_by',
        'admin_note'
    ];

    public function getTypeLabelAttribute()
    {
        return match ($this->request_type) {
            'new_account' => 'New Account Creation',
            'reset_password' => 'Password Reset',
            'access_grant' => 'Additional Access Rights',
            'other' => 'Other Inquiry',
            default => 'Other Request',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
            'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
            'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
            default => 'bg-slate-50 text-slate-700 border-slate-100',
        };
    }

    public static function generateTicketNumber()
    {
        $prefix = 'REQ/' . date('Y') . '/' . date('m') . '/';

        $lastRequest = self::where('ticket_number', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastRequest) {
            $number = '001';
        } else {
            $lastNumber = substr($lastRequest->ticket_number, -3);
            $number = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return $prefix . $number;
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
