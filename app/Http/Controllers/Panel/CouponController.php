<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Models\Coupon;
use App\Models\Setting;
use App\Models\User;

class CouponController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('coupon-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.coupons');
        $coupons = Coupon::query();
        if ($keyword = request('search')) {
            $coupons->where('title', 'LIKE', "%{$keyword}%");
        }
        $coupons = $coupons->with(['photo'])->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.coupon.index', compact(['coupons', 'user', 'title', 'setting']));
    }


    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('coupon-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.coupon.create', compact(['user', 'title', 'setting']));
    }

    public function store(CouponRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('coupon-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $coupon = new Coupon();
        $coupon->title = $request->title;
        $coupon->slug = Helper::makeSlug($request->slug);
        $coupon->description = $request->description;
        $coupon->code=Helper::makeSlug($request->code);
        $coupon->discount=$request->discount;
        $coupon->expired_at=$request->expired_at;
        $coupon->status = $request->status;
        $coupon->user_id = auth()->user()->id;
        $coupon->save();
        if ($request->file('image')){
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $coupon->photo()->create(['path'=>$path]);
        }
        $coupon->meta()->create([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);
        toast(__('dashboard.created'), 'success');
        return redirect()->route('coupons.index');
    }


    public function show(Coupon $coupon)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('coupon-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.coupon.show', compact(['user', 'title', 'coupon', 'setting']));
    }


    public function edit(Coupon $coupon)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('coupon-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.coupon.edit', compact(['user', 'title', 'coupon', 'setting']));
    }


    public function update(CouponUpdateRequest $request, Coupon $coupon)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('coupon-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $coupon->title = $request->title;
        $coupon->slug = Helper::makeSlug($request->slug);
        $coupon->description = $request->description;
        $coupon->code=Helper::makeSlug($request->code);
        $coupon->discount=$request->discount;
        $coupon->expired_at=$request->expired_at;
        $coupon->status = $request->status;
        $coupon->save();
        if ($request->file('image')){
            $coupon->photo()->delete();
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $coupon->photo()->create(['path'=>$path]);
        }
        $coupon->meta()->find($coupon->meta->id)->update([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);
        toast(__('dashboard.updated'), 'success');
        return redirect()->route('coupons.index');
    }

    public function destroy(Coupon $coupon)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('coupon-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $coupon->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

}
