<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    public function show($id)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $title=__('dashboard.customers');
        $customer=User::with('photo')->findOrFail($id);
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        $setting=Setting::with(['favicon','logo'])->first();
        return view('panel.customer.role_user', compact(['user', 'roles', 'permissions','customer','setting','title']));
    }

    public function assignRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            toast(__('dashboard.roleExists'), 'warning');
            return back();
        }
        $user->assignRole($request->role);
        toast(__('dashboard.roleAssigned'), 'success');
        return back();
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            toast(__('dashboard.roleRemoved'), 'success');
            return back();
        }
        toast(__('dashboard.roleNotExists'), 'warning');
        return back();
    }

    public function givePermission(Request $request, User $user)
    {
        if ($user->hasPermissionTo($request->permission)) {
            toast(__('dashboard.permissionExists'), 'info');
            return back();
        }
        $user->givePermissionTo($request->permission);
        toast(__('dashboard.permissionAdded'), 'success');
        return back();
    }

    public function revokePermission(User $user, Permission $permission)
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            toast('dashboard.permissionRevoked', 'success');
            return back();
        }
        return back()->with(__('dashboard.permissionDoesNotExists'), 'warning');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            toast(__('dashboard.youAreAdmin'), 'info');
            return back();
        }
        $user->delete();
        toast(__('dashboard.deleted.'), 'success');
        return back();
    }
}
