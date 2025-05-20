@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Agent Requests</h5>
                <a href="{{ route('admin.agent-requests.export.pdf', request()->all()) }}" class="btn btn-sm btn-primary">Export PDF</a>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <select name="type_id" class="form-control">
                            <option value="">All Types</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-outline-primary">Filter</button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Agent</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Requested At</th>
                                <th>Actioned By</th>
                                <th>Action</th>
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
                                    <td>
                                        <span class="badge bg-{{ $req->status == 'pending' ? 'warning' : ($req->status == 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($req->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($req->admin_id && $req->admin)
                                            {{ $req->admin->fullname ?? $req->admin->username ?? 'Admin' }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->status == 'pending')
                                            <form action="{{ route('admin.agent-requests.approve', $req->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn--success btn--sm">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.agent-requests.reject', $req->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn--danger btn--sm">Reject</button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $requests->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 