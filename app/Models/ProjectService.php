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
        'public_port',
        'last_deployed_at'
    ];

    protected $casts = [
        'input_variables' => 'array',
        'public_port' => 'integer',
        'last_deployed_at' => 'datetime',
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
