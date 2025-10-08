<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('role-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.roles');
        $setting = Setting::with(['favicon','logo'])->first();
        $roles = Role::query();
        if($keyword = request('search')) {
            $roles->where('name' , 'LIKE' , "%{$keyword}%");
        }
        $roles =$roles->whereNotIn('name', ['admin'])->sortable()->latest()->paginate(20);
        return view('panel.role.index', compact(['title','roles','user','setting']));
    }

    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('role-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.role.create',compact(['title','user','setting','user']));
    }

    public function store(RoleRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('role-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $role=new Role();
        $role->name=$request->name;
        $role->display_name=$request->display_name;
        $role->save();
        toast(__('dashboard.updated'),'success');
        return to_route('roles.index');
    }

    public function edit(Role $role)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('role-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $permissions = Permission::all();
        $setting = Setting::with(['favicon','logo'])->first();
        $title=__('dashboard.edit');
        return view('panel.role.edit', compact(['role','title', 'permissions','user','setting']));
    }

    public function show(Role $role)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('role-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $permissions = Permission::all();
        $setting = Setting::with(['favicon','logo'])->first();
        $title=__('dashboard.show');
        return view('panel.role.show', compact(['role','title', 'permissions','user','setting']));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('role-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $role->name=$request->name;
        $role->display_name=$request->display_name;
        $role->save();
        toast(__('dashboard.updated'),'success');
        return to_route('roles.index');
    }

    public function destroy(Role $role)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('role-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $role->delete();
        toast(__('dashboard.deleted'),'success');
        return back();
    }

    public function givePermission(Request $request, Role $role)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('permission-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $role->syncPermissions($request->permission);
        toast(__('dashboard.permissionAdded'), 'success');
        return back();
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('permission-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        if($role->hasPermissionTo($permission)){
            $role->revokePermissionTo($permission);
            toast(__('dashboard.permissionRevoked'), 'warning');
            return back();
        }
        toast(__('dashboard.permissionNotExists'), 'warning');
        return back();
    }
}
