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
            <a href="{{route('customers.show',$order->user_id)}}" title="{{$order->user?->full_name ??'-'.' - '.$order->user?->mobile ??'-'}}">
                @if($order->user?->photo)
                    <img src="{{$order->user?->photo->address}}" class="rounded-full shadow " height="100" width="100" alt="{{$order->user?->full_name ??'-'.' - '.$order->user?->mobile ??'-'}}">
                @else
                    <img src="{{url('/default-images/avatar.png')}}" class="rounded-full shadow " height="100" width="100" alt="{{$order->user?->full_name ??'-'.' - '.$order->user?->mobile ??'-'}}">
                @endif
            </a>
            <h3 class="p-2"> نام کاربر :{{$order->user?->full_name ??'-'}}</h3>
            <h3 class="p-2">شماره موبایل کاربر :{{$order->user?->mobile ??'-'}}</h3>
            <h3 class="p-2">
                <span>وضعیت سفارش :</span>
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
            <h3 class="p-2">
                کد سفارش : <span>{{$order->id}}</span>
            </h3>
        </div>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <table class="w-full ">
                <thead>
                <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                    <th class="px-4 py-3">{{__('dashboard.id')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.photo')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.sku')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.title')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.quantity')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.quantity')}}</th>
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
                            @if($product->photo_id)
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
                        <td class="px-4 py-3 text-sm">
                            @if($product->pivot->option!=null)
                                @php
                                    $attributes=json_decode($product->pivot->option,true);
                                @endphp
                                @foreach($attributes as $attribute)
                                    <div class="flex justify-between" >
                                        <div>
                                            @foreach($attribute['value_id'] as $value)
                                                <span class="pr-3">
                                                <span>{{App\Models\AttributeValue::find($value)->attribute->name }} :</span>
                                                <span>{{App\Models\AttributeValue::find($value)->value }}</span>
                                               </span>
                                            @endforeach
                                        </div>
                                        <div>
                                            {{$attribute['quantity']}}
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
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
                <tr class="text-gray-700 dark:text-gray-400 p-4 text-center text-red-500 bg-red-200 border">
                    <td>@lang('dashboard.address')</td>
                    <td class="px-4 py-3 text-sm text-red-500 bg-red-200" colspan="2">{{$order->address->city->province->name.'-'.$order->address->city->name.'-'.$order->address->address_text.'-'.' کد پستی: '.$order->address->post_code}}</td>
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
                            پرداخت شد
                        @elseif($order->status==0)
                            پرداخت نشد
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
                <tr class="text-gray-700 dark:text-gray-400 p-4 text-center text-blue-500 bg-blue-200">
                    <td>نام و نام خانوادگی تحویل گیرنده</td>
                    <td  colspan="2" class="px-4 py-3 text-sm">{{$order->address->receptor_name}}</td>
                    <td class="px-4 py-3 text-sm">موبایل تحویل گیرنده</td>
                    <td class="px-4 py-3 text-sm">{{$order->address->receptor_mobile}}</td>
                    <td class="px-4 py-3 text-sm">ایمیل و شماره تلفن کاربر</td>
                    <td class="px-4 py-3 text-sm" colspan="2">{{$order->user?->email.' | '.$order->user?->mobile ??'-'}}</td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400 p-4 text-center text-yellow-500 bg-yellow-200">
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
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('orders.update',$order->id)}}">
                    @csrf
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="serial">
                                کد رهگیری پستی
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="serial" name="serial" maxlength="24" type="text" value="{{$order->serial}}" placeholder="کد رهگیری پستی را وارد کنید">
                        </div>
                        <div class="w-full px-3  my-3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa fa-save"></i>
                                ثبت
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
