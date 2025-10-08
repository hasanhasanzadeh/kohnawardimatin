<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class BrandController extends Controller
{



    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('brand-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.brands');
        $brands = Brand::query();
        if ($keyword = request('search')) {
            $brands->where('title', 'LIKE', "%{$keyword}%");
        }
        $brands = $brands->with(['photo'])->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.brand.index', compact(['brands', 'user', 'title', 'setting']));
    }


    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('brand-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.brand.create', compact(['user', 'title', 'setting']));
    }

    public function store(BrandRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('brand-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $brand = new Brand();
        $brand->title = $request->title;
        $brand->slug = Helper::makeSlug($request->slug);
        $brand->description = $request->description;
        $brand->brand_url=$request->brand_url;
        $brand->status = $request->status;
        $brand->save();
        if ($request->file('image')){
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $brand->photo()->create(['path'=>$path]);
        }
        $brand->meta()->create([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);
        toast(__('dashboard.created'), 'success');
        return redirect()->route('brands.index');
    }


    public function show(Brand $brand)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('brand-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.brand.show', compact(['user', 'title', 'brand', 'setting']));
    }


    public function edit(Brand $brand)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('brand-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.brand.edit', compact(['user', 'title', 'brand', 'setting']));
    }


    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('brand-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $brand->title = $request->title;
        $brand->slug = Helper::makeSlug($request->slug);
        $brand->description = $request->description;
        $brand->brand_url=$request->brand_url;
        $brand->status = $request->status;
        $brand->save();
        if ($request->file('image')){
            $brand->photo()->delete();
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $brand->photo()->create(['path'=>$path]);
        }
        $brand->meta()->find($brand->meta->id)->update([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);
        toast(__('dashboard.updated').' '.__('dashboard.success'), 'success');
        return redirect()->route('brands.index');
    }

    public function destroy(Brand $brand)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('brand-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $brand->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $brands = [];
        if($request->has('q')){
            $search = $request->q;
            $brands = Brand::select("id", "title")
                ->where('title', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($brands);
    }

}
