<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prospect extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'primary_phone',
        'email_official',
        'email_personal',
        'id_passport',
        'kra_pin',
        'gender',
        'marital_status',
        'dob',
        'education',
        'postal_address',
        'bank_name',
        'bank_branch',
        'account_title',
        'account_number',
        'county',
        'district',
        'location',
        'sub_location',
        'building_name',
        'house_no',
        'residence_ownership',
        'residence_landmark',
        'nok_name',
        'nok_relationship',
        'nok_id',
        'nok_phone',
        'nok_address',
        'referee1_name',
        'referee1_phone',
        'referee1_relationship',
        'referee2_name',
        'referee2_phone',
        'referee2_relationship',
        'source',
        'applicant_signature',
        'terms_signature',
        'id_passport_file_path',
        'kra_pin_file_path',
        'kyc_status',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'kyc_status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'id', // Hide internal ID, use UUID instead
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($prospect) {
            if (empty($prospect->uuid)) {
                $prospect->uuid = (string) Str::uuid();
            }
        });
    }

    // Accessors for file URLs
    public function getIdPassportUrlAttribute()
    {
        return $this->id_passport_file_path 
            ? asset('storage/' . $this->id_passport_file_path) 
            : null;
    }

    public function getKraPinUrlAttribute()
    {
        return $this->kra_pin_file_path 
            ? asset('storage/' . $this->kra_pin_file_path) 
            : null;
    }

    // Scope for searching
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('primary_phone', 'like', "%{$search}%")
              ->orWhere('email_official', 'like', "%{$search}%")
              ->orWhere('id_passport', 'like', "%{$search}%");
        });
    }

    // Scope for filtering by status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for filtering by KYC status
    public function scopeKycStatus($query, $kycStatus)
    {
        return $query->where('kyc_status', $kycStatus === 'completed');
    }
}
