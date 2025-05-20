<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AgentRequest;

class AgentRequestType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description'
    ];

    public function requests()
    {
        return $this->hasMany(AgentRequest::class, 'type_id');
    }
} 