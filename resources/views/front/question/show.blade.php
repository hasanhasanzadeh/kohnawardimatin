@extends('layouts.app')

@section('content')
    <main class="container default margin-top">
        <div class="row">
            <div class="container mt-5">
                <div class="card">
                    <h5 class="title-up pt-5 m-3 text-center">
                        پاسخ به پرسش های متداول شما
                    </h5>
                    <div class="text-center col-8 col-md-4 m-auto">
                        <form method="get">
                            <div class="input-group ">
                                <input type="search" class="input-field text-right" placeholder="سوالات خود را جستجو کنید"  name="search" value="{{old('search')}}">
                                <div class="m-auto">
                                    <button type="submit" class="btn btn-info mt-3">
                                        <i class="fa fa-search"></i>
                                        جستجوی سوالات
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="card-img-top text-center">
                            <img src="{{asset('/images/ساخت-فروشگاه-اینرنتی-min.jpg')}}" height="300" alt="">
                        </div>
                        @if($questions->isEmpty())
                            <div class="text-center">
                                <div class="icon-empty display-1">
                                    <i class="now-ui-icons travel_info"></i>
                                </div>
                                <h5 class="text-empty">موردی برای نمایش وجود ندارد!</h5>
                            </div>
                        @else
                            <div class="accordion default" id="accordionExample">
                                @foreach($questions as $key=>$question)
                                    <div>
                                        <div class="card-header" id="heading{{$key}}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                                    {{$question->title}}
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapse{{$key}}" class="collapse show" aria-labelledby="heading{{$key}}" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <p>
                                                    {!! $question->body !!}
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
