<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\BaseUpdateRequest;
use App\Models\Base;
use App\Models\Setting;
use App\Models\User;

class BaseController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('base-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.bases');
        $bases = Base::query();
        if ($keyword = request('search')) {
            $bases->where('title', 'LIKE', "%{$keyword}%");
        }
        $bases = $bases->with('photo')->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.base.index', compact(['bases', 'user', 'title', 'setting']));
    }


    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('base-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.base.create', compact(['user', 'title', 'setting']));
    }

    public function store(BaseRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('base-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $base = new Base();
        $base->title = $request->title;
        $base->description = $request->description;
        $base->status = $request->status;
        $base->save();
        if ($request->file('image')){
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $base->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.created'), 'success');
        return redirect()->route('bases.index');
    }


    public function show($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('base-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        $base=Base::findOrFail($id);
        return view('panel.base.show', compact(['user', 'title', 'base', 'setting']));
    }


    public function edit($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('base-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['logo','favicon'])->first();
        $base=Base::with('photo')->findOrFail($id);
        return view('panel.base.edit', compact(['user', 'title', 'base', 'setting']));
    }


    public function update(BaseUpdateRequest $request, $id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('base-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $base=Base::findOrFail($id);
        $base->title = $request->title;
        $base->description = $request->description;
        $base->status = $request->status;
        $base->save();
        if ($request->file('image')){
            $base->photo()->delete();
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $base->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.updated'), 'success');
        return redirect()->route('bases.index');
    }

    public function destroy($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('base-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        Base::findOrFail($id)->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

}
