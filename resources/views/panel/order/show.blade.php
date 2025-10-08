@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <div class="flex justify-between">
            <a href="{{route('orders.print',$order->id)}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto" title="پرینت سفارش">
                <i class="fa fa-print"></i>
            </a>
            <a href="{{route('orders.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
                <i class="fa fa-list"></i>
                {{__('dashboard.orders')}}
            </a>
        </div>
        <div class="mx-auto my-3">
            <a href="{{route('customers.show',$order->user_id)}}" title="{{$order->user?->full_name.' - '.$order->user?->mobile}}">
                @if($order->user?->photo)
                    <img src="{{$order->user?->photo->address}}" class="rounded-full shadow " height="100" width="100" alt="{{$order->user?->full_name.' - '.$order->user->mobile}}">
                @else
                    <img src="{{url('/default-images/avatar.png')}}" class="rounded-full shadow " height="100" width="100" alt="{{$order->user?->full_name .' - '.$order->user?->mobile}}">
                @endif
            </a>
            <h3 class="p-2 dark:text-gray-50"> نام کاربر :{{$order->user?->full_name}}</h3>
            <h3 class="p-2 dark:text-gray-50">شماره موبایل کاربر :{{$order->user?->mobile }}</h3>
            <h3 class="p-2 dark:text-gray-50">
                <span class=" dark:text-gray-50">وضعیت سفارش :</span>
                @if($order->status==1)
                    <span class="text-xs font-semibold inline-block py-1 px-2 rounded text-emerald-600 bg-emerald-200 uppercase last:mr-0 mr-1">
                                           پرداخت شد
                    </span>
                @else
                    <span class="text-xs font-semibold inline-block py-1 px-2 rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                                            پرداخت نشد
                    </span>
                @endif
            </h3>
            <h3 class="p-2  dark:text-gray-50">
                کد سفارش : <span>{{$order->id}}</span>
            </h3>
        </div>
        <!-- New Table -->
        <div class="w-full rounded-lg shadow-xs" >

            <table class="w-full overflow-auto">
                <thead>
                <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                    <th class="px-4 py-3">{{__('dashboard.id')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.photo')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.sku')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.title')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.quantity')}}</th>
                    <th class="px-4 py-3">مجموع تعداد</th>
                    <th class="px-4 py-3">{{__('dashboard.price')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.total_price')}}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                @foreach($order->products as $product)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm">
                            {{$product->id}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($product->photo_id!=null)
                                <a href="{{route('products.show',$product->id)}}" title="{{$product->title}}"> <img src="{{$product->photo->address}}"  height="140" width="100" alt="" class="image-grayscale mx-auto"></a>
                            @else
                                <a href="{{route('products.show',$product->id)}}" title="{{$product->title}}"> <i class="fas fa-camera  text-5xl"></i></a>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs">
                            {{$product->sku}}
                        </td>
                        <td class="px-4 py-3 text-xs">
                            {{$product->title}}
                        </td>
                        <td class="px-4 py-3 text-xs">
                            @if($product->pivot->option!=null)
                                @php
                                    $attributes=json_decode($product->pivot->option,true);
                                @endphp
                                @foreach($attributes as $attribute)
                                    <div class="flex justify-between">
                                        <div>
                                            @foreach($attribute['value_id'] as $value)
                                                <div class="flex justify-center">
                                                      <span class="">{{App\Models\AttributeValue::find($value)->attribute->name }} :</span>
                                                      <span class="">{{App\Models\AttributeValue::find($value)->value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div>
                                            <h5>{{$attribute['quantity']}}</h5>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            @else
                                <span class="px-2">{{$product->pivot->qty}}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                                {{$product->pivot->qty}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if(config('app.locale')=='en')
                                {{number_format($product->pivot->price,2)}}
                            @else
                                {{number_format($product->pivot->price,0) .' '.__('dashboard.toman')}}
                            @endif

                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{number_format($product->pivot->price*$product->pivot->qty,0)}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr class=" dark:text-gray-400 p-4 text-center text-red-500 bg-red-200 border">
                    <td>@lang('dashboard.address')</td>
                    <td class="px-4 py-3 text-sm text-red-500 bg-red-200" colspan="2">{{$order->address->city->province->name.'-'.$order->address->city->name.'-'.$order->address->address_text.'-'.' کد پستی '.$order->address->post_code}}</td>
                    <td class="px-4 py-3 text-sm  text-blue-500 bg-blue-200" colspan="1">
                        <a href="{{route('posts.show',$order->post_id)}}">
                            {{$order->post->title}}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm" colspan="1">
                        @if($order->post_id)
                            {{ number_format($order->post->price,0) }}
                            @if($order->post->payment_state)
                                <h6 class="p-4">{{__('dashboard.so_rent')}}</h6>
                            @else
                                <h6 class="p-4">{{__('dashboard.advance_rent')}}</h6>
                            @endif
                        @else
                            <span>رایگان</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm @if($order->status)text-emerald-600 bg-emerald-200 @endif">
                        @if($order->status==1)
                                   {{__('dashboard.Done')}}
                        @elseif($order->status==0)
                                   {{__('dashboard.Fail')}}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-blue-500 bg-blue-200">
                        مبلغ قابل پرداخت
                    </td>
                    <td class="px-4 py-3 text-xl text-green-500 bg-green-200">
                         {{ number_format($order->amount,0) }}
                        <span>تومان</span>
                    </td>
                </tr>
                <tr class=" dark:text-gray-400 p-4 text-center text-blue-500 bg-blue-200">
                    <td>نام و نام خانوادگی تحویل گیرنده</td>
                    <td colspan="2" class="px-4 py-3 text-sm">{{$order->address->receptor_name}}</td>
                    <td class="px-4 py-3 text-sm">موبایل تحویل گیرنده</td>
                    <td class="px-4 py-3 text-sm">{{$order->address->receptor_mobile}}</td>
                    <td class="px-4 py-3 text-sm">ایمیل و شماره تلفن کاربر</td>
                    <td class="px-4 py-3 text-sm" colspan="2">{{$order->user?->email.' '.$order->user?->mobile}}</td>
                </tr>
                <tr class=" dark:text-gray-400 p-4 text-center text-yellow-500 bg-yellow-200">
                    <td class="px-4 py-3 text-xl" colspan="2">کد رهگیری پست</td>
                    <td class="px-4 py-3 text-xl" colspan="5">
                       @if($order->serial)
                            {{$order->serial}}
                       @else
                            <span>----</span>
                       @endif
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
