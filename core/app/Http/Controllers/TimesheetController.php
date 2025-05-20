<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimesheetController extends Controller
{
    public function index()
    {
        $timesheets = Timesheet::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('timesheets.index', compact('timesheets'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location' => 'required|string',
        ]);

        $today = now()->toDateString();

        $timesheet = Timesheet::firstOrNew([
            'user_id' => Auth::id(),
            'date' => $today,
        ]);

        if ($timesheet->check_in) {
            return back()->with('error', 'You have already checked in today.');
        }

        $timesheet->check_in = now();
        $timesheet->check_in_latitude = $request->latitude;
        $timesheet->check_in_longitude = $request->longitude;
        $timesheet->check_in_location = $request->location;
        $timesheet->save();

        return back()->with('success', 'Successfully checked in.');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location' => 'required|string',
        ]);

        $today = now()->toDateString();

        $timesheet = Timesheet::where('user_id', Auth::id())
            ->where('date', $today)
            ->first();

        if (!$timesheet) {
            return back()->with('error', 'You need to check in first.');
        }

        if ($timesheet->check_out) {
            return back()->with('error', 'You have already checked out today.');
        }

        $timesheet->check_out = now();
        $timesheet->check_out_latitude = $request->latitude;
        $timesheet->check_out_longitude = $request->longitude;
        $timesheet->check_out_location = $request->location;
        $timesheet->save();

        return back()->with('success', 'Successfully checked out.');
    }
} 