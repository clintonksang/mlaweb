<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .date {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .status-1 { background: #e7f4e8; color: #1aa93f; }
        .status-2 { background: #fff4e6; color: #f39c12; }
        .status-3 { background: #ffe6e6; color: #dc3545; }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $pageTitle }}</h2>
    </div>
    
    <div class="date">
        Generated on: {{ now()->format('Y-m-d H:i:s') }}
    </div>

    @if(isset($summary))
    <div class="summary">
        <h4>Summary</h4>
        <p>Total Withdrawals: {{ $summary['total'] }}</p>
        <p>Total Amount: {{ showAmount($summary['amount']) }}</p>
        <p>Pending: {{ $summary['pending'] }}</p>
        <p>Approved: {{ $summary['successful'] }}</p>
        <p>Rejected: {{ $summary['rejected'] }}</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>TRX</th>
                <th>User</th>
                <th>Amount</th>
                <th>Charge</th>
                <th>After Charge</th>
                <th>Rate</th>
                <th>Payable</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($withdrawals as $withdraw)
                <tr>
                    <td>{{ showDateTime($withdraw->created_at) }}</td>
                    <td>{{ $withdraw->trx }}</td>
                    <td>{{ $withdraw->user->username }}</td>
                    <td>{{ showAmount($withdraw->amount) }}</td>
                    <td>{{ showAmount($withdraw->charge) }}</td>
                    <td>{{ showAmount($withdraw->after_charge) }}</td>
                    <td>{{ showAmount($withdraw->rate) }}</td>
                    <td>{{ showAmount($withdraw->final_amount) }}</td>
                    <td>
                        @php
                            $status = match($withdraw->status){
                                Status::PAYMENT_PENDING => ['class' => 'status-2', 'text' => 'Pending'],
                                Status::PAYMENT_SUCCESS => ['class' => 'status-1', 'text' => 'Approved'],
                                Status::PAYMENT_REJECT => ['class' => 'status-3', 'text' => 'Rejected'],
                                default => ['class' => '', 'text' => 'N/A']
                            };
                        @endphp
                        <span class="status {{ $status['class'] }}">{{ $status['text'] }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No withdrawals found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Page 1
    </div>
</body>
</html> 