<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\City;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SEO;

class CheckoutController extends Controller
{
    protected $cartController;

    public function __construct(CartController $cartController)
    {
        $this->cartController = $cartController;
    }

    public function index()
    {
        $title = 'ثبت سفارش';
        $user = User::findOrFail(auth()->user()->id);
        $address = Address::with('city')
            ->where('user_id', $user->id)
            ->latest()
            ->first();
        $helper = Helper::arrayGetAll();
        $cart = $helper['cart'];
        if (!$cart) {
            toast('سبد خرید شما خالی می باشد.', 'warning');
            return redirect('/');
        }
        $cart = $cart->with('products')->latest()->first();
        $discount = $cart->sum_price;
        if ($cart->coupon_id) {
            $discount = $cart->sum_price - ($cart->sum_price * ($cart->coupon->discount / 100));
        }

        if ($cart->post_id && !$cart->post->payment_state) {
            $cart->total_price = $discount+ $cart->post['price'];
            $cart->amount = $cart->sum_price;
            $cart->save();
        } else {
            $cart->total_price = $discount;
            $cart->amount = $cart->sum_price;
            $cart->save();
        }
        foreach ($cart->products as $product) {
            if ($product->quantity <= 0) {
                $this->cartController->deleteFromCart($product->id);
                toast('موجودی محصول شما به اتمام رسیده است سبد خرید شما بروز رسانی شد', 'warning');
                return redirect('/cart');
            }
        }
        return view('web.checkouts.index',
            compact(['user', 'address', 'title', 'helper']));
    }

    public function payment()
    {
        $title = 'نحوه پرداخت';
        $user = User::findOrFail(auth()->user()->id);
        $address = Address::with('city')
            ->where('user_id', $user->id)
            ->latest()
            ->first();
        $cart = Cart::with('products')->where('session_id', Session::get('User_Temp_Id'))->firstOrFail();
        foreach ($cart->products as $product) {
            if ($product->quantity <= 0) {
                $this->cartController->deleteFromCart($product->id);
                toast('موجودی محصول شما به اتمام رسیده است سبد خرید شما بروز رسانی شد', 'warning');
                return redirect('/cart');
            }
        }
        if ($cart->post_id == null) {
            $post = Post::where('status', true)->where('price', '!=', '0')->first();
            if ($post) {
                $discount = $cart->sum_price;
                $post_price = 0 ;
                if ($cart->coupon_id) {
                    $discount = $cart->sum_price - ($cart->sum_price * ($cart->coupon->discount / 100));
                }
                if (!$post->payment_state){
                    $post_price=$post->price;
                }
                $cart->post_id = $post->id;
                $cart->post_price = $post->price;
                $cart->total_price = $post_price + $discount;
                $cart->amount = $cart->sum_price;
                $cart->save();
            }
        }
        if ($address) {
            $helper = Helper::arrayGetAll();
            $cart = $helper['cart'];
            if (!$cart) {
                toast('سبد خرید شما خالی می باشد.', 'warning');
                return redirect('/');
            } else {
//                toast('بعد از پرداخت لطفا کمی صبوری بفرمایید تا خودکار به فروشگاه بازگردد و سفارش شما تایید شود.','warning');
                return view('web.checkouts.payment',
                    compact(['user', 'address', 'title', 'helper']));
            }
        } else {
            toast('آدرس شما خالی می باشد.', 'info');
            return redirect('/checkouts');
        }

    }

    public function citySearch(Request $request)
    {
        $cities = [];
        if ($request->has('q')) {
            $search = $request->q;
            $cities = City::join('provinces', 'cities.province_id', '=', 'provinces.id')
                ->select('cities.id', 'cities.name as city_name', 'provinces.name as province_name')
                ->where('cities.name', 'LIKE', "%$search%")
                ->orWhere('provinces.name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($cities);
    }

    public function postSelect(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $cart = Cart::with('products')->where('session_id', Session::get('User_Temp_Id'))->latest()->first() ?? null;
        $post = Post::where('status', true)->findOrFail($request->post_id);
        $post_price = $post->payment_state ? 0 : $post->price;
        if ($cart) {
            $discount = $cart->sum_price;
            if ($cart->coupon_id) {
                $discount = $cart->sum_price - ($cart->sum_price * ($cart->coupon->discount / 100));
            }
            $cart->post_id = $post->id;
            $cart->post_price = $post->price;
            $cart->total_price = $discount + $post_price;
            $cart->amount = $cart->sum_price;
            $cart->save();
        }
        return true;
    }
}
