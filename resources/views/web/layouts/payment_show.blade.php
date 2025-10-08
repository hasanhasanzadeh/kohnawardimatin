<aside class="cart-page-aside col-xl-3 col-lg-4 col-md-6 center-section order-2">
    <div class="checkout-aside">
        <div class="checkout-summary">
            <div class="checkout-summary-main">
                <ul class="checkout-summary-summary">
                    <li><span>مبلغ کل ({{Session::get('cart')->totalQty}} کالا)</span><span>{{Session::get('cart')->totalPointPrice()}} تومان</span></li>
                    <li><span>تخفیف </span><span>{{Session::get('cart')->totalPointDiscountPrice()}} تومان</span></li>
                    @if(auth()->check() && Session::get('coupon'))
                        <li>
                            <span>{{Session::get('coupon')->title}}</span>
                            <span>{{Session::get('cart')->couponPointDiscount()}} تومان</span>
                        </li>
                    @endif
                    <li>
                        <span>هزینه ارسال</span>
                        <span>رایگان<span class="wiki wiki-holder"><span class="wiki-sign"></span>
                       <div class="wiki-container js-dk-wiki is-right">
                            <div class="wiki-arrow">
                            </div>
                           <p class="wiki-text">
                              ارسال به تمام نقاط کشور به صورت رایگان می باشد.
                           </p>
                       </div>
                       </span></span>
                    </li>
                </ul>
                <div class="checkout-summary-devider">
                    <div></div>
                </div>
                <div class="checkout-summary-content">
                    <div class="checkout-summary-price-title">مبلغ قابل پرداخت:</div>
                    <div class="checkout-summary-price-value">
                        <span class="checkout-summary-price-value-amount">{{Session::get('cart')->totalPointPrice()}}</span>تومان
                    </div>
                    <a href="#" class="selenium-next-step-shipping">
                        <div class="parent-btn">
                            <button class="dk-btn dk-btn-info">
                                ادامه ثبت سفارش
                                <i class="now-ui-icons shopping_cart-simple"></i>
                            </button>
                        </div>
                    </a>
                    <div>
                                                <span>
                                                    کالاهای موجود در سبد شما ثبت و رزرو نشده‌اند، برای ثبت سفارش مراحل بعدی
                                                    را تکمیل
                                                    کنید.
                                                </span>
                        <span class="wiki wiki-holder"><span class="wiki-sign"></span>
                                                    <div class="wiki-container is-right">
                                                        <div class="wiki-arrow"></div>
                                                        <p class="wiki-text">
                                                            محصولات موجود در سبد خرید شما تنها در صورت ثبت و پرداخت سفارش
                                                            برای شما رزرو
                                                            می‌شوند. در
                                                            صورت عدم ثبت سفارش، {{$setting->title}} هیچگونه مسئولیتی در قبال تغییر
                                                            قیمت یا موجودی
                                                            این کالاها
                                                            ندارد.
                                                        </p>
                                                    </div>
                                                </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
