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
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
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
                <th>Date</th>
                <th>Start Day</th>
                <th>Start Location</th>
                <th>End Day</th>
                <th>End Location</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timesheets as $timesheet)
            <tr>
                <td>{{ $timesheet->date->format('Y-m-d') }}</td>
                <td>{{ $timesheet->check_in ? $timesheet->check_in->format('H:i:s') : '-' }}</td>
                <td>{{ $timesheet->check_in_location ?? '-' }}</td>
                <td>{{ $timesheet->check_out ? $timesheet->check_out->format('H:i:s') : '-' }}</td>
                <td>{{ $timesheet->check_out_location ?? '-' }}</td>
                <td>{{ $timesheet->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Page {{ $loop->iteration }} of {{ $loop->count }}</p>
    </div>
</body>
</html> 