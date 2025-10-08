<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Setting;
use App\Models\User;

class ProfileController extends Controller
{


    public function show()
    {
        $user=User::with(['photo','city'])->findOrFail(auth()->user()->id);
        $title=__('dashboard.profile');
        $setting=Setting::with(['favicon','logo'])->first();
        return view('panel.profile.show',compact(['title','user','setting']));
    }

    public function edit()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        $title=__('dashboard.profile');
        $setting=Setting::with(['favicon','logo'])->first();
        return view('panel.profile.edit',compact(['title','user','setting']));
    }

    public function update(ProfileRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        $user->full_name=$request->full_name;
        $user->mobile=$request->mobile;
        $user->email=$request->email;
        $user->gender=$request->gender;
        $user->birthday=$request->birthday;
        $user->card_number=$request->card_number;
        $user->national_code=$request->national_code;
        $user->save();
        if ($request->file('image')){
            $user->photo?$user->photo()->delete():null;
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $user->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.updated'),'success');
        return redirect()->route('profile.show');
    }
}
