<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinceRequest;
use App\Models\Province;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('province-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.provinces');
        $provinces= Province::query();
        if ($keyword = request('search')) {
            $provinces->where('name', 'LIKE', "%{$keyword}%");
        }
        $provinces = $provinces->with('country')->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.province.index', compact(['provinces', 'user', 'title', 'setting']));
    }


    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('province-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.province.create', compact(['user', 'title', 'setting']));
    }

    public function store(ProvinceRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('province-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $province = new Province();
        $province->name = $request->province_name;
        $province->country_id = $request->country_id;
        $province->save();
        toast(__('dashboard.created'), 'success');
        return redirect()->route('provinces.index');
    }


    public function show(Province $province)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('province-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show').' '.__('dashboard.province');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.province.show', compact(['user', 'title', 'province', 'setting']));
    }


    public function edit(Province $province)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('province-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit').' '.__('dashboard.city');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.province.edit', compact(['user', 'title', 'province', 'setting']));
    }


    public function update(ProvinceRequest $request, Province $province)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('province-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $province->name = $request->province_name;
        $province->country_id = $request->country_id;
        $province->save();
        toast(__('dashboard.created'), 'success');
        return redirect()->route('provinces.index');
    }

    public function destroy(Province $province)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('province-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $province->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $provinces = [];
        if($request->has('q')){
            $search = $request->q;
            $provinces = Province::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($provinces);
    }
}
