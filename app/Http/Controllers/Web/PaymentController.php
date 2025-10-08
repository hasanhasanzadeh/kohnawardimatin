<?php

namespace App\Http\Controllers\Web;

use App\Events\MsgAdminSuccess;
use App\Events\MsgOrderSuccess;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\OrderProduct;
use App\Models\Post;
use App\Models\Send;
use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SEO;
use Shetabit\Multipay\Exceptions\InvoiceNotFoundException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as Pay;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class PaymentController extends Controller
{

    public function paymentGetWay(User $user,Order $order)
    {
        try {
            $description='شماره سفارش'.$order->id;
            $wallet=$user->wallet;
            $pay=$order->amount;
            $amount=$pay-$wallet;
            $invoice = (new Invoice)->amount($amount);

            $callbackUrl = route('payment.active', ['order_id' => $order->id]);

            return Pay::callbackUrl($callbackUrl)->purchase($invoice, function($driver, $transactionId) use ($amount,$wallet,$pay,$user,$order) {
                $payment = new Payment();
                $payment->authority=$transactionId;
                $payment->status='pending';
                $payment->amount=$amount;
                $payment->pay_wallet=$wallet;
                $payment->pay_get_way=$pay-$wallet;
                $payment->user_id=$user->id;
                $payment->paymentable_type="App\Models\Order";
                $payment->paymentable_id=$order->id;
                $payment->save();
            })->pay()->render();
        }catch (\Exception $exception){
            toast($exception->getMessage(),'errors');
            return back();
        }
    }

    public function verifyGetWay(Request $request)
    {
        $data = [
            'Authority'=>$request->Authority,
            'order_id'=>$request->order_id
        ];
        DB::beginTransaction();
        $payment = Payment::with(['paymentable'])->where('authority',$data['Authority'])->where('paymentable_id',$data['order_id'])->first();
        if (!$payment){
//            $payment->status='undone';
//            $payment->save();
            toast('درخواست توسط شما لغو شد','error');
            return redirect()->route('no.complete');
        }
        try {
            $amount=$payment->amount;
            $receipt = Pay::amount($amount)->transactionId($payment->authority)->verify();
            $payment->status='done';
            $payment->RefID=$receipt->getReferenceId();
            $payment->save();
            $user=User::findOrFail($payment->user_id);
            $user->wallet=0;
            $user->save();
            $order=Order::with(['user','products'])->find($payment->paymentable_id);
            $order->status=1;
            $order->save();
            foreach ($order->products as $product)
            {
                $pro=Product::findOrFail($product->id);
                if($pro->quantity){
                    $pro->quantity-=$product->pivot->qty;
                    $pro->save();
                }
            }
            event(new MsgOrderSuccess($payment->user,$payment->paymentable_id));
            $this->sendAdmin($payment);
            toast('خرید شما کامل شد','success');
            DB::commit();
            return redirect()->route('payment.complete');
        } catch (InvalidPaymentException $exception) {
            DB::rollBack();
            $payment->status='undone';
            $payment->save();
            toast('درخواست توسط شما لغو شد','error');
            return redirect()->route('no.complete');
        }

    }

    public function verify(){

        $cart = Cart::with(['products','post','coupon'])->where('session_id',Session::get('User_Temp_Id'))->firstOrFail();
        $cart_products=CartProduct::where('cart_id',$cart->id)->get();
        $productsId = [];
        if ($cart->post_id==null){
            $post=Post::where('status',true)->where('price','!=','0')->first();
            $post_price=$post->payment_state?0:$post->price;
            if ($post){

                $discount = $cart->sum_price;
                if ($cart->coupon_id) {
                    $discount = $cart->sum_price - ($cart->sum_price * ($cart->coupon->discount / 100));
                }
                if ($cart->post_id ){
                    $discount += intval($post_price);
                }
                $cart->post_id = $post->id; ;
                $cart->post_pirce = $post->price;
                $cart->total_price = $discount ;
                $cart->amount = $cart->sum_price;
                $cart->save();

            }
            else{
                $cart->total_price = $cart->sum_price;
                $cart->amount = $cart->sum_price;
                $cart->save();
            }
        }
        foreach ($cart->products as $product) {
            $productsId[$product->id] = ['qty' => $product->pivot->qty,'price'=>$product->pivot->price];
        }
        $userAuth=User::findOrFail(auth()->user()->id);
        $total=$cart->total_price;
        $address = Address::where('user_id', auth()->user()->id)->latest()->first();
        $order = new Order();
        $order->amount = $total;
        $order->address_id=$address->id;
        $order->user_id = $userAuth->id;
        $order->status = 0;
        $order->post_id = $cart->post_id;
        $order->post_price = $cart->post->price;
        $order->coupon_id = $cart->coupon_id;
        $order->save();
        foreach ($cart_products as $cart_product){
            OrderProduct::create([
                'order_id'=>$order->id,
                'product_id'=>$cart_product->product_id,
                'original_price'=>$cart_product->product->original_price,
                'price'=>$cart_product->product->price,
                'discount'=>$cart_product->product->discount,
                'qty'=>$cart_product->qty,
                'option'=>$cart_product->option,
            ]);
        }

        if ($userAuth->wallet >= $total){
            $newPayment = new Payment();
            $newPayment->amount =$total;
            $newPayment->user_id =$userAuth->id;
            $newPayment->authority = uniqid();
            $newPayment->status = 'done';
            $newPayment->RefID = uniqid();
            $newPayment->paymentable_type = 'App\Models\Order';
            $newPayment->paymentable_id = $order->id;
            $newPayment->save();
            $userAuth->wallet-=$total;
            $userAuth->save();
            $order->status=1;
            $order->save();
            // TODO : send Admin and User Notification and Email
            event(new MsgOrderSuccess($newPayment->user,$newPayment->paymentable_id));
            $this->sendAdmin($newPayment);
            $cart->delete();
            toast('پرداخت شما با موفقیت انجام شد.', 'success');
            return redirect()->route('payment.complete');
        }
//        $cart->delete();
        return $this->paymentGetWay($userAuth,$order);
    }

    public function sendAdmin($payment)
    {
        $sends=Send::with('user')->where('status',1)->get();
        foreach ($sends as $send)
        {
            event(new MsgAdminSuccess($send->user,$payment->user->full_name??$payment->user->mobile,$payment->paymentable_id,$payment->user->mobile??''));
        }
    }

    public function paymentComplete(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {

        $user=User::findOrFail(auth()->user()->id);
        $order=Order::where('user_id',auth()->user()->id)
            ->latest()
            ->first();
        $title='تایید پرداخت ';
        $address=Address::with('city')
            ->where('user_id',auth()->user()->id)
            ->latest()
            ->first();
        $helper=Helper::arrayGetAll();
        if ($order->status==1){
            $cart = Cart::with('products')->where('session_id',Session::get('User_Temp_Id'))->first()->delete();
            return view('web.checkouts.completed', compact(['user','address','helper','order','title']));
        }
        else{
            return view('web.checkouts.no-completed', compact(['user','address','helper','order','title']));
        }


    }

    public function paymentNoComplete()
    {
        $title='تایید پرداخت';
        $user=User::findOrFail(auth()->user()->id);
        $order=Order::where('user_id',auth()->user()->id)
            ->latest('created_at')
            ->first();
        $address=Address::with('city')
            ->where('user_id',auth()->user()->id)
            ->latest()
            ->first();
        $helper=Helper::arrayGetAll();
        if ($order->status==0){

            return view('web.checkouts.no-completed',
                compact(['user','address','order','title','helper']));
        }
        else{
            return view('web.checkouts.completed',
                compact(['user','address','order','title','helper']));
        }
    }
}
