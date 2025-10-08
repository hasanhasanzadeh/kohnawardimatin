<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use SEO;

class ProfileController extends Controller
{

    public function index()
    {
            $title = ' پروفایل من ';
            $user = User::findOrFail(auth()->user()->id);
            $product_likes = Product::with('likes')->whereHas('likes',function ($query)use($user){
                    $query->where('user_id',$user->id)->where('likeable_type','App\Models\Product');
                })->latest()->paginate(10);
            $orders = Order::where('user_id', $user->id)
                ->latest()
                ->take(7)
                ->get();
            $helper=Helper::arrayGetAll();
            return view('web.profiles.index', compact(['title','helper', 'user', 'product_likes','orders']));
    }

    public function show()
    {
        $title = ' پروفایل من ';
        $user = User::findOrFail(auth()->user()->id);
        $helper = Helper::arrayGetAll();
        return view('web.profiles.show', compact(['title', 'user', 'helper']));
    }
}
