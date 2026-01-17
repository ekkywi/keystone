<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectService extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'project_id',
        'stack_id',
        'server_id',
        'name',
        'input_variables',
        'status',
        'public_port'
    ];

    protected $casts = [
        'input_variables' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function stack()
    {
        return $this->belongsTo(Stack::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
