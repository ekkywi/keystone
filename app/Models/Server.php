<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Server extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'ip_address',
        'user',
        'ssh_port',
        'private_key',
        'status'
    ];

    protected $casts = [
        'praivate_key' => 'encrypted',
        'specs' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
