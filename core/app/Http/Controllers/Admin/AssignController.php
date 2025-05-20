<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    public function assignPermissions(Request $request)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $pageTitle = 'Assign Permissions to Roles';

        $selectedRole = null;
        $selectedPermissions = [];
        if ($request->has('role_id')) {
            $selectedRole = Role::findOrFail($request->role_id);
            $selectedPermissions = $selectedRole->permissions->pluck('name')->toArray();
        }

        return view('admin.permissions.assign.permissions', compact('roles', 'permissions', 'pageTitle', 'selectedRole', 'selectedPermissions'));
    }

    public function storeAssignedPermissions(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('success', 'Permissions assigned to role successfully.');
    }
}
