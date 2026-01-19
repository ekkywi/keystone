<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StackVariable extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'stack_id',
        'env_key',
        'label',
        'type',
        'default_value',
        'is_required'
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function stack()
    {
        return $this->belongsTo(Stack::class);
    }
}
