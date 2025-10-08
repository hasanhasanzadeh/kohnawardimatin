@extends('layouts.master')

@section('content')
    <div class="flex flex-col md:flex-row">
        <aside class="z-40 w-full md:w-64 h-full" >
            <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                @include('layouts.sidebar')
            </div>
        </aside>
        <div class="p-4 w-full">
            <div class="border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 my-4">
                <div class="container px-6 mx-auto grid">
                    <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        {{$title}}
                    </span>
                        <form class="my-4">
                            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">@lang('front.search')</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="search" name="search" id="default-search" class="block w-full p-4 text-center text-md text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('front.search')}}" >
                                <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('front.search')</button>
                            </div>
                        </form>

                    <!-- New Table -->
                    <div class="w-full overflow-hidden rounded-lg shadow-xs" >
                        <div class="w-full overflow-x-auto">
                            @if(!$advertises->isEmpty())
                                <table class="w-full whitespace-no-wrap">
                                    <thead>
                                    <tr class="text-xl font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                                        <th class="px-4 py-3">{{__('dashboard.id')}}</th>
                                        <th class="px-4 py-3">{{__('dashboard.photo')}}</th>
                                        <th class="px-4 py-3">{{__('dashboard.title')}}</th>
                                        <th class="px-4 py-3">{{__('dashboard.lang')}}</th>
                                        <th class="px-4 py-3">{{__('dashboard.price')}}</th>
                                        <th class="px-4 py-3">{{__('dashboard.status')}}</th>
                                        <th class="px-4 py-3">{{__('dashboard.created_at')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                                        @foreach($advertises as $advertise)
                                            <tr class="text-gray-700 dark:text-gray-400">
                                                <td class="px-4 py-3 text-sm">
                                                    {{$advertise->id}}
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    @if(!$advertise->photos->isEmpty())
                                                        <a href="{{url("/product/$advertise->user_id/show/$advertise->slug")}}" title="{{$advertise->title}}"> <img src="{{$advertise->photos[0]->address}}"  height="140" width="100" alt="" class="image-grayscale mx-auto"></a>
                                                    @else
                                                        <a href="{{url("/product/$advertise->user_id/show/$advertise->slug")}}" title="{{$advertise->title}}"><img src="{{url('/images/no-image.jpg')}}" height="100" width="100" alt="" class="rounded-full mx-auto"></a>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-xs">
                                                    {{$advertise->title}}
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    @switch($advertise->language->lang)
                                                        @case('fa')
                                                            <span class="text-xs font-semibold inline-block py-1 px-2  rounded text-green-600 bg-green-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.langFa')}}
                                        </span>
                                                            @break
                                                        @case('ku')
                                                            <span class="text-xs font-semibold inline-block py-1 px-2  rounded text-green-600 bg-green-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.langKu')}}
                                        </span>
                                                            @break
                                                        @case('ar')
                                                            <span class="text-xs font-semibold inline-block py-1 px-2  rounded text-green-600 bg-green-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.langAr')}}
                                        </span>
                                                            @break
                                                        @case('en')
                                                            <span class="text-xs font-semibold inline-block py-1 px-2  rounded text-green-600 bg-green-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.langEn')}}
                                        </span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td class="px-4 py-3 text-xl">
                                                    @if($advertise->price && Config('app.locale')=='en')
                                                        <span class="text-xs font-semibold inline-block py-1 px-2  rounded text-green-600 bg-green-200 uppercase last:mr-0 mr-1">
                                          {{number_format($advertise->price,2)}}
                                        </span>
                                                    @elseif($advertise->price && Config('app.locale')!='en')
                                                        <span class="text-xs font-semibold inline-block py-1 px-2  rounded text-green-600 bg-green-200 uppercase last:mr-0 mr-1">
                                          {{number_format($advertise->price,0)}}
                                        </span>
                                                    @else
                                                        <span class="text-xs font-semibold inline-block py-1 px-2  rounded text-green-600 bg-green-200 uppercase last:mr-0 mr-1">
                                          @lang('dashboard.agreement')
                                        </span>
                                                    @endif

                                                </td>
                                                <td class="px-4 py-3 text-xl">
                                                    @if($advertise->status)
                                                        <span class="text-xs font-semibold inline-block py-1 px-2  rounded text-green-600 bg-green-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.active')}}
                                        </span>
                                                    @else
                                                        <span class="text-xs font-semibold inline-block py-1 px-2  rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.inactive')}}
                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    @if(config('app.locale')=='fa')
                                                        {{verta()->instance($advertise->created_at)->format('%d %B %Y')}}
                                                    @else
                                                        {{ date('d-M-y', strtotime($advertise->created_at))}}
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-xl">
                                                    <form action="{{route('like.destroy',$advertise->id)}}" method="POST">
                                                        @csrf
                                                        {{method_field('DELETE')}}
                                                        <button class="text-red-600 show_confirm" name="delete" onclick="confirmSubmit()" type="submit" title="{{__('dashboard.delete')}}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-4xl text-center text-gray-700 dark:text-gray-100">
                                    {{__('dashboard.showEmpty')}}
                                    <h2 class="text-center py-3 " id="smill">
                                        <i class="far fa-grin-alt fa-3x"></i>
                                    </h2>
                                </div>
                            @endif
                        </div>
                        @if(!$advertises->isEmpty())
                            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                                <span class="flex items-center col-span-3">
                                  {{__('dashboard.number')}}  {{$advertises->count()}}
                                </span>
                                <span class="col-span-2"></span>
                                <!-- Pagination -->
                                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                                  <nav aria-label="Table navigation">
                                    <ul class="inline-flex items-center px-4" dir="ltr">
                                       {{$advertises->links()}}
                                    </ul>
                                  </nav>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.show_confirm').click(function(e) {
            if(!confirm('{{__('dashboard.delete')}}')) {
                e.preventDefault();
            }
        });
    </script>
@endsection
