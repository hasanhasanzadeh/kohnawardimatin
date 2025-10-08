@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
@endsection

@section('content')
    @php
        $setting=$helper['setting'];
        $steps=$helper['steps'];
        $brands_show=$helper['brands_show'];
        $products=$helper['products'];
        $specials=$helper['specials'];
        $product_cats=$helper['product_cats'];
        $banner=$helper['banner'];
        $banners=$helper['banners'];
        $sliders=$helper['sliders'];
        $page_cats=$helper['page_cats'];
        $articles_show=$helper['articles_show'];
        $cart=$helper['cart'];
        $bases=$helper['bases'];
        $categories=$helper['categories']; $coupon=$helper['coupon']; $coupon=$helper['coupon'];
    @endphp
    <main class="wrapper shopping-page default">
        <div class="container" id="apps">
            <div class="row">
                <div class="account-box checkout-page col-xl-9 col-lg-8 col-md-12">
                    <div class="cart-page-title text-center" >
                        <h1>ویرایش آدرس</h1>
                    </div>
                    <div class="account-box-content">
                        <form action="{{route('addresses.update',$address->id)}}" method="POST">
                        @csrf
                        {{method_field('PATCH')}}
                        <div class="form-account-title"> نام و نام خانوادگی گیرنده </div>
                        <div class="form-account-row">
                            <input type="text" name="receptor_name" value="{{$address->receptor_name}}" class="input-field text-right" placeholder="نام و نام خانوادگی گیرنده را وارد کنید">
                        </div>
                        <div class="form-account-title"> شماره تماس گیرنده </div>
                        <div class="form-account-row">
                            <input type="tel" maxlength="11" name="receptor_mobile" value="{{$address->receptor_mobile}}" class="input-field text-right" placeholder="شماره تماس گیرنده را وارد کنید">
                        </div>
                        <div class="form-account-title"> آدرس  </div>
                        <div class="form-account-row">
                            <textarea  name="address" class="input-field text-right" placeholder="آدرس گیرنده را وارد کنید">{{$address->address_text}}</textarea>
                        </div>
                        <div class="form-account-title">شهر خود را انتخاب کنید</div>
                        <div class="form-account-row">
                            <select name="city_id" id="city_select" class="input-field text-right w-100">
                                <option value="{{$address->city_id}}">{{'استان : '.$address->city->province->name.' - شهرستان : '.$address->city->name}}</option>
                            </select>
                        </div>
                        <div class="form-account-title"> کد پستی  </div>
                        <div class="form-account-row">
                            <input  name="post_code" maxlength="10" type="text" value="{{$address->post_code}}" class="input-field text-right" placeholder="کد پستی گیرنده را وارد کنید">
                        </div>
                        <button type="submit" class="btn btn-danger">ثبت اطلاعات</button>
                        <a href="{{route('checkouts.index')}}" type="button" class="btn btn-secondary" >انصراف</a>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="{{asset('/js/select2.min.js')}}"></script>
    <script  type="text/javascript">
        $('#city_select').select2({
            placeholder: 'نام شهر را انتخاب کنید',
            ajax: {
                url: "{{route('cities.search.all')}}",
                dataType: 'json',
                delay: 220,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (data) {
                            return {
                                text: 'استان : '+data.province_name+' - شهرستان : '+data.city_name,
                                id: data.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
