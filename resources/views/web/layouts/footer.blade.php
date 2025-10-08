<footer class="main-footer default">
    <div class="back-to-top">
        <a href="#"><span class="icon"><i class="now-ui-icons arrows-1_minimal-up"></i></span> <span>بازگشت به
                        بالا</span></a>
    </div>
    <div class="container">
        <div class="footer-services">
            <div class="row">
                @foreach($bases as $base)
                    <div class="service-item col" title="{{$base->description}}">
                        <a target="_blank" href="{{url('/aims')}}">
                            <img src="{{$base->photo->address}}">
                        </a>
                        <p>{{$base->title}}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="footer-widgets">
            <div class="row">
                @foreach($page_cats as $cat)
                    <div class="col-12 col-md-6 col-lg-3 mx-auto">
                        <div class="widget-menu widget card">
                            <header class="card-header">
                                <h3 class="card-title" title="{!! $cat->description !!}">{{$cat->name}}</h3>
                            </header>
                            @if(!$cat->pages->isEmpty())
                                <ul class="footer-menu">
                                    @foreach($cat->pages as $page)
                                        <li title="{{$page->title}}">
                                            <a href="{{url('/page/'.$page->slug)}}">{{$page->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="col-12 col-md-6 col-lg-3 mx-auto">
                    <div class="widget-menu widget card">
                        <header class="card-header">
                            <h3 class="card-title" title="سوالات متداول">درباره ما</h3>
                        </header>

                            <ul class="footer-menu">
                                    <li title="سوالات متداول">
                                        <a href="{{url('/question')}}">سوالات متداول</a>
                                    </li>
                                    <li title="ارتباط با ما">
                                        <a href="{{url('/about-us')}}">ارتباط با ما</a>
                                    </li>
                                    <li title="تماس با ما">
                                        <a href="{{url('/contact-us')}}">تماس با ما</a>
                                    </li>
                                <li title="اهداف ما">
                                        <a href="{{url('/aims')}}">اهداف ما</a>
                                    </li>
                            </ul>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3 mx-auto">
                    <div class="newsletter">
                        <p>از تخفیف‌ها و جدیدترین‌های فروشگاه باخبر شوید:</p>
                        <form action="">
                            <input type="email" class="form-control"
                                   placeholder="آدرس ایمیل خود را وارد کنید...">
                            <input type="submit" class="btn btn-primary" value="ارسال">
                        </form>
                    </div>
                    <div class="socials">
                        <p>ما را در شبکه های اجتماعی دنبال کنید.</p>
                        <div class="flex justify-center mb-3">
                                @if($helper['medias']!=null && $helper['medias']->telegram)
                                    <a href="{{url($helper['medias']->telegram)}}" target="_blank" class="mx-3" title="Telegram">
                                        <i class="fa-brands fa-telegram fa-3x text-info"></i>
                                    </a>
                                @endif
                                    @if($helper['medias']!=null && $helper['medias']->instagram)
                                        <a href="{{url($helper['medias']->instagram)}}" target="_blank" class="mx-3" title="Instagram">
                                            <i class="fa-brands fa-instagram fa-3x text-danger"></i>
                                        </a>
                                    @endif
                                    @if($helper['medias']!=null && $helper['medias']->x_link)
                                        <a href="{{url($helper['medias']->x_link)}}" target="_blank" class="mx-3" title="Twitter">
                                            <i class="fa-brands fa-twitter fa-3x text-info"></i>
                                        </a>
                                    @endif
                                    @if($helper['medias']!=null && $helper['medias']->whatsapp)
                                        <a href="{{url($helper['medias']->whatsapp)}}" target="_blank" class="mx-3" title="Whatsapp">
                                            <i class="fa-brands fa-whatsapp fa-3x text-success"></i>
                                        </a>
                                    @endif
                                    @if($helper['medias']!=null && $helper['medias']->facebook)
                                        <a href="{{url($helper['medias']->facebook)}}" target="_blank" class="mx-3" title="Facebook">
                                            <i class="fa-brands fa-facebook fa-3x text-info"></i>
                                        </a>
                                    @endif
                                    @if($helper['medias']!=null &&$helper['medias']->youtube)
                                        <a href="{{url($helper['medias']->youtube)}}" target="_blank" class="mx-3" title="Youtube">
                                            <i class="fa-brands fa-youtube fa-3x text-danger"></i>
                                        </a>
                                    @endif
                                    @if($helper['medias']!=null && $helper['medias']->linkedin)
                                        <a href="{{url($helper['medias']->linkedin)}}" target="_blank" class="mx-3" title="Linkedin">
                                            <i class="fa-brands fa-linkedin fa-3x text-info"></i>
                                        </a>
                                    @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="info">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <span>هفت روز هفته ، 24 ساعت شبانه‌روز پاسخگوی شما هستیم.</span>
                </div>
                <div class="col-12 col-lg-4">شماره تلفن :<a target="_blank" class="direction-ltr" dir="ltr" href="tel:{{$setting->tel?$setting->tel:null}}">{{$setting->tel?$setting->tel:null}}</a></div>
                <div class="col-12 col-lg-4">آدرس ایمیل:<a target="_blank" class="direction-ltr" dir="ltr" href="mailto:{{$setting->email?$setting->email:null}}">{{$setting->email ?$setting->email:null}}</a></div>
            </div>
        </div>
    </div>
    <div class="description">
        <div class="container">
            <div class="row">
                <div class="site-description col-12 col-lg-7">
                    <h1 class="site-title">{{$setting->title}}</h1>
                    <p>
                        {!! $setting->about !!}
                    </p>
                </div>
                <div class="symbol col-12 col-lg-5">
                    @if(!$setting->symbols->isEmpty())
                        @foreach($setting->symbols as $symbol)
                            <a href="{{$symbol->url}}" target="_blank"><img src="{{$symbol->photo->address}}" class="image-grayscale" width="150" alt="{{$symbol->title}}" title="{{$symbol->title}}"></a>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <p class="mb-3">
                {{$setting->copy_right}}
            </p>
            <p class="text-center">
                قدرت گرفته از  <a href="https://programmingnest.ir" target="_blank" class="text-danger">آشیانه برنامه نویسی</a>
            </p>
        </div>
    </div>
</footer>
