<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Reference to the user (agent)
        'type', // daily or monthly
        'loans_processed',
        'new_users',
        'new_applications',
        'loan_amount_processed',
    ];

    // Relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
