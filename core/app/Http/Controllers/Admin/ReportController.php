<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction(Request $request,$userId = null)
    {
        $pageTitle = 'Transaction Logs';

        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::searchable(['trx','user:username'])->filter(['trx_type','remark'])->dateFilter()->orderBy('id','desc')->with('user');
        if ($userId) {
            $transactions = $transactions->where('user_id',$userId);
        }
        $transactions = $transactions->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'transactions','remarks'));
    }

    public function loginHistory(Request $request)
    {
        $pageTitle = 'User Login History';
        $loginLogs = UserLogin::orderBy('id','desc')->searchable(['user:username'])->dateFilter()->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip',$ip)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs','ip'));
    }

    public function notificationHistory(Request $request){
        $pageTitle = 'Notification History';
        $logs = NotificationLog::orderBy('id','desc')->searchable(['user:username'])->dateFilter()->with('user')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle','logs'));
    }

    public function emailDetails($id){
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle','email'));
    }

    public function exportTransactionPdf(Request $request, $userId = null)
    {
        $pageTitle = 'Transaction Logs Report';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::searchable(['trx','user:username'])->filter(['trx_type','remark'])->dateFilter()->orderBy('id','desc')->with('user');
        if ($userId) {
            $transactions = $transactions->where('user_id',$userId);
        }
        $transactions = $transactions->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.transactions_pdf', compact('pageTitle', 'transactions', 'remarks'));
        return $pdf->download('transaction-logs-report.pdf');
    }

    public function exportLoginHistoryPdf(Request $request)
    {
        $pageTitle = 'User Login History Report';
        $loginLogs = \App\Models\UserLogin::orderBy('id','desc')->searchable(['user:username'])->dateFilter()->with('user')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.logins_pdf', compact('pageTitle', 'loginLogs'));
        return $pdf->download('user-login-history-report.pdf');
    }

    public function exportNotificationHistoryPdf(Request $request)
    {
        $pageTitle = 'Notification History Report';
        $logs = \App\Models\NotificationLog::orderBy('id','desc')->searchable(['user:username'])->dateFilter()->with('user')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.notification_history_pdf', compact('pageTitle', 'logs'));
        return $pdf->download('notification-history-report.pdf');
    }
}
