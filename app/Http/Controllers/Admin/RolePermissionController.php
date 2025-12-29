<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
      /**
     * Display a listing of roles.
     *
     * @return \Illuminate\View\View
     */
    public function roleIndex(Request $request)
    {
        try {
            $query = Role::query();

            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));

            $roles = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.roles-list', compact('roles'))->render(),
                ]);
            }
            return view('admin.role.index', compact('roles'));
        } catch (\Exception $e) {
            Log::error('Error in roleIndex: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching roles.');
        }
    }

    /**
     * Show the form for creating or updating a role.
     *
     * @param Role|null $role
     * @return \Illuminate\View\View
     */
    public function createOrUpdate(Role $role = null)
    {
        try {
            $permissions = Permission::all()->groupBy('group_name');
            $rolePermissions = $role ? $role->permissions->pluck('name')->toArray() : [];
            return view('admin.role.add', compact('role', 'permissions', 'rolePermissions'));
        } catch (\Exception $e) {
            Log::error('Error in createOrUpdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the role form.');
        }
    }

    /**
     * Store a newly created or updated role in storage.
     *
     * @param Request $request
     * @param Role|null $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRole(Request $request, Role $role = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);

        try {
            if (is_null($role)) {
                $role = Role::create(['name' => $request->name]);
            } else {
                $role->update(['name' => $request->name]);
                $role->permissions()->detach();
            }

            $role->syncPermissions($request->permissions);
            return redirect()->route('admin.role.index')->with('success', 'Role saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error in storeRole: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Role save failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified role from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        try {
            $role->permissions()->detach();
            $role->delete();
            return redirect()->route('admin.role.index')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Role deletion failed: ' . $e->getMessage());
        }
    }
}
