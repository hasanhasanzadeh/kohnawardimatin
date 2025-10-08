<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponAddRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function add(CouponAddRequest $request)
    {
        $coupon = Coupon::whereDate('expired_at', '>=', Carbon::now()->format('Y-m-d'))->where('status', true)->where('code', $request->code)->first();
        if (!$coupon) {
            toast('کد تخفیف مورد نظر منقضی شده است', 'error');
            return redirect()->back();
        }
        $helper = Helper::arrayGetAll();
        $cart = $helper['cart'];
        if (!$cart) {
            toast('سبد خرید شما خالی می باشد', 'error');
            return redirect()->back();
        }
        $orders = Order::where('coupon_id', $coupon->id)->where('status',1)->where('user_id', auth()->user()->id)->count();
        if ($orders) {
            toast('قبلا از کد تخفیف استفاده کرده اید', 'error');
            return redirect()->back();
        }
        $discount = $cart->sum_price - ($cart->sum_price * ($coupon->discount / 100));
        $cart->coupon_id = $coupon->id;
        $cart->amount = $cart->sum_price;
        $cart->total_price = $discount + $cart->post['price'];
        $cart->save();
        toast('کد تخفیف اعمال شد', 'success');
        return redirect()->back();
    }

    public function slug($slug)
    {
        $coupon = Coupon::whereDate('expired_at', '>=', Carbon::now()->format('Y-m-d'))->where('status', true)->where('slug', $slug)->firstOrFail();
        $helper = Helper::arrayGetAll();
        $title = $coupon->title;
        $user = auth()->check() ? User::findOrFail(auth()->user()->id) : null;
        SEOMeta::setTitle($coupon->title);
        SEOMeta::setDescription($coupon->meta ? $coupon->meta->meta_description : null);
        SEOMeta::setKeywords(explode('-', $coupon->meta ? $coupon->meta->meta_keywords : null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.coupon.show', compact(['helper', 'user', 'title', 'coupon']));
    }
}
