<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agent Requests Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .date { text-align: right; font-size: 11px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #f5f5f5; }
        .status-pending { color: #856404; }
        .status-approved { color: #155724; }
        .status-rejected { color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Agent Requests Report</h2>
    </div>
    <div class="date">
        Generated: {{ now()->format('Y-m-d H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Agent</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Status</th>
                <th>Requested At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->agent ? $req->agent->fullname : '-' }}</td>
                    <td>{{ $req->type ? $req->type->name : '-' }}</td>
                    <td>{{ number_format($req->amount, 2) }}</td>
                    <td>{{ $req->description }}</td>
                    <td class="status-{{ $req->status }}">{{ ucfirst($req->status) }}</td>
                    <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">No requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html> 