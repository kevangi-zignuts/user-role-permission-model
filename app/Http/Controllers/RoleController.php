<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  public function index(Request $request)
  {
    $filter = $request->query('filter', 'all');
    $query = Role::query();

    if ($filter !== 'all') {
      $query->where('is_active', $request->filter)->get();
    }
    $roles = $query->get();

    $search = $request->input('search');
    if (!empty($search)) {
      $query->where('role_name', 'like', '%' . $search . '%');
      $roles = $query->get();
    }

    return view('roles.index', ['roles' => $roles, 'filter' => $filter]);
  }

  public function create()
  {
    $permissions = Permission::where('is_active', 1)->get();
    return view('roles.create', ['permissions' => $permissions]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'role_name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'permissions' => 'array',
    ]);
    $role = Role::create($request->only(['role_name', 'description']));

    $permissionIds = $request->input('permissions', []);

    $role->permission()->sync($permissionIds);

    return redirect()
      ->route('roles.index')
      ->with('success', 'Roles updated successfully!');
  }

  public function updateIsActive(Request $request, $id)
  {
    $role = Role::findOrFail($id);
    $role->update(['is_active' => !$role->is_active]);

    return redirect()
      ->route('roles.index')
      ->with('success', 'Role status updated successfully.');
  }
}
