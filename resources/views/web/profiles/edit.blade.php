@extends('layouts.app')

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
        $categories=$helper['categories']; $coupon=$helper['coupon'];
    @endphp
    <!-- main -->
    <main class="profile-user-page ">
        <div class="container ">
            <div class="row">
                <div class="profile-page col-xl-9 col-lg-8 col-md-12 order-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-12">
                                <h1 class="title-tab-content">ویرایش اطلاعات شخصی</h1>
                            </div>
                            <div class="content-section default">
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="title-tab-content">حساب شخصی</h1>
                                    </div>
                                </div>
                                <form class="form-account" method="POST" action="{{route('profiles.update')}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{auth()->user()->id}}">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <label for="full_name" class="form-account-title">نام نام خانوادگی</label>
                                            <div class="form-account-row">
                                                <input class="input-field text-right" id="full_name" name="full_name" value="{{$user->full_name}}" type="text" placeholder="نام نام خانوادگی خود را وارد نمایید">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6">
                                            <label for="national_code" class="form-account-title">کد ملی</label>
                                            <div class="form-account-row">
                                                <input id="national_code" class="input-field" maxlength="10" name="national_code" value="{{$user->national_code}}" type="text" placeholder="کد ملی خود را وارد نمایید">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="mobile" class="form-account-title">شماره موبایل</label>
                                            <div class="form-account-row">
                                                <input class="input-field" id="mobile" maxlength="11"  name="mobile" value="{{$user->mobile}}" type="text" placeholder="شماره موبایل خود را وارد نمایید">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="card_number" class="form-account-title">شماره کارت</label>
                                            <div class="form-account-row">
                                                <input class="input-field" id="card_number" name="card_number" maxlength="16" type="text" value="{{$user->card_number}}" placeholder=" شماره کارت خود را وارد نمایید">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="email" class="form-account-title">آدرس ایمیل</label>
                                            <div class="form-account-row">
                                                <input class="input-field" name="email" id="email" value="{{$user->email}}" type="email" placeholder=" آدرس ایمیل خود را وارد نمایید">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="gender" class="form-account-title">جنسیت</label>
                                            <div class="form-account-row">
                                                <select name="gender" id="gender" class="input-field">
                                                    <option value="female" @if($user->gender=='female') selected @endif>زن</option>
                                                    <option value="male" @if($user->gender=='male') selected @endif>مرد</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="news_letter" class="form-account-title">اشتراک در خبرنامه</label>
                                            <div class="form-account-row">
                                                <select name="news_letter" id="news_letter" class="input-field">
                                                    <option value="1" @if($user->news_letter==1) selected @endif>بله</option>
                                                    <option value="0" @if($user->news_letter==0) selected @endif>خیر</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                                <label for="image" class="form-account-title">
                                                    {{__('dashboard.photo_select')}}
                                                </label>
                                                <input class="input-field" id="image" name="image" type="file" placeholder="{{__('dashboard.photo_select')}}">
                                                <div class="text-center mx-auto">
                                                    <img id="image-select" alt=""   src="@if($user->photo!=null) {{$user->photo->address}} @else {{asset('/default-images/avatar.png')}} @endif"  class="object-cover rounded-full my-4 mx-auto text-center" width="150" height="150">
                                                </div>
                                        </div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button class="btn btn-default btn-lg" type="submit">ذخیره</button>
                                        <a href="{{url('/user/profile')}}" class="btn btn-default btn-lg">انصراف</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-page-aside col-xl-3 col-lg-4 col-md-6 center-section order-1">
                    <div class="profile-box">
                        <div class="profile-box-header">
                            <div class="profile-box-avatar">
                                @if($user->photo)
                                    <img src="{{$user->photo->address}}" alt="" class="rounded-circle">
                                @else
                                    <img src="{{asset('assets/img/svg/user.svg')}}" alt="">
                                @endif
                            </div>
                            <button data-toggle="modal" data-target="#myModal" class="profile-box-btn-edit">
                                <i class="fa fa-pen"></i>
                            </button>
                            <!-- Modal Core -->
                            <div class="modal-share modal-width-custom modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">تغییر نمایه کاربری شما</h4>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="profile-avatars default text-center">
                                                @if($user->photo)
                                                    <li>
                                                        <img src="{{$user->photo->address}}" class="profile-avatars-item rounded-circle" height="100" alt="">
                                                    </li>
                                                @else
                                                    <li>
                                                        <img src="{{asset('assets/img/svg/user.svg')}}" class="profile-avatars-item rounded-circle" alt="">
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Core -->
                        </div>
                        <div class="profile-box-username">
                            {{$user->full_name}}
                            <hr>
                            <h5>
                                {{number_format($user->wallet,0)}} تومان
                            </h5>
                            <i class="fa fa-wallet"></i>
                            <span>موجودی کیف پول شما</span>
                        </div>
                        <div class="profile-box-tabs">
{{--                            <a href="{{url('/password/change')}}" class="profile-box-tab profile-box-tab-access">--}}
{{--                                <i class="now-ui-icons ui-1_lock-circle-open"></i>--}}
{{--                                تغییر رمز--}}
{{--                            </a>--}}
                            <a href="{{route('logout')}}" class="p-2 profile-box-tab--sign-out">
                                <i class="now-ui-icons media-1_button-power"></i>
                                خروج از حساب
                            </a>
                        </div>
                    </div>
                    <div class="responsive-profile-menu show-md">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-navicon"></i>
                                حساب کاربری شما
                            </button>
                            <div class="dropdown-menu dropdown-menu-right text-right">
                                <a href="{{url('/user/profile')}}" class="dropdown-item">
                                    <i class="now-ui-icons users_single-02"></i>
                                    پروفایل
                                </a>
                                @if(!$user->roles->isEmpty())
                                    <a href="{{url('/panel')}}" class="dropdown-item ">
                                        <i class="fas fa-tachometer-alt"></i>
                                        پنل سایت
                                    </a>
                                @endif
                                <a href="{{url('/profile/orders')}}" class="dropdown-item">
                                    <i class="now-ui-icons shopping_cart-simple"></i>
                                    همه سفارش ها
                                </a>
                                <a href="{{url('/profile/likes')}}" class="dropdown-item">
                                    <i class="now-ui-icons ui-2_favourite-28"></i>
                                    لیست علاقمندی ها
                                </a>
                                <a href="{{url('/user/profile/show')}}" class="dropdown-item active-menu">
                                    <i class="now-ui-icons business_badge"></i>
                                    اطلاعات شخصی
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-menu hidden-md">
                        <div class="profile-menu-header">حساب کاربری شما</div>
                        <ul class="profile-menu-items">
                            <li>
                                <a href="{{url('/user/profile')}}" >
                                    <i class="now-ui-icons users_single-02"></i>
                                    پروفایل
                                </a>
                            </li>
                            @if(!$user->roles->isEmpty())
                                <li>
                                    <a href="{{url('/panel')}}" >
                                        <i class="fas fa-tachometer-alt"></i>
                                        پنل سایت
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{url('/user/wallet')}}" >
                                    <i class="fa fa-wallet"></i>
                                    کیف پول
                                </a>
                            </li>
                            <li>
                                <a href="{{url('profile/orders')}}">
                                    <i class="now-ui-icons shopping_cart-simple"></i>
                                    همه سفارش ها
                                </a>
                            </li>
                            <li>
                                <a href="{{url('profile/likes')}}">
                                    <i class="now-ui-icons ui-2_favourite-28"></i>
                                    لیست علاقمندی ها
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/user/profile/show')}}" class="active">
                                    <i class="now-ui-icons business_badge"></i>
                                    اطلاعات شخصی
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- main -->
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('/js/dropzone.min.js')}}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var photosGallery
        var drop = new Dropzone('#photo',{
            addRemoveLinks:true,
            maxFiles :1,
            acceptedFiles: ".svg,.jpg,.png,.jpeg,.bmp,.gif",
            url:"{{route('photo.upload')}}",
            sending:function(file,xhr,formData){
                formData.append("_token","{{csrf_token()}}")
            },
            success:function(file,response){
                document.getElementById('profile-photo').value = response.photo_id
            }
        });

    </script>

@endsection
