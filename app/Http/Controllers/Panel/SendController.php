<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendRequest;
use App\Models\Send;
use App\Models\Setting;
use App\Models\User;

class SendController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('send-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.orders_sms');
        $sends = Send::query();
        if ($keyword = request('search')) {
            $sends->with('user')
                ->whereHas('user',function ($query)use($keyword){
                $query->where('full_name','like',"%{$keyword}%")
                    ->orWhere('mail','like',"%{$keyword}%")
                    ->orWhere('mobile','like',"%{$keyword}%");
            });
        }
        $sends = $sends
            ->sortable()->latest()
            ->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.send.index', compact(['sends', 'user', 'title', 'setting']));
    }


    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('send-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.send.create', compact(['user', 'title', 'setting']));
    }

    public function store(SendRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('send-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $use_send=Send::where('user_id',$request->user_id)->first();
        if ($use_send){
            toast(__('dashboard.exists_customer'), 'error');
        }else{
            $send = new Send();
            $send->status = $request->status;
            $send->user_id = $request->user_id;
            $send->save();
            toast(__('dashboard.created'), 'success');
        }

        return redirect()->route('sends.index');
    }

    public function edit(Send $send)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('send-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $send->status=!$send->status;
        $send->save();
        return redirect()->back();
    }

    public function destroy(Send $send)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('send-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $send->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

}
