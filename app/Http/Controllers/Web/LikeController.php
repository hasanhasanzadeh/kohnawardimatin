<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
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
    public function destroy($id)
    {
        $user=User::findOrFail(auth()->user()->id);
        Like::where('likeable_id',$id)->where('likeable_type','App\Models\Product')->where('user_id',$user->id)->delete();
        toast('محصول مورد نظر با موفقیت از محصولات مورد علاقه تان حذف شد.','success');
        return back();
    }
}
