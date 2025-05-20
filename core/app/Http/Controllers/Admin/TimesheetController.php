<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TimesheetController extends Controller
{
    public function index()
    {
        $pageTitle = 'Timesheet Management';
        $timesheets = Timesheet::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('admin.timesheets.index', compact('timesheets', 'pageTitle'));
    }

    public function exportPdf()
    {
        $pageTitle = 'Timesheet Report';
        $timesheets = Timesheet::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.timesheets.pdf', compact('timesheets', 'pageTitle'));
        return $pdf->download('timesheet-report.pdf');
    }
} 