<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;

class SliderController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('slider-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.sliders');
        $setting = Setting::with(['favicon','logo'])->first();
        $sliders = Slider::query();
        if($keyword = request('search')) {
            $sliders->with('category')->whereHas('category',function ($query)use($keyword){
                $query->where('name','like',"%{$keyword}%");
            });
        }
        $sliders=$sliders->with(['photo','category'])->sortable()->latest()->paginate(10);
        return view('panel.slider.index',compact(['sliders','user','title','setting']));
    }

    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('slider-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.slider.create',compact(['title','user','setting']));
    }

    public function store(SliderRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('slider-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $slider=new Slider();
        $slider->category_id=$request->category_id;
        $slider->status=$request->status;
        $slider->rang=$request->rang;
        $slider->url=$request->url;
        $slider->save();
        if ($request->file('image')){
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $slider->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.created'),);
        return redirect()->route('sliders.index');

    }

    public function show(Slider $slider)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('slider-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.slider.show',compact(['slider','user','title','setting']));
    }

    public function edit(Slider $slider)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('slider-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.slider.edit',compact(['slider','user','title','setting']));
    }


    public function update(SliderUpdateRequest $request, Slider $slider)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('slider-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $slider->category_id=$request->category_id;
        $slider->status=$request->status;
        $slider->rang=$request->rang;
        $slider->url=$request->url;
        $slider->save();
        if ($request->file('image')){
            $slider->photo?$slider->photo()->delete():null;
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $slider->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.updated'),'success');
        return redirect()->route('sliders.index');
    }

    public function destroy(Slider $slider)
    {
        $user=User::with('photo')
            ->findOrFail(auth()->user()->id);
        if (! $user->can('slider-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $slider->delete();
        toast(__('dashboard.deleted'),'success');
        return redirect()->route('sliders.index');

    }
}
