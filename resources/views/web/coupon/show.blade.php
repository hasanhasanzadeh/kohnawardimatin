@extends('layouts.app')

@section('meta')
    <meta property="og:url" content="{{url('/coupon/show/'.$coupon->slug)}}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{url('/coupon/show/'.$coupon->slug)}}">
    <script type="application/ld+json">
        {
          "@context": "{{url('/coupon/show/'.$coupon->slug)}}",
          "@type": "Article",
          "name": "{{$coupon->title}}",
          "image": "{{$coupon->photo??$coupon->photo->address}}",
          "description": "{{$coupon->description}}",
        }
    </script>
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
        $categories=$helper['categories'];
        $coupon=$helper['coupon'];
    @endphp
    <main class="default">
        <div class="container">
            <div class="row">
                <div id="products" class="col-12 order-1">
                    <div class="breadcrumb-section default">
                        <ul class="breadcrumb-list">
                            <li>
                                <a href="{{ url('/') }}">
                                    <span>فروشگاه اینترنتی {{ $setting->title }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/coupon/show/'.$coupon->slug) }}">
                                    <span>{{$coupon->title}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="cart-page-content col-12 order-0">
                    <section class="page-content default">
                        <div class="order-info default">
                            <div class="h3 text-center">{{ $coupon->title }}</div>

                            <hr>
                            <br>
                            <div class="text-center">
                                <img src="{{ $coupon->photo->address }}" alt="{{$coupon->title}}" class="mx-auto">
                            </div>
                            <h4>
                                <span>کد تخفیف :</span>
                                <span copy id="copy-text" onclick="copyToClipboard()" class="bg-info px-2 py-1 rounded shadow text-white">{{$coupon->code}}</span>
                                <button class="btn btn-light btn-sm ms-3" onclick="copyToClipboard()">کپی کردن کد</button>
                            </h4>
                            <h4 class="bg-primary px-2 py-1 rounded shadow text-white">
                                <span>درصد تخفیف :</span>
                                <span>{{$coupon->discount}}</span>
                            </h4>
                            <p class="text-justify h6">
                                {!! $coupon->description !!}
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>


@endsection

@section('script')
    <script>
        function copyToClipboard() {
            const textToCopy = document.getElementById("copy-text").innerText;
            navigator.clipboard.writeText(textToCopy).then(() => {
                const successMessage = document.getElementById("success-message");
                successMessage.style.display = "block";
                setTimeout(() => {
                    successMessage.style.display = "none";
                }, 2000);
            }).catch(err => {
                console.error("Failed to copy text: ", err);
            });
        }
    </script>
@endsection
