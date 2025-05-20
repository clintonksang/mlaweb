<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
    protected $fillable = ['name', 'code'];

    public function getStatusBadgeAttribute() {
        return $this->status
            ? '<span class="badge badge--success">Active</span>'
            : '<span class="badge badge--danger">Inactive</span>';
    }

    public static function changeStatus($id) {
        $country = self::findOrFail($id);
        $country->status = !$country->status;
        $country->save();
        return back()->withNotify([['success', 'Status changed successfully']]);
    }
}
