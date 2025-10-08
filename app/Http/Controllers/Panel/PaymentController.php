<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('payment-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = 'پرداختی ها';
        $payments = Payment::query();
        if ($keyword = request('search')) {
            $payments=$payments->with('user')
                ->where('RefID',  $keyword);
        }
        $payments = $payments->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.payment.index', compact(['payments', 'user', 'setting','title']));
    }

    public function show(Payment $payment)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('payment-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title ='جزیات پرداختی ها';
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.payment.show', compact(['user', 'title', 'payment', 'setting']));
    }
}
