@extends('layouts.app')

@section('style')
    <style>
        #location {
            height: 300px;
            width: 100%;
            z-index: 10 !important;
        }

        .leaflet-marker-icon {
            width: 40px !important;
            height: 40px !important;
            border: none !important;
            border-image: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="mx-3">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="rounded">
                @if($advertise->photos && count($advertise->photos) < 2)
                    <div class="h-56 rounded md:h-96">
                        @if(count($advertise->photos) ==1 )
                            <img src="{{$advertise->photos[0]->address}}" class="rounded object-cover w-full mx-auto"
                                 style="height: 100%;width:70%" alt="">
                        @else
                            <img src="{{url('/images/no-image.jpg')}}" class="rounded object-cover w-full mx-auto"
                                 style="height: 100%;width:70%" alt="">
                        @endif
                    </div>
                @else
                    <div class="h-56 rounded md:h-96">
                        <div id="gallery" class="relative w-full" data-carousel="slide">
                            <!-- Carousel wrapper -->
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                <!-- Item 1 -->
                                @foreach($advertise->photos as $key=>$photo)
                                    <div class="@if($key!=0) hidden @endif duration-700 ease-in-out"
                                         @if($key==0) data-carousel-item="active" @else data-carousel-item @endif >
                                        <img src="{{$photo->address}}"
                                             class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                             style="height: 100%;width:70%;object-fit: cover !important;" alt="">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Slider controls -->
                            <button type="button"
                                    class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                    data-carousel-prev>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-200  hover:bg-blue-500">
                            <svg aria-hidden="true" class="w-6 h-6 text-white dark:text-gray-800" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path></svg>
                            <span class="sr-only">Previous</span>
                        </span>
                            </button>
                            <button type="button"
                                    class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                    data-carousel-next>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-200  hover:bg-blue-500">
                            <svg aria-hidden="true" class="w-6 h-6 text-white dark:text-gray-800" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path></svg>
                            <span class="sr-only">Next</span>
                        </span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            <div class="rounded bg-gray-100" @if(Config::get('app.locale') == 'en') dir="ltr" @else dir="rtl" @endif>
                <div class="p-4 m-4">
                    <h1 class="text-2xl my-4 py-4 h1 dark:text-gray-200">
                        <span class="px-2">@lang('front.title') :</span>
                        {{$advertise->title}}
                    </h1>
                    <h3 class="text-2xl my-4 py-4 h1 dark:text-gray-200">
                        <span class="px-2">@lang('front.price') :</span>
                        @if($advertise->price!=null)
                            @if(config('app.locale')=='en')
                                <span class="px-3">{{number_format($advertise->price,2) .' '.__('front.duller') }}</span>
                            @else
                                <span class="px-3">{{number_format($advertise->price,0).' '.__('front.toman') }}</span>
                            @endif
                        @else
                            @lang('front.agreement')
                        @endif
                    </h3>
                    <p class="text-justify py-4 my-4 dark:text-gray-200">
                        <span class="px-2 text-2xl">@lang('front.description') :</span>
                        {!! $advertise->description !!}
                    </p>
                    <div class="flex justify-between mx-3">
                        <div>
                            <span class="px-2 text-2xl">@lang('front.waysCommunication') :</span>
                        </div>
                        <div class="flex justify-between mx-3">
                            @if($advertise->media_id && $advertise->media->telegram)
                                <div class="p-1">
                                    <a href="{{$advertise->media->telegram}}" target="_blank"
                                       data-tooltip-target="tooltip-telegram" data-tooltip-placement="left"
                                       class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                                        <i class="fa-brands fa-telegram fa-xl"></i>
                                        <span class="sr-only">{{__('front.telegram')}}</span>
                                    </a>
                                    <div id="tooltip-telegram" role="tooltip"
                                         class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm mx-2 font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{__('front.telegram')}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            @endif
                            @if($advertise->media_id && $advertise->media->whatsapp)
                                <div class="p-1">
                                    <a href="{{$advertise->media->whatsapp}}" target="_blank"
                                       data-tooltip-target="tooltip-whatsapp" data-tooltip-placement="left"
                                       class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                                        <i class="fa-brands fa-whatsapp fa-xl"></i>
                                        <span class="sr-only">{{__('front.whatsapp')}}</span>
                                    </a>
                                    <div id="tooltip-whatsapp" role="tooltip"
                                         class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm mx-2 font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{__('front.whatsapp')}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            @endif
                            @if($advertise->media_id && $advertise->media->instagram)
                                <div class="p-1">
                                    <a href="{{$advertise->media->instagram}}" target="_blank"
                                       data-tooltip-target="tooltip-instagram" data-tooltip-placement="left"
                                       class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                                        <i class="fa-brands fa-instagram fa-xl"></i>
                                        <span class="sr-only">{{__('front.instagram')}}</span>
                                    </a>
                                    <div id="tooltip-instagram" role="tooltip"
                                         class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm mx-2 font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{__('front.instagram')}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            @endif
                            @if($advertise->media_id && $advertise->media->facebook)
                                <div class="p-1">
                                    <a href="{{$advertise->media->facebook}}" target="_blank"
                                       data-tooltip-target="tooltip-facebook" data-tooltip-placement="left"
                                       class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                                        <i class="fa-brands fa-facebook fa-xl"></i>
                                        <span class="sr-only">{{__('front.facebook')}}</span>
                                    </a>
                                    <div id="tooltip-facebook" role="tooltip"
                                         class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm mx-2 font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{__('front.facebook')}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            @endif
                            @if($advertise->media_id && $advertise->media->youtube)
                                <div class="p-1">
                                    <a href="{{$advertise->media->youtube}}" target="_blank"
                                       data-tooltip-target="tooltip-youtube" data-tooltip-placement="left"
                                       class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                                        <i class="fa-brands fa-youtube fa-xl"></i>
                                        <span class="sr-only">{{__('front.youtube')}}</span>
                                    </a>
                                    <div id="tooltip-youtube" role="tooltip"
                                         class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm mx-2 font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{__('front.youtube')}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            @endif
                            @if($advertise->media_id && $advertise->media->linkedin)
                                <div class="p-1">
                                    <a href="{{$advertise->media->linkedin}}" target="_blank"
                                       data-tooltip-target="tooltip-linkedin" data-tooltip-placement="left"
                                       class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                                        <i class="fa-brands fa-linkedin fa-xl"></i>
                                        <span class="sr-only">{{__('front.linkedin')}}</span>
                                    </a>
                                    <div id="tooltip-linkedin" role="tooltip"
                                         class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm mx-2 font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{__('front.linkedin')}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            @endif
                            @if($advertise->media_id && $advertise->media->twitter)
                                <div class="p-1">
                                    <a href="{{$advertise->media->twitter}}" target="_blank"
                                       data-tooltip-target="tooltip-twitter" data-tooltip-placement="left"
                                       class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                                        <i class="fa-brands fa-twitter fa-xl"></i>
                                        <span class="sr-only">{{__('front.twitter')}}</span>
                                    </a>
                                    <div id="tooltip-twitter" role="tooltip"
                                         class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm mx-2 font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{__('front.twitter')}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            @endif
                            @if($advertise->media_id && $advertise->media->tel)
                                <div class="p-1">
                                    <a href="tel:{{$advertise->media->tel}}" data-tooltip-target="tooltip-tel"
                                       data-tooltip-placement="left"
                                       class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                                        <i class="fa fa-phone-flip fa-xl"></i>
                                        <span class="sr-only">{{__('front.mobile')}}</span>
                                    </a>
                                    <div id="tooltip-tel" role="tooltip"
                                         class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm mx-2 font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{__('front.mobile')}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            @endif
                            @if($advertise->media_id && $advertise->media->email)
                                <div class="p-1">
                                    <a href="mailto:{{$advertise->media->email}}" data-tooltip-target="tooltip-email"
                                       data-tooltip-placement="left"
                                       class="flex justify-center items-center w-[52px] h-[52px] text-gray-500 hover:text-gray-900 bg-white rounded-full border border-gray-200 dark:border-gray-600 shadow-sm dark:hover:text-white dark:text-gray-400 hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:focus:ring-gray-400">
                                        <i class="fa fa-envelope fa-xl"></i>
                                        <span class="sr-only">{{__('front.mail')}}</span>
                                    </a>
                                    <div id="tooltip-email" role="tooltip"
                                         class="absolute z-50 invisible inline-block w-auto px-3 py-2 text-sm mx-2 font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{__('front.mail')}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="px-5 pb-5">
                        <div class="flex flex-wrap flex-col items-center justify-between">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white py-2">
                                @if($advertise->price!=null)
                                    @if(config('app.locale')=='en')
                                        <span class="px-3">{{number_format($advertise->price,2) .' '.__('front.duller') }}</span>
                                    @else
                                        <span class="px-3">{{number_format($advertise->price,0).' '.__('front.toman') }}</span>
                                    @endif
                                @else
                                    @lang('front.agreement')
                                @endif
                            </h3>
                            <div class="flex flex-wrap justify-between text-gray-900 dark:text-white py-4">
                                <a href="{{route('like.add',$advertise->id)}}">
                                    @if(auth()->check())
                                        @if(\App\Models\Like::where('user_id',auth()->user()->id)->where('likeable_id',$advertise->id)->where('likeable_type','App\Models\Advertise')->first())
                                            <span class="px-1"><i class="fa-solid fa-heart text-red-600"></i></span>
                                            <span class="px-1">{{$advertise->likeCount($advertise->id)}}</span>
                                        @else
                                            <span class="px-1"><i class="fa-regular fa-heart"></i></span>
                                            <span class="px-1">{{$advertise->likeCount($advertise->id)}}</span>
                                        @endif
                                    @else
                                        <span class="px-1"><i class="fa-regular fa-heart"></i></span>
                                        <span class="px-1">{{$advertise->likeCount($advertise->id)}}</span>
                                    @endif
                                </a>
                                <span>
                                            <i class="fa fa-eye text-blue-500"></i>
                                            <span class="px-2">{{number_format($advertise->view_count,0)}}</span>
                                    </span>
                                <span>
                                            <i class="fa fa-comments text-gray-400"></i>
                                            <span class="px-2">{{App\Models\Comment::where('commentable_type',get_class($advertise))->where('commentable_id',$advertise->id)->count()}}</span>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 mb-10 justify-center">
            @if($setting->advertise_text)
                <div class="flex p-4 bg-blue-500 text-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-lg">
                                <span class="px-2">
                                    <i class="fa fa-info fa-xl bg-red-600 p-4 rounded-full shadow"></i>
                                </span>
                    <p class="p-2">
                        {!! $setting->advertise_text !!}
                    </p>
                </div>
            @endif
        </div>
        @if($advertise->media_id && $advertise->media->map_data)
            <div class="grid grid-cols-1">
                <div id="location">

                </div>
            </div>
        @endif
        <div class="w-full my-10 bg-gray-100">
            <div class="p-1 m-1 p-4 md:m-4">
                <div class="p-1 m-1 p-4 md:m-4">
                    <div class="w-full bg-gray-200 rounded p-5 m-2 sm:p-1 sm:m-1">
                        <div id="accordion-flush" data-accordion="collapse"
                             data-active-classes="dark:bg-gray-900 text-gray-900 dark:text-white"
                             data-inactive-classes="text-gray-500 dark:text-gray-400">
                            <h2 id="accordion-flush-heading-1">
                                <button type="button"
                                        class="flex items-center justify-between w-full py-5 font-medium text-left  border-b border-gray-200 "
                                        data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                                        aria-controls="accordion-flush-body-1">
                                    <span> {{__('front.comment_create')}}</span>
                                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor"
                                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                                <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                                    @if(auth()->check())
                                        <form action="{{route('comment.store')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="0">
                                            <input type="hidden" name="commentable_id" value="{{ $advertise->id }}">
                                            <input type="hidden" name="commentable_type"
                                                   value="{{ get_class($advertise)}}">
                                            <div class="mb-6">
                                                <label for="message"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('front.message')</label>
                                                <textarea id="message" name="message" rows="6"
                                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                          placeholder="{{__('front.message')}}" required></textarea>
                                            </div>
                                            <button type="submit"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('front.send')</button>
                                        </form>
                                    @else
                                        <h1 class="text-center">
                                            <span> {{__('front.loginForComment')}} </span>
                                            <i class="fa-regular fa-face-smile-wink px-4 text-blue-400 text-2xl"></i>
                                        </h1>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 my-10 justify-center max-w-screen-xl mx-auto">
                        @if($comments->isEmpty())
                            <h1 class="text-center">
                                <span>{{__('front.commentNotExists')}}</span>
                                <i class="fa-regular fa-face-smile-wink px-4 text-blue-400 text-2xl"></i>
                            </h1>
                        @else
                            @foreach($comments as $comment)
                                <div class="shadow bg-gray-50 rounded mt-4">
                                    <div class="flex flex-col md:flex-row  text-center md:justify-between border border-gray-100 p-2">
                                        <div class="flex justify-center justify-items-center py-4">
                                            @if($comment->user->photo_id)
                                                <img class="object-cover w-12 h-12 rounded-full"
                                                     src="{{$comment->user?->photo->address}}" alt=""
                                                     aria-hidden="true"/>
                                            @else
                                                <img src="{{url('/images/no-image.jpg')}}"
                                                     class="object-cover w-12 h-12 rounded-full" height="50" width="50"
                                                     alt="">
                                            @endif
                                            <span class="p-4 justify-items-center">{{$comment->user->full_name}}</span>
                                        </div>
                                        <div class="py-4">
                                            <span>{{__('dashboard.created_at')}} :</span>
                                            <span class="text-xl p-2 md:p-4">
                                        @if(config('app.locale')=='fa')
                                                    {{verta()->instance($comment->created_at)->format('%d %B %Y')}}
                                                @else
                                                    {{ date('d-M-y', strtotime($comment->created_at))}}
                                                @endif
                                    </span>
                                        </div>
                                        <div class="py-4">
                                            <button data-modal-target="response" onclick="sendParent({{$comment->id}})"
                                                    data-modal-toggle="response"
                                                    class="p-4">{{__('front.response')}}</button>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <p class="p-2 m-1 md:p-4 md:m-4">
                                            <span>{{__('dashboard.comment')}} :</span>
                                            <span>{!!$comment->message!!}</span>
                                        </p>
                                    </div>
                                    @if($comment->comments)
                                        @include('layouts.commentable',['objects'=>$comment->comments])
                                    @endif
                                </div>

                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full shadow rounded">
            <div class="p-1 m-1 p-4 md:m-4">
                <div class="p-1 m-1 p-4 md:m-4">
                    <div class="flex justify-between">
                        <h1 class="my-2 h1 text-center dark:text-gray-200">@lang('front.similar_advertises')</h1>
                        <a href="{{route('product.all')}}" class="dark:text-gray-200">
                            {{__('front.advertises')}}
                        </a>
                    </div>
                    <hr class="p-1 my-3">
                    @if(!$advertises->isEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-4 mb-10 gap-4">
                            @include('partials.product',['objects'=>$advertises])
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="response" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative  w-full max-w-2xl max-h-full">
            <div class="relative bg-white  rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start  justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl  font-semibold text-gray-900 dark:text-white">
                        @lang('front.response')
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 @if(Config('app.locale')=='en') ml-auto @else mr-auto @endif inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="response">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <form action="{{route('comment.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="0">
                        <input type="hidden" name="commentable_id" value="{{$advertise->id }}">
                        <input type="hidden" name="commentable_type" value="{{get_class($advertise) }}">
                        <div class="mb-6">
                            <label for="message"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('front.message')</label>
                            <textarea id="message" name="message" rows="6"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="{{__('front.message')}}"></textarea>
                        </div>
                        <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('front.send')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        @if($advertise->media_id && $advertise->media->map_data)
        @php
            $map_data=explode(',',$advertise->media->map_data);
            $lat=$map_data[0];
            $lng=$map_data[1];
        @endphp
        let mapOption = {
            center: [{{$lat}}, {{$lng}}],
            zoom: 11
        }
        @else
        let mapOption = {
            center: [36.6994559, 45.1403370],
            zoom: 11
        }
        @endif

        let maps = new L.map('location', mapOption);
        let layers = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        let customIcons = {
            iconUrl: "{{url('/images/marker-icon.png')}}",
            iconSize: [40, 40]
        }
        let myIcons = L.icon(customIcons);
        maps.addLayer(layers);
        let markers = null;
        @if($advertise->media_id && $advertise->media->map_data)
            map_data = "{{$advertise->media->map_data}}";
        if (map_data != null) {
                <?php
                $map_data = explode(',', $advertise->media->map_data);
                $lat = $map_data[0];
                $lng = $map_data[1];
                ?>
            let lng = "{{$lng}}";
            let lat = "{{$lat}}";
            L.marker([lat, lng]).addTo(maps);
        }
        @endif
    </script>
    <script>
        function sendParent(data_parent) {
            let parentId = data_parent;
            let modal = $('#response');
            console.log('parent:' + parentId);
            modal.find("[name='parent_id']").val(parentId);
        }
    </script>
@endsection
