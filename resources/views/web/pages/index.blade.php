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
    <main class="container default margin-top">
        <div class="row">
            <div class="container mt-5">
                <div class="card">
                    <h5 class="title-up pt-5 m-3 text-center">
                        اهداف ما برای جلب رضایت شما
                    </h5>
                    <div class="card-body">
                        <div class="card-img-top text-center">
                            <img src="{{asset('/images/aims.gif')}}" alt="">
                        </div>
                        @if($bases->isEmpty())
                            <div class="text-center">
                                <div class="icon-empty display-1">
                                    <i class="now-ui-icons travel_info"></i>
                                </div>
                                <h5 class="text-empty">موردی برای نمایش وجود ندارد!</h5>
                            </div>
                        @else
                            <div class="accordion default" id="accordionExample">
                                @foreach($bases as $key=>$base)
                                    <div>
                                        <div class="card-header" id="heading{{$key}}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                                    {{$base->title}}
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapse{{$key}}" class="collapse show" aria-labelledby="heading{{$key}}" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <p class="text-justify">
                                                    {!! $base->description !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
