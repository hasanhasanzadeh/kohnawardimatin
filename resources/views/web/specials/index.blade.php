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
    <main class="search-page default">
        <div class="container">
            <div class="row">
                <aside class="sidebar-page col-12 col-sm-12 col-md-4 col-lg-3 order-1">
                    <form action="{{ route('products.search')}}" method="GET">
                        <input type="hidden" name="title" value="{{request('title')??''}}" >
                        <div class="box mt-4">
                            <div class="box-header">
                                <div class="box-toggle" data-toggle="collapse" href="#collapseExample1" role="button"
                                     aria-expanded="true" aria-controls="collapseExample1">
                                    دسته بندی نتایج
                                    <i class="now-ui-icons arrows-1_minimal-down"></i>
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="collapse show" id="collapseExample1">
                                    <div class="filter-option">
                                        @foreach($categories as $category)
                                            <div class="checkbox">
                                                <input id="category_{{$category->id}}" @if( request('category') && in_array($category->id, (array)request('category'))) checked @endif name="category[]" value="{{$category->id}}" type="checkbox">
                                                <label for="category_{{$category->id}}">
                                                    {{$category->name}}
                                                </label>
                                            </div>
                                            @if(count($category->childrenRecursive) > 0)
                                                <ul>
                                                    @include('web.categories.subCat', ['categories'=>$category->childrenRecursive, 'level'=>1])
                                                </ul>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-header">
                                <div class="box-toggle" data-toggle="collapse" href="#collapseExample2" role="button"
                                     aria-expanded="true" aria-controls="collapseExample2">
                                    برند
                                    <i class="now-ui-icons arrows-1_minimal-down"></i>
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="collapse show" id="collapseExample2">
                                    <div class="filter-option">
                                        @foreach($brands_show as $brand)
                                            <div class="checkbox">
                                                <input id="brand_{{$brand->id}}" @if( request('brand') && in_array($brand->id, (array)request('brand'))) checked @endif type="checkbox" name="brand[]" class="brand" value="{{$brand->id}}">
                                                <label for="brand_{{$brand->id }}">
                                                    {{$brand->title}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">جستجو</button>
                    </form>
                </aside>
                <div id="products" class="col-12 col-sm-12 col-md-8 col-lg-9 order-1">
                    <div class="breadcrumb-section default">
                        <ul class="breadcrumb-list">
                            <li>
                                <a href="{{ url('/') }}">
                                    <span>فروشگاه اینترنتی {{ $setting->title }}</span>
                                </a>
                            </li>
                            <li><span>جستجوی {{$search}}</span></li>
                        </ul>
                    </div>
                    <div class="listing default">
                        <div class="listing-counter">{{ $show_products->count() }} کالا</div>
                        <div class="listing-header default">
                            <ul class="listing-sort nav nav-tabs justify-content-center" role="tablist"
                                data-label="مرتب‌سازی بر اساس :">
                                <table>
                                    <thead>
                                    <tr class="text-info">
                                        <th class="px-3 mx-2 d-block d-md-inline-block text-right">@sortablelink('title', 'مرثب سازی بر اساس نام')</th>
                                        <th class="px-3 mx-2 d-block d-md-inline-block text-right">@sortablelink('quantity', 'مرثب سازی بر اساس تعداد موجود')</th>
                                        <th class="px-3 mx-2 d-block d-md-inline-block text-right">@sortablelink('price', 'مرتب سازی بر اساس قیمت')</th>
                                        <th class="px-3 mx-2 d-block d-md-inline-block text-right">@sortablelink('created_at', 'جدیدترین ها و قدیمترین ها')</th>
                                    </tr>
                                    </thead>
                                </table>
                            </ul>
                        </div>
                        <div class="default text-center">
                            <div class=" active" id="related">
                                <div class="container no-padding-right">
                                    <ul class="row listing-items">
                                        @foreach($show_products as $key => $product)

                                            <li class="col-xl-3 col-lg-4 col-md-6 col-12 no-padding">
                                                @if($product->quantity < 1 && $product->price==null)
                                                    <div class="label-check">موجود نیست</div>
                                                @elseif($product->discount>0)
                                                    <div class="label-check">{{$product->discount}} % -</div>
                                                @endif
                                                <div class="product-box">
                                                    <div
                                                        class="product-seller-details product-seller-details-item-grid">
                                                        <span class="product-main-seller">
                                                            <span class="product-seller-details-label">فروشنده:
                                                            </span>{{$setting->title}}</span>
                                                        <span class="product-seller-details-badge-container"></span>
                                                    </div>
                                                    <a class="product-box-img" href="{{ url('/product/show/'.$product->slug) }}">
                                                        <img src="{{ $product->photo->address }}" alt="{{$product->title}}">
                                                    </a>
                                                    <div class="product-box-content">
                                                        <div class="product-box-content-row">
                                                            <div class="product-box-title">
                                                                <a href="{{ url('/product/show/'.$product->slug) }}">
                                                                    {{ $product->title }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-box-row product-box-row-price">
                                                            <div class="price">
                                                                @if($product->discount>0)
                                                                    <del class="px-3"><span>{{number_format($product->original_price,0)}}<span> @lang('dashboard.toman') </span></span></del>
                                                                @endif
                                                                <div class="price-value">
                                                                    <div class="price-value-wrapper">
                                                                        {{ number_format($product->price,0) }} <span class="price-currency">@lang('dashboard.toman')</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pager default text-center">
                            <ul class="pager-items">
                                <li class="py-2 my-2 text-info">
                                    {!! $show_products->appends(Request::except('page'))->render('pagination::bootstrap-4') !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- main -->

@endsection
