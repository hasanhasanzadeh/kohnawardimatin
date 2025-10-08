<?php

namespace App\Http\Controllers\Panel;

use App\Events\MsgPostSuccess;
use App\Http\Controllers\Controller;
use App\Http\Requests\SerialRequest;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;

class OrderController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('order-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.orders');
        $orders = Order::query();
        if ($keyword = request('search')) {
            $orders=$orders->with('user')
                ->whereHas('user',function ($query)use($keyword){
                $query->where('mobile','like',"%{$keyword}%")->orWhere('mail','like',"%{$keyword}%")
                    ->orWhere('full_name','like',"%{$keyword}%");
            });
        }
        $orders = $orders->with(['products','user','address','post'])->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.order.index', compact(['orders', 'user', 'setting','title']));
    }

    public function show($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('order-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        $order=Order::with(['products','address','user'])->findOrFail($id);
        return view('panel.order.show', compact(['user', 'title', 'order', 'setting']));
    }

    public function print($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('order-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        $order=Order::with(['products','address','user','post','coupon'])->findOrFail($id);
        return view('panel.order.print', compact(['user', 'title', 'order', 'setting']));
    }

    public function search()
    {
        $order_id=request('order_id');
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('order-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }

        $order=Order::with(['products','address','user'])->find($order_id);
        if (!$order){
            toast('سفارش مورد نظر یافت نشد','warning');
            return redirect()->back();
        }
        if ($order->status==0){
            return redirect(route('orders.show',$order_id));
        }
        return redirect(route('orders.edit',$order_id));
    }

    public function edit($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('order-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['logo','favicon'])->first();
        $order=Order::with(['products','address','user'])->where('status',1)->findOrFail($id);
        return view('panel.order.edit', compact(['user', 'title', 'order', 'setting']));
    }



    public function update(SerialRequest $request,$id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $order=Order::with(['payment'])->findOrFail($id);
        $order->serial=$request->serial;
        $order->status_send='send';
        $order->save();
        event(new MsgPostSuccess($order->user,$order->serial,$order->post->url));
        toast(__('dashboard.updated'), 'success');
        return redirect()->route('orders.index');
    }
}
