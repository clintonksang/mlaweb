<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Country;
use Illuminate\Http\Request;

class RegionController extends Controller {

    public function store(Request $request, $id = 0) {
        $request->validate([
            'name' => 'required|string|unique:regions,name,' . $id,
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($id) {
            $region = Region::findOrFail($id);
            $notification = 'Region updated successfully';
        } else {
            $region = new Region();
            $notification = 'Region added successfully';
        }

        $region->name = $request->name;
        $region->country_id = $request->country_id;
        $region->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function status($id) {
        return Region::changeStatus($id);
    }

    public function fetchRegions(Request $request)
    {
        $regions = Region::where('country_id', $request->country_id)->get(['id', 'name']);
        return response()->json($regions);
    }
}
