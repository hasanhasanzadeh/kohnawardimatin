<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Models\Address;
use App\Models\City;
use App\Models\User;

class AddressController extends Controller
{
    public function store(AddressRequest $request)
    {
        $user=User::find(auth()->user()->id);
        $address_add=new Address();
        $address_add->receptor_name=$request->receptor_name;
        $address_add->receptor_mobile=$request->receptor_mobile;
        $address_add->city_id=$request->city_id;
        $address_add->user_id=auth()->user()->id;
        $address_add->post_code=$request->post_code;
        $address_add->address_text=$request->address;
        $address_add->save();
        if ($request->national_code){
            $user=User::findOrFail(auth()->user()->id);
            $user->full_name=$request->full_name;
            $user->national_code=$request->national_code;
            $user->save();
        }
        toast('آدرس مورد نظر با موفقیت افزوده شد.','success');
        return redirect(route('checkouts.index'));
    }
    public function update(AddressUpdateRequest $request,$id)
    {
        $user=User::find(auth()->user()->id);
        $address_add=Address::findOrFail($id);
        $address_add->receptor_name=$request->receptor_name;
        $address_add->receptor_mobile=$request->receptor_mobile;
        $address_add->city_id=$request->city_id;
        $address_add->user_id=auth()->user()->id;
        $address_add->post_code=$request->post_code;
        $address_add->address_text=$request->address;
        $address_add->save();
        toast('آدرس مورد نظر با موفقیت بروزرسانی شد.','success');
        return redirect(route('checkouts.index'));
    }

    public function createNew(AddressUpdateRequest $request)
    {
        $user=User::find(auth()->user()->id);
        $address_add=new Address();
        $address_add->receptor_name=$request->receptor_name;
        $address_add->receptor_mobile=$request->receptor_mobile;
        $address_add->city_id=$request->city_id;
        $address_add->user_id=auth()->user()->id;
        $address_add->post_code=$request->post_code;
        $address_add->address_text=$request->address;
        $address_add->save();
        toast('آدرس مورد نظر با موفقیت ثبت شد.','success');
        return redirect(route('checkouts.index'));
    }
    public function getAllCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->get();
        $response =[
            'cities' => $cities
        ];
        return response()->json($response, 200);
    }

    public function create()
    {
        if (!auth()->check()){
            toast('لطفا ابتدا وارد سایت شوید.','warning');
            return redirect()->route('login');
        }
        $title='ایجاد آدرس';
        $user=User::findOrFail(auth()->user()->id);
            $helper=Helper::arrayGetAll();
            $cart=$helper['cart'];
            if (!$cart){
                toast('سبد خرید شما خالی می باشد.','warning');
                return redirect('/');
            }
            $cart=$cart->with('products')->latest()->first();
            return view('web.address.create', compact(['helper','user','title']));
    }

    public function edit($id)
    {
        if (!auth()->check()){
            toast('لطفا ابتدا وارد سایت شوید.','warning');
            return redirect()->route('login');
        }
        $title='ویرایش آدرس';
            $user=User::findOrFail(auth()->user()->id);
            $helper=Helper::arrayGetAll();
            $address=Address::with('city')
                ->where('user_id',$user->id)
                ->findOrFail($id);
        $cart=$helper['cart'];
        if (!$cart){
            toast('سبد خرید شما خالی می باشد.','warning');
            return redirect('/');
        }
        $cart=$cart->with('products')->latest()->first();
        return view('web.address.edit', compact(['helper','user','address','title']));
    }

}
