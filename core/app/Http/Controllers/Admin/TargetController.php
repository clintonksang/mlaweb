<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Target;
use App\Models\User;

class TargetController extends Controller
{
    public function index($type = null)
    {
        $targets = Target::when($type, function ($query) use ($type) {
            return $query->where('type', $type);
        })->paginate(10);

        $pageTitle = 'Field Agent Targets';

        $agents = User::where('user_type', 'Agent')->where('status', Status::ENABLE)->get(); // Fetch active agents
        return view('admin.targets.index', compact('targets', 'agents', 'pageTitle'));
    }

    public function create()
    {
        $agents = User::where('user_type', 'Agent')->where('status', Status::ENABLE)->get(); // Fetch active agents
        return view('admin.targets.create', compact('agents'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // Validate user_id
            'type' => 'required|in:daily,monthly',
            'loans_processed' => 'required|integer',
            'new_users' => 'required|integer',
            'new_applications' => 'required|integer',
            'loan_amount_processed' => 'required|integer',
        ]);

        if ($id > 0) {
            // Update existing target
            $target = Target::findOrFail($id);
            $target->update($request->all());
            $message = 'Target updated successfully.';
        } else {
            // Create new target
            Target::create($request->all());
            $message = 'Target created successfully.';
        }

        return redirect()->route('admin.targets.index')->with('success', $message);
    }

    public function delete($id)
    {
        $target = Target::findOrFail($id);
        $target->delete();

        return redirect()->route('admin.targets.index')->with('success', 'Target deleted successfully.');
    }
}
