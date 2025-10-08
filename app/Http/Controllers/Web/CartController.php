<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use SEO;

class CartController extends Controller
{
    public function __construct()
    {
        $this->cartUpdate();
    }

    public function cart()
    {
        $title = 'سبد خرید';
        $user = auth()->check() ? User::with('photo')->find(auth()->id()) : null;
        $address = $user ? Address::with('city')->where('user_id', $user->id)->latest()->first() : null;
        $helper = Helper::arrayGetAll();
        $cart = $helper['cart'] ?? null;
        $cart_products = $cart ? CartProduct::where('cart_id', $cart->id)->get() : [];

        return view('web.carts.index', compact('user', 'address', 'helper', 'title', 'cart_products'));
    }

    public function addToCart(CartRequest $request)
    {
        return $this->updateCart($request, false);
    }

    public function quantityChange(CartRequest $request)
    {
        return $this->updateCart($request, true);
    }

    public function quantity(Request $request)
    {
        return $this->updateCart($request, true);
    }

    public function deleteFromCart($id)
    {
        $cart = $this->getCart();
        if (!$cart) {
            toast('سبد خرید شما یافت نشد','warning');
            return redirect()->route('carts.index');
        }

        $cart_product = CartProduct::where('cart_id', $cart->id)->where('product_id', $id)->first();
        if (!$cart_product) {
            toast('محصول مورد نظر یافت نشد','warning');
            return redirect()->route('carts.index');
        }

        $cart_product->delete();

        $cartProducts = CartProduct::where('cart_id', $cart->id)->get();
        if ($cartProducts->isEmpty()) {
            $cart->delete();
        } else {
            $cart->quantity = $cartProducts->sum('qty');
            $cart->sum_price = $cartProducts->sum('sum_price');
            $cart->save();
        }

        toast('محصول مورد نظر با موفقیت از سبد خرید حذف شد','warning');
        return redirect()->route('carts.index');
    }

    private function updateCart($request, $replaceQuantity = false)
    {
        $data = [
            'quantity' => $request->quantity,
            'product_id' => $request->id,
            'value_id' => $request->value_id
        ];

        $product = Product::findOrFail($data['product_id']);
        $cart = $this->getCart();

        // Begin transaction
        DB::beginTransaction();
        try {
            $cart_product = $cart
                ? CartProduct::where('cart_id', $cart->id)
                    ->where('product_id', $product->id)
                    ->first()
                : null;

            $existingQty = $cart_product ? $cart_product->qty : 0;
            $totalQty = $replaceQuantity ? $data['quantity'] : $existingQty + $data['quantity'];

            if ($totalQty > $product->quantity) {
                toast('تعداد درخواست شده بیشتر از موجودی محصول است','info');
                return redirect()->route('carts.index');
            }

            if (!$cart) {
                $cart = Cart::create([
                    'session_id' => $this->getSessionId(),
                    'quantity' => 0, // will update later
                    'sum_price' => 0,
                    'total_price' => 0
                ]);
            }

            if (!$cart_product) {
                $cart_product = new CartProduct();
                $cart_product->cart_id = $cart->id;
                $cart_product->product_id = $product->id;
            }

            // Handle options
            $options = $data['value_id'] ? [['value_id' => $data['value_id'], 'quantity' => $data['quantity']]] : null;
            if ($cart_product->option) {
                $existingOptions = json_decode($cart_product->option, true);
                if ($options) {
                    $found = false;
                    foreach ($existingOptions as &$item) {
                        if ($item['value_id'] == $options[0]['value_id']) {
                            $item['quantity'] = $replaceQuantity ? $options[0]['quantity'] : $item['quantity'] + $options[0]['quantity'];
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $existingOptions[] = $options[0];
                    }
                    $cart_product->option = json_encode($existingOptions);
                }
            } elseif ($options) {
                $cart_product->option = json_encode($options);
            }

            $cart_product->qty = $totalQty;
            $cart_product->price = $product->price;
            $cart_product->sum_price = $cart_product->price * $cart_product->qty;
            $cart_product->save();

            // Update cart totals
            $cartProducts = CartProduct::where('cart_id', $cart->id)->get();
            $cart->quantity = $cartProducts->sum('qty');
            $cart->sum_price = $cartProducts->sum('sum_price');
            $cart->total_price = $cart->sum_price;
            $cart->save();

            DB::commit(); // Commit transaction

            toast('محصول مورد نظر با موفقیت به سبد خرید اضافه شد.','success');
            return redirect()->route('carts.index');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction
            toast('خطایی رخ داده است. لطفا دوباره تلاش کنید','error');
            return redirect()->route('carts.index');
        }
    }

    private function getCart()
    {
        return Cart::with(['products','post','coupon'])
            ->where('session_id', $this->getSessionId())
            ->latest()
            ->first();
    }

    private function getSessionId()
    {
        if (!Session::has('User_Temp_Id')) {
            Session::put('User_Temp_Id', Str::uuid()->toString());
        }
        return Session::get('User_Temp_Id');
    }

    public function cartUpdate()
    {
        $cart = $this->getCart();
        if (!$cart) return true;

        $discount = $cart->sum_price;

        if ($cart->coupon_id) {
            $discount -= $cart->sum_price * ($cart->coupon->discount / 100);
        }

        if ($cart->post_id && !$cart->post->payment_state) {
            $discount += intval($cart->post->price);
        }

        $cart->total_price = $discount;
        $cart->amount = $cart->sum_price;
        $cart->save();
    }
}
