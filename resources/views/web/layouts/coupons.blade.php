@if($coupon)
    <div class="bg-danger mt-10 d-none d-lg-block">
        <h4 class="text-center p-2 m-0 text-white" >
            <a href="{{url('/coupon/show/'.$coupon->slug)}}" class="text-white link">
                {{$coupon->title}}
                <i class="fas fa-arrow-circle-left"></i>
            </a>
            <div class="countdown-timer" dir="ltr" countdown data-date="{{$coupon->expired_at}}">
                <span data-days>0</span>:
                <span data-hours>0</span>:
                <span data-minutes>0</span>:
                <span data-seconds>0</span>
            </div>
        </h4>
    </div>
@endif
