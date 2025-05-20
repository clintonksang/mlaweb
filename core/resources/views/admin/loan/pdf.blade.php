<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $pageTitle }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-running {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        .status-pending {
            background-color: #fff3e0;
            color: #f57c00;
        }
        .status-paid {
            background-color: #e8f5e9;
            color: #388e3c;
        }
        .status-rejected {
            background-color: #ffebee;
            color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $pageTitle }}</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Loan Number</th>
                <th>User</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Next Installment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>{{ $loan->loan_number }}</td>
                <td>{{ $loan->user->username }}</td>
                <td>{{ $loan->plan->name }}</td>
                <td>{{ number_format($loan->amount, 2) }}</td>
                <td>
                    <span class="status status-{{ strtolower($loan->status) }}">
                        {{ ucfirst($loan->status) }}
                    </span>
                </td>
                <td>{{ $loan->created_at->format('Y-m-d H:i:s') }}</td>
                <td>
                    @if($loan->nextInstallment)
                        {{ $loan->nextInstallment->installment_date->format('Y-m-d') }}
                        ({{ number_format($loan->nextInstallment->amount, 2) }})
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 