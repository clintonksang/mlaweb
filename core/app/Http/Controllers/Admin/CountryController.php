<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;

class CountryController extends Controller {

    public function index() {
        $pageTitle  = 'Countries and Regions';
        $countries = Country::searchable(['name', 'code'])->orderBy('id', 'desc')->paginate(getPaginate());
        $regions = Region::with('country')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.country.index', compact('pageTitle', 'countries', 'regions'));
    }

    public function store(Request $request, $id = 0) {
        $request->validate(
            [
                'name'  => 'required|string|unique:countries,name,' . $id,
                'code'  => 'required|string|unique:countries,code,' . $id,
            ]
        );
        
        if ($id) {
            $country     = Country::findOrFail($id);
            $notification = 'Country updated successfully';
        } else {
            $country     = new Country();
            $notification = 'Country added successfully';
        }
        $country->name = $request->name;
        $country->code = $request->code;
        $country->save();
        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function status($id) {
        return Country::changeStatus($id);
    }
}
