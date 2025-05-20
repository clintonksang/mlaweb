<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {
    protected $fillable = ['name', 'country_id'];

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function getStatusBadgeAttribute() {
        return $this->status
            ? '<span class="badge badge--success">Active</span>'
            : '<span class="badge badge--danger">Inactive</span>';
    }

    public static function changeStatus($id) {
        $region = self::findOrFail($id);
        $region->status = !$region->status;
        $region->save();
        return back()->withNotify([['success', 'Status changed successfully']]);
    }
}
