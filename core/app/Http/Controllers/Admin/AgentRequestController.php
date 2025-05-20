<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgentRequest;
use App\Models\AgentRequestType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PDF;

class AgentRequestController extends Controller
{
    // List and filter agent requests
    public function index(Request $request)
    {
        $query = AgentRequest::with(['type', 'agent']);
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->type_id) {
            $query->where('type_id', $request->type_id);
        }
        $requests = $query->latest()->paginate(20);
        $types = AgentRequestType::all();
        $pageTitle = 'Agent Requests';
        return view('admin.agent_requests.index', compact('requests', 'types', 'pageTitle'));
    }

    // Approve a request
    public function approve($id)
    {
        $request = AgentRequest::findOrFail($id);
        $request->status = 'approved';
        $request->admin_id = Auth::id();
        $request->save();
        return back()->with('success', 'Request approved.');
    }

    // Reject a request
    public function reject($id)
    {
        $request = AgentRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->admin_id = Auth::id();
        $request->save();
        return back()->with('success', 'Request rejected.');
    }

    // Export requests to PDF
    public function exportPdf(Request $request)
    {
        $query = AgentRequest::with(['type', 'agent']);
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->type_id) {
            $query->where('type_id', $request->type_id);
        }
        $requests = $query->latest()->get();
        $pdf = PDF::loadView('admin.agent_requests.pdf', compact('requests'));
        return $pdf->download('agent_requests.pdf');
    }

    // Store a new agent request (API)
    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:agent_request_types,id',
            'amount' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $agentRequest = new AgentRequest();
        $agentRequest->type_id = $request->type_id;
        $agentRequest->amount = $request->amount;
        $agentRequest->description = $request->description;
        $agentRequest->user_id = Auth::id();
        $agentRequest->status = 'pending';
        $agentRequest->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Agent request submitted successfully.',
            'data' => $agentRequest
        ]);
    }
} 