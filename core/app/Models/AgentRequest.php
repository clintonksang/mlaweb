<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id', 'type_id', 'amount', 'description', 'status', 'admin_id'
    ];

    public function type()
    {
        return $this->belongsTo(AgentRequestType::class, 'type_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
} 