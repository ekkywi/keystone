<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Helper untuk label tipe request yang rapi
    public function getTypeLabelAttribute()
    {
        return match ($this->request_type) {
            'new_account' => 'New Account Creation',
            'reset_password' => 'Password Reset',
            'access_grant' => 'Additional Access Rights',
            default => 'Other Request',
        };
    }

    // Helper untuk warna badge status
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
            'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
            'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
        };
    }

    // Logika Auto Numbering (Format: REQ/YYYY/MM/0001)
    public static function generateTicketNumber()
    {
        $prefix = 'REQ/' . date('Y') . '/' . date('m') . '/';
        $lastRequest = self::where('ticket_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastRequest) {
            $number = '0001';
        } else {
            // Ambil 4 digit terakhir
            $lastNumber = substr($lastRequest->ticket_number, -4);
            $number = str_pad((int)$lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . $number;
    }

    // Relasi ke Admin yang memproses
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
