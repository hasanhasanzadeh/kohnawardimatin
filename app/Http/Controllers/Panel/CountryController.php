<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use App\Models\Province;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class CountryController extends Controller
{



    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('country-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.countries');
        $countries= Country::query();
        if ($keyword = request('search')) {
            $countries->where('country_name', 'LIKE', "%{$keyword}%");
        }
        $countries = $countries->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.country.index', compact(['countries', 'user', 'setting','title']));
    }


    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('country-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.country.create', compact(['user', 'title', 'setting']));
    }

    public function store(CountryRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('country-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $country = new Country();
        $country->country_name = $request->country_name;
        $country->language_id = $request->language_id;
        $country->save();
        toast(__('dashboard.created'), 'success');
        return redirect()->route('countries.index');
    }


    public function show(Country $country)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('country-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.country.show', compact(['user', 'title', 'country', 'setting']));
    }


    public function edit(Country $country)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('country-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.country.edit', compact(['user', 'title', 'country', 'setting']));
    }


    public function update(CountryRequest $request, Country $country)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('country-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $country->country_name = $request->country_name;
        $country->language_id = $request->language_id;
        $country->save();
        toast(__('dashboard.updated'), 'success');
        return redirect()->route('countries.index');
    }

    public function destroy(Country $country)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('country-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $province=Province::where('country_id',$country->id)->first();
        if ($province){
            toast(__('dashboard.warning'), 'success');
            return redirect()->back();
        }
        $country->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $countries = [];
        if($request->has('q')){
            $search = $request->q;
            $countries = Country::select("id", "country_name")
                ->where('country_name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($countries);
    }
}
