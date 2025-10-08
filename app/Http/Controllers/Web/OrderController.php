<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use SEO;


class OrderController extends Controller
{
    public function index()
    {
        if (auth()->check()){
            $title='سفارشات من';
            $user=User::with('photo')->findOrFail(auth()->user()->id);
            $orders=Order::with('products')
                ->where('user_id',auth()->user()->id)
                ->latest()
                ->paginate(10);
            $helper=Helper::arrayGetAll();
            return view('web.profiles.orders',
                compact(['helper','user','orders','title']));
        }else{
            toast('لطفا ابتدا وارد سایت شوید.','error');
            abort(403,"دسترسی به این قسمت ندارید.");
        }
    }

    public function show($id)
    {
        if (auth()->check()){
            $title='سفارش من';
            $user=User::with('photo')->findOrFail(auth()->user()->id);
            $helper=Helper::arrayGetAll();
            $order=Order::with(['products','address','post','payment'])
                ->where('user_id',auth()->user()->id)
                ->findOrFail($id);
            return view('web.profiles.order_list',
                compact(['helper','user','order','title']));
        }else{
            toast('لطفا ابتدا وارد سایت شوید.','error');
            abort(403,"دسترسی به این قسمت ندارید.");
        }
    }

    public function print($id)
    {
        if (auth()->check()){
            $title='سفارش من';
            $user=User::with('photo')->findOrFail(auth()->user()->id);
            $title = __('dashboard.show');
            $setting = Setting::with(['logo','favicon'])->first();
            $order=Order::with(['products','address','user','post','coupon'])->where('user_id',$user->id)->findOrFail($id);
            return view('panel.order.print', compact(['user', 'title', 'order', 'setting']));
        }else{
            toast('لطفا ابتدا وارد سایت شوید.','error');
            abort(403,"دسترسی به این قسمت ندارید.");
        }
    }
}
