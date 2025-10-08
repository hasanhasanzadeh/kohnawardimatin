<?php

namespace App\Http\Controllers\Panel;

use App\Events\AddPermissionEvent;
use App\Http\Controllers\Controller;
use App\Http\Middleware\LangLocale;
use App\Http\Requests\PermissionRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('permission-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $permissions = Permission::query();
        if($keyword = request('search')) {
            $permissions->where('name' , 'LIKE' , "%{$keyword}%");
        }
        $permissions = $permissions->sortable()->latest()->paginate(20);
        $title=__('dashboard.permissions');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.permission.index', compact(['title','permissions','user','setting']));
    }

    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('permission-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.permission.create',compact(['setting','title','user']));
    }

    public function store(PermissionRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('permission-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $permission=new Permission();
        $permission->name=$request->name;
        $permission->display_name=$request->display_name;
        $permission->save();
        event(new AddPermissionEvent($permission));
        toast(__('dashboard.created'),'success');
        return to_route('permissions.index');
    }

    public function edit(Permission $permission)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('permission-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $roles = Role::all();
        $title=__('dashboard.edit');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.permission.edit', compact(['permission', 'roles','setting','title','user']));
    }

    public function show(Permission $permission)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('permission-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.show');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.permission.show', compact(['permission','setting','title','user']));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('permission-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $permission->name=$request->name;
        $permission->display_name=$request->display_name;
        $permission->save();
        toast(__('dashboard.updated'),'success');
        return to_route('permissions.index');
    }

    public function destroy(Permission $permission)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('permission-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $permission->delete();
        toast(__('dashboard.deleted'),'success');
        return back();
    }

    public function assignRole(Request $request, Permission $permission)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('role-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        if ($permission->hasRole($request->role)) {
            toast(__('dashboard.roleExists'), 'warning');
            return back();
        }

        $permission->assignRole($request->role);
        toast(__('dashboard.roleAssigned'), 'info');
        return back();
    }

    public function removeRole(Permission $permission, Role $role)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('role-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);
            toast(__('dashboard.roleRemoved'), 'success');
            return back();
        }
        toast(__('dashboard.roleNotExists'), 'warning');
        return back();
    }

    public function search(Request $request)
    {
        $permissions = [];
        if($request->has('q')){
            $search = $request->q;
            $permissions = Permission::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($permissions);
    }
}
