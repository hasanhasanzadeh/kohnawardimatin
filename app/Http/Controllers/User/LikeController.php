<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Models\Alert;
use App\Models\Bale;
use App\Models\Category;
use App\Models\Like;
use App\Models\Page_Cat;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        $title = __('front.likes');

        $show_products = Product::with(['user','likes'])->whereHas('likes',function ($query)use($user){
            $query->where('user_id',$user->id)->where('likeable_type','App\Models\Product');
        })->latest()->paginate(20);
        $helper=Helper::arrayGetAll();
        SEOMeta::setTitle($helper['setting']->title);
        SEOMeta::setDescription($helper['setting']->meta_id?$helper['setting']->meta->meta_description:null);
        SEOMeta::setKeywords(explode(' ',$helper['setting']->meta_id?$helper['setting']->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.profiles.likes', compact(['show_products', 'user', 'title', 'helper','title']));
    }

    public function destroy($id)
    {
        $user=User::findOrFail(auth()->user()->id);
        Like::where('user_id',$user->id)->where('likeable_id',$id)->where('likeable_type','App\Models\Product')->delete();
        toast(__('front.unliked'),'success');
        return back();
    }

    public function store(Request $request,$id)
    {
        $product=Product::findOrFail($id);
        $user=User::findOrFail(auth()->user()->id);
        $like=Like::where('user_id',$user->id)->where('likeable_id',$id)->where('likeable_type','App\Models\Product')->first();
        if (!$like){
            $like=new Like();
            $like->likeable_id=$product->id;
            $like->likeable_type='App\Models\Product';
            $like->user_id=auth()->user()->id;
            $like->save();
            toast('محصول مورد علاقه افزوده شد.','success');
        }else{
            $like->delete();
            toast(__('front.unliked'),'success');
        }
        return back();
    }
}
