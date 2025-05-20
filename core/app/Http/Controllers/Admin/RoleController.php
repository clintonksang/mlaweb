<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        $pageTitle = 'All Roles';
        return view('admin.permissions.index', compact('roles', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Create Role';
        return view('admin.permissions.roles.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        Role::create(['name' => $request->name]);
        return redirect()->route('admin.permissions.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $pageTitle = 'Edit Role - ' . $role->name;
        return view('admin.permissions.roles.edit', compact('role', 'pageTitle'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);
        $role->update(['name' => $request->name]);
        return redirect()->route('admin.permissions.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('admin.permissions.roles.index')->with('success', 'Role deleted successfully.');
    }
}
