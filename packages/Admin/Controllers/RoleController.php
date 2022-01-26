<?php

namespace Packages\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function list(Request $request)
    {
        $roles = Role::query()
            ->where('name', 'like', '%' . $request->search . '%')
            ->get();

        return response()->json($roles);
    }

    public function index(Request $request)
    {
        $this->authorize('viewAll',Role::class);

        $roles = Role::query()
            ->withCount('users')
            ->with('permissions')
            ->where(function ($q) use ($request) {
                if ($search = $request->input('s', false)) {
                    $q->where('name', 'like', '%' . $search . '%');
                }
            })
            ->orderBy($request->orderBy, $request->order === 'descending' ? 'desc' : 'asc')
            ->paginate($request->count ?? 15);

        return response()->json($roles);
    }

    public function detachPermission(Role $role, Permission $permission)
    {
        $this->authorize('detachPermission',Role::class);

        return response()->json($role->revokePermissionTo($permission));
    }

    public function permissions()
    {
        return response()->json(Permission::all());
    }

    public function update(Role $role, Request $request)
    {
        $this->authorize('update',Role::class);

        $role->update($request->all());

        $role->syncPermissions($request->permissions);

        return response()->json($role->fresh()->load('permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('store',Role::class);

        /** @var Role $role */
        $role = Role::query()->create([
            'name'       => $request->name,
            'guard_name' => 'api',
        ]);

        $role->givePermissionTo($request->permissions);

        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        $this->authorize('destroy',Role::class);

        return response()->json($role->delete());
    }
}