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
    <main class="default">
        <div class="row m-1">
            <div class="container mt-4">
                <div class="card mt-4">
                    <div class="card-body pt-5">
                        <div class="py-4 col-12 col-md-8 m-auto">
                            <span class="pt-5 h4">تماس با {{$setting->title}}</span>
                            <span class="float-left pl-2 m-2 m-2 p-2"><span><i class="fas fa-headset fa-8x"></i></span></span>
                        </div>
                        <p class="text-justify  justify-width text-muted p-1 col-md-8 m-auto">مرکز ارتباط با مشتریان {{$setting->title}} در تمام ایام هفته و به صورت 24 ساعته، پاسخگوی سؤالات و تماسهای مشتریان است. {{$setting->title}} در راستای تکریم مشتریان، امکان پاسخگویی به سؤالات و ارایه مشاوره را از طریق مرکز ارتباط با مشتریان به شماره های ذیل در تمام ایام هفته و به صورت شبانه‌روزی فراهم کرده‌است. کارشناسان {{$setting->title}} در بخش‌‌های پیگیری سفارش، خدمات پس از فروش، حسابداری، امور مالی، پیشنهاد ، انتقاد، مشاوره و اطلاع‌رسانی آماده پاسخگویی به مشتریان هستند. گفتنی است {{$setting->title}} به منظور پیشبرد اهداف مشتری‌مداری و در راستای یکپارچه‌سازی فرآیند ثبت و پیگیری سئوالات، نظرات، مغایرت‌ها و... اولویت پیگیری را به درخواست های ثبت شده بر روی سایت قرار داده است. از این‌رو مشتریان می‌توانند علاوه بر برقراری تماس تلفنی با {{$setting->title}}، بهتر است جهت ثبت درخواست برای پیگیری یا سوال درباره سفارش و ارسال پیام بهتر است از فرم زیر استفاده کنید.
                            پیش از ارسال ایمیل یا تماس تلفنی با {{$setting->title}}، بخش پرسش‏های متداول را ملاحظه فرمایید و در صورتی که پاسخ خود را نیافتید، با ما تماس بگیرید.</p>
                        <div class="row ">
                            <div class="col-12 col-md-8 m-auto">
                                <h6 class="basket-item-title ft-16 py-3">برای پیگیری یا سوال درباره سفارش و ارسال پیام بهتر است از فرم زیر استفاده کنید</h6>
                                <form action="{{route('contact.store')}}" method="POST" class="form-account" >
                                    @csrf
                                    <div class="col-12">
                                        <label for="name" class="form-account-title">نام و نام خانوادگی <span class="text-danger">*</span></label>
                                        <div class="form-account-row">
                                            <input type="text" name="name" class="input-field  text-right" id="name" placeholder="نام و نام خانوادگی خود را وارد کنید" @if(auth()->check()) value="{{auth()->user()->name}}" @else value="{{old('name')}}"  @endif>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="email"  class="form-account-title">ایمیل </label>
                                        <div class="form-account-row">
                                            <input type="email" name="email"  @if(auth()->check()) value="{{auth()->user()->email}}" @else value="{{old('mail')}}"  @endif class="input-field  text-right" id="email" placeholder="ایمیل خود را وارد کنید">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="mobile"  class="form-account-title">تلفن تماس <span class="text-danger">*</span></label>
                                        <div class="form-account-row">
                                            <input type="tel" name="mobile" maxlength="11"  @if(auth()->check()) value="{{auth()->user()->mobile}}" @else value="{{old('mobile')}}"  @endif class="input-field  text-right" id="mobile" placeholder="تلفن تماس خود را وارد کنید">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="subject" class="form-account-title">موضوع <span class="text-danger">*</span></label>
                                        <div class="form-account-row">
                                            <select name="subject" class="input-field  text-right" id="subject">
                                                <option value="" selected>انتخاب کنید</option>
                                                <option value="پیشنهاد" >پیشنهاد</option>
                                                <option value="انتقاد و شکایت" >انتقاد و شکایت</option>
                                                <option value="پیگیری سفارش" >پیگیری سفارش</option>
                                                <option value="خدمات پس از فروش" >خدمات پس از فروش</option>
                                                <option value="سابداری و امور مالی" >حسابداری و امور مالی</option>
                                                <option value="همکاری در فروش" >همکاری در فروش</option>
                                                <option value="مدیریت" >مدیریت</option>
                                                <option value="سایر موضوعات" >سایر موضوعات</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="message"  class="form-account-title">متن پیام <span class="text-danger">*</span></label>
                                        <div class="form-account-row">
                                            <textarea name="message" id="message" class="input-field text-right" id="description" placeholder="متن پیام خود را اینجا وارد کنید...">{{old('description')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                            {!! NoCaptcha::renderJs('fa') !!}
                                            {!! NoCaptcha::display() !!}
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn btn-default btn-lg btn-block" type="submit">ذخیره</button>
                                    </div>
                                </form>
                                <hr>
                                <div class="alert alert-success rounded py-3">
                                    <h6 class="justify-width py-2"> تلفن تماس و فکس: <span dir="ltr">{{$setting->tel}}</span><span class="h6 pr-2">(پاسخگویی 24 ساعته، 7 روز هفته)</span></h6>
                                </div>
                                <br>
                                <h5 class="my-3 py-2">دفتر مرکزی:</h5>
                                <h6 class="py-2 text-justify justify-width">{{$setting->address}}</h6>
                                <h5 class="my-3 py-2">مرکز امور مشتریان:</h5>
                                <h6 class="py-2 text-justify justify-width">لطفا برای ارتباط با مشاوران ما از طریق شماره تلفن <span dir="ltr" class="px-2 h5">{{$setting->tel}}</span> اقدام فرمایید.</h6>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-12 col-md-8 m-auto">
                                <div class="alert alert-danger border-danger justify-width p-3 text-justify d-block rounded">
                                    لطفا قبل از هر اقدامی به کارشناسان پشتیبانی ما تماس گرفته و از خدمات قبل و پس از فروش{{' '.$setting->title.' '}}  استفاده کنید
                                </div>
                                <span class="text-muted py-4 h4">ایمیل سازمانی {{$setting->title}}: <a href="mailto:{{$setting->email}}">{{$setting->email}}</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
