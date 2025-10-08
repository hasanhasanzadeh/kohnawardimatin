@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('orders.search')}}">
                    @csrf
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="order_id">
                                کد سفارش
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <div class="flex justify-center">
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="order_id" name="order_id" maxlength="24" type="text" value="" placeholder="کد سفارش را وارد کنید">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                @if(!$orders->isEmpty())
                    <table class="w-full ">
                        <thead>
                        <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                            <th class="px-4 py-3">ردیف</th>
                            <th class="px-4 py-3">{{__('dashboard.profile')}}</th>
                            <th class="px-4 py-3">@sortablelink('amount',__('dashboard.amount'))</th>
                            <th class="px-4 py-3">@sortablelink('status',__('dashboard.status'))</th>
                            <th class="px-4 py-3">@sortablelink('status_send',__('dashboard.status_send'))</th>
                            <th class="px-4 py-3">@sortablelink('created_at',__('dashboard.created_at'))</th>
                            <th class="px-4 py-3">{{__('dashboard.operation')}}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                        @php $row=1 @endphp
                        @foreach($orders as $order)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    {{$row++}}
                                </td>
                                <td class="px-4 py-3 text-xs" dir="ltr">
                                    @if($order->user?->photo)
                                        <img src="{{$order->user?->photo->address}}"  height="90" width="90" alt="" class="rounded-full w-12 h-12 mx-auto">
                                    @else
                                        <img src="{{url('/default-images/avatar.png')}}" height="100" width="100" alt="" class="rounded-full mx-auto">
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if(config('app.locale')=='en')
                                        {{number_format($order->amount,2)}}
                                    @else
                                        {{number_format($order->amount,0) .' '.__('dashboard.toman')}}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @if($order->status==1)
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-emerald-600 bg-emerald-200 uppercase last:mr-0 mr-1">
                                           پرداخت شد
                                        </span>
                                    @else
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                                            پرداخت نشد
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @switch($order->status_send)
                                        @case('sending')
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-blue-600 bg-blue-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.sending')}}
                                        </span>
                                        @break
                                        @case('send')
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-emerald-600 bg-emerald-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.send')}}
                                        </span>
                                        @break
                                        @case('process')
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-yellow-600 bg-yellow-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.process')}}
                                        </span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if(config('app.locale')=='fa')
                                        {{verta()->instance($order->created_at)->format('%d %B %Y')}}
                                    @else
                                        {{ date('d-M-y', strtotime($order->created_at))}}
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class=" text-xl flex justify-center">
                                    <a href="{{route('orders.show',$order->id)}}" class="text-blue-500 mx-auto" title="{{__('dashboard.show')}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{route('orders.edit',$order->id)}}" class="text-yellow-900 mx-auto" title="{{__('dashboard.edit')}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{route('orders.print',$order->id)}}" class="text-blue-900 mx-auto" title="پرینت سفارش">
                                            <i class="fa fa-print"></i>
                                    </a>
                                    </div>
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
            @if(!$orders->isEmpty())
                <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                  {{__('dashboard.number')}}  {{$orders->count()}}
                </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                  <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center px-4" dir="ltr">
                        {!! $orders->appends(Request::except('page'))->render() !!}
                    </ul>
                  </nav>
                </span>
                </div>
            @endif
        </div>
    </div>
@endsection
