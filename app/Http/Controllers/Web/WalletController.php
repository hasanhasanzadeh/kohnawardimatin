<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use App\Models\Payment;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SEO;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as Pay;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class WalletController extends Controller
{


    public function wallet()
    {
        $title=__('front.profile');
        $helper=Helper::arrayGetAll();
        $user=User::findOrFail(auth()->user()->id);
        SEOMeta::setTitle($helper['setting']->title);
        SEOMeta::setDescription($helper['setting']->meta_id?$helper['setting']->meta->meta_description:null);
        SEOMeta::setKeywords(explode(' ',$helper['setting']->meta_id?$helper['setting']->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        $payments=Payment::where('user_id',$user->id)->where('paymentable_type','App\Models\Wallet')->latest()->paginate(10);
        return view('web.profiles.wallet',compact(['helper','title','user','payments']));
    }
    public function charge(WalletRequest $request)
    {
        $user=User::findOrFail(auth()->user()->id);
        $amount=$request->amount;
        $invoice = (new Invoice)->amount($amount);
        $callbackUrl = route('wallet.verify', ['order_id' => $user->id]);

        return Pay::callbackUrl($callbackUrl)->purchase($invoice, function($driver, $transactionId) use ($amount,$user) {
            $payment = new Payment();
            $payment->authority=$transactionId;
            $payment->status='pending';
            $payment->amount=$amount;
            $payment->pay_wallet='0';
            $payment->pay_get_way=$amount;
            $payment->user_id=$user->id;
            $payment->paymentable_type="App\\Models\\Wallet";
            $payment->save();
        })->pay()->render();
    }

    public function verify(Request $request){
        $data = [
            'Authority'=>$request->Authority,
            'order_id'=>$request->order_id
        ];
        $payment = Payment::where('authority',$data['Authority'])->where('user_id',$data['order_id'])->where('paymentable_type',"App\\Models\\Wallet")->firstOrFail();
        DB::beginTransaction();
      if (!$payment){
//            $payment->status='undone';
//            $payment->save();
            toast('درخواست توسط کاربر لغو شد','error');
            return redirect()->route('user.wallet');
        }
        try {
            $amount=$payment->amount;
            $receipt = Pay::amount($amount)->transactionId($data['Authority'])->verify();
            $payment->status='done';
            $payment->RefID=$receipt->getReferenceId();
            $payment->save();
            $user=User::findOrFail($payment->user_id);
            $user->wallet+=$payment->amount;
            $user->save();
            toast('کیف پول شما با موفقیت شارژ شد','success');
            DB::commit();
            return redirect()->route('user.wallet');
        } catch (InvalidPaymentException $exception) {
            DB::rollBack();
            $payment->status='undone';
            $payment->save();
            toast('درخواست توسط شما لغو شد','error');
            return redirect()->route('user.wallet');
        }

    }



}
