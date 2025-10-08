<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('dashboard-show'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.dashboard');
        $setting = Setting::with(['favicon','logo'])->first();
        $customers=User::with(['photo','comments'])->latest()->take(8)->get();
        $products=Product::with(['photo','user'])->latest()->take(8)->get();
        $orders=Order::with(['user','products'])->where('status',1)->latest()->take(20)->get();
        return view('panel.admin.index',compact(['customers','products','user','setting','title','orders']));
    }

    public function makeSlug(Request $request)
    {
        $string=str_replace(['/',"\\",'%','#','!','@','$','^','&','*','(',')','_','=',"'",'"'],'',$request->title);
        return preg_replace('/\s+/u', '-', strtolower(trim($string)));
    }
}
