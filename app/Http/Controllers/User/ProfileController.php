<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;

class ProfileController extends Controller
{


    public function index()
    {
        $title=__('front.profile');
        $helper=Helper::arrayGetAll();
        $user=auth()->check()?User::findOrFail(auth()->user()->id):null;
        $product_likes = Product::with('likes')->whereHas('likes',function ($query)use($user){
            $query->where('user_id',$user->id)->where('likeable_type','App\Models\Product');
        })->latest()->take(10)->get();
        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->take(7)
            ->get();
        SEOMeta::setTitle($helper['setting']->title);
        SEOMeta::setDescription($helper['setting']->meta_id?$helper['setting']->meta->meta_description:null);
        SEOMeta::setKeywords(explode(' ',$helper['setting']->meta_id?$helper['setting']->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.profiles.index',compact(['helper','title','product_likes','orders','user']));
    }

    public function edit()
    {
        $title=__('front.profile');
        $helper=Helper::arrayGetAll();
        $user=auth()->check()?User::findOrFail(auth()->user()->id):null;
        SEOMeta::setTitle($helper['setting']->title);
        SEOMeta::setDescription($helper['setting']->meta_id?$helper['setting']->meta->meta_description:null);
        SEOMeta::setKeywords(explode(' ',$helper['setting']->meta_id?$helper['setting']->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.profiles.edit',compact(['title','helper','user']));
    }

    public function update(ProfileRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        $user->full_name=$request->full_name;
        $user->mobile=$request->mobile;
        $user->email=$request->email;
        $user->gender=$request->gender;
        $user->birthday=$request->birthday;
        $user->national_code=$request->national_code;
        $user->news_letter=$request->news_letter;
        $user->card_number=$request->card_number;
        $user->save();
        if ($request->file('image')){
            $user->photo?$user->photo()->delete():null;
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $user->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.updated'),'success');
        return redirect()->route('profiles.index');
    }

    public function show()
    {
        $title = ' پروفایل من ';
        $user = User::findOrFail(auth()->user()->id);
        $helper = Helper::arrayGetAll();
        return view('web.profiles.show', compact(['title', 'user', 'helper']));
    }
}
