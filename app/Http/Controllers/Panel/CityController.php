<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('city-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.city');
        $cities= City::query();
        if ($keyword = request('search')) {
            $cities->where('name', 'LIKE', "%{$keyword}%");
        }
        $cities = $cities->with(['province','province.country'])->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.city.index', compact(['cities', 'user', 'setting','title']));
    }


    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('city-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.city.create', compact(['user', 'title', 'setting']));
    }

    public function store(CityRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('city-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $city = new City();
        $city->name = $request->city_name;
        $city->province_id = $request->province_id;
        $city->save();
        toast(__('dashboard.created'), 'success');
        return redirect()->route('cities.index');
    }


    public function show(City $city)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('city-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.city.show', compact(['user', 'title', 'city', 'setting']));
    }


    public function edit(City $city)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('city-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.city.edit', compact(['user', 'title', 'city', 'setting']));
    }


    public function update(CityRequest $request, City $city)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('city-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $city->name = $request->city_name;
        $city->province_id = $request->province_id;
        $city->save();
        toast(__('dashboard.created'), 'success');
        return redirect()->route('cities.index');
    }

    public function destroy(City $city)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('city-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $city->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $cities = [];
        if($request->has('q')){
            $search = $request->q;
            $cities = City::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($cities);
    }
}
