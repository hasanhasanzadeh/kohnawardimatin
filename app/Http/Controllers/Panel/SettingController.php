<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Http\Requests\SettingUpdateRequest;
use App\Models\Setting;
use App\Models\User;

class SettingController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('setting-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.settings');
        $panels = Setting::query();
        if ($keyword = request('search')) {
            $panels->where('title', 'LIKE', "%{$keyword}%");
        }
        $panels = $panels->with(['favicon','logo'])->sortable()->latest()->paginate(10);
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.setting.index', compact(['panels', 'user', 'title', 'setting']));
    }

    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('setting-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.create');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.setting.create',compact(['title','user','setting']));
    }


    public function store(SettingRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('setting-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $settings=Setting::all();
        if ($settings->count() >= 1){
            toast(__('dashboard.create'),'warning');
            return redirect(route('settings.index'));
        }
        $setting=new Setting();
        $setting->title=$request->title;
        $setting->url=$request->url;
        $setting->product_text=$request->product_text;
        $setting->copy_right=$request->copy_right;
        $setting->free_post=$request->free_post;
        $setting->address=$request->address;
        $setting->about=$request->about;
        $setting->tel=$request->tel;
        $setting->text_chat=$request->text_chat;
        $setting->email=$request->email;
        $setting->logo_id=$request->file('logo')?Helper::uploadImage($request->file('logo')):null;
        $setting->favicon_id=$request->file('favicon')?Helper::uploadImage($request->file('favicon')):null;
        $setting->user_id=auth()->user()->id;
        $setting->save();
        $setting->meta()->create([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);

        $setting->media()->create([
            'telegram'=>$request->telegram,
            'instagram'=>$request->instagram,
            'youtube'=>$request->youtube,
            'whatsapp'=>$request->whatsapp,
            'x_link'=>$request->x_link,
            'linkedin'=>$request->linkedin,
            'facebook'=>$request->facebook,
            'google_plus'=>$request->google_plus,
        ]);

        toast(__('dashboard.created'), 'success');
        return redirect()->route('settings.index');
    }

    public function show($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('setting-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        $panel=Setting::findOrFail($id);
        return view('panel.setting.show',compact(['title','user','panel','setting']));
    }


    public function edit($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('setting-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.edit');
        $setting = Setting::with(['logo','favicon'])->first();
        $panel=Setting::findOrFail($id);
        return view('panel.setting.edit',compact(['title','user','panel','setting']));
    }

    public function update(SettingUpdateRequest $request, $id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('setting-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $setting=Setting::findOrFail($id);
        $setting->title=$request->title;
        $setting->url=$request->url;
        $setting->product_text=$request->product_text;
        $setting->copy_right=$request->copy_right;
        $setting->address=$request->address;
        $setting->free_post=$request->free_post;
        $setting->about=$request->about;
        $setting->tel=$request->tel;
        $setting->text_chat=$request->text_chat;
        $setting->email=$request->email;
        if ($request->logo){
            $setting->logo_id=Helper::uploadImage($request->file('logo'));
        }
        if ($request->favicon){
            $setting->favicon_id=Helper::uploadImage($request->file('favicon'));
        }
        $setting->user_id=auth()->user()->id;
        $setting->save();
        if ($setting->meta){
            $setting->meta()->find($setting->meta->id)->update([
                'meta_title'=>$request->meta_title,
                'meta_keywords'=>$request->meta_keywords,
                'meta_description'=>$request->meta_description
            ]);
        }else{
            $setting->meta()->create([
                'meta_title'=>$request->meta_title,
                'meta_keywords'=>$request->meta_keywords,
                'meta_description'=>$request->meta_description
            ]);
        }
        if ($setting->media) {
            $setting->media()->update([
                'telegram'=>$request->telegram,
                'instagram'=>$request->instagram,
                'youtube'=>$request->youtube,
                'whatsapp'=>$request->whatsapp,
                'x_link'=>$request->x_link,
                'linkedin'=>$request->linkedin,
                'facebook'=>$request->facebook,
                'google_plus'=>$request->google_plus,
            ]);
        }else {
            $setting->media()->create([
                'telegram' => $request->telegram,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
                'whatsapp' => $request->whatsapp,
                'x_link' => $request->x_link,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'google_plus' => $request->google_plus,
            ]);
        }
        toast(__('dashboard.updated'), 'success');
        return redirect()->route('settings.index');
    }


    public function destroy($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('setting-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $setting=Setting::all();
        if ($setting->count() <= 1){
            toast(__('dashboard.delete'),'warning');
            return redirect(route('settings.index'));
        }
        Setting::findOrFail($id)->delete();
        toast(__('dashboard.deleted'),'success');
        return redirect(route('settings.index'));
    }
}
