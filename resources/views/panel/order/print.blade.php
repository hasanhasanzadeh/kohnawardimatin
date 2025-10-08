<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page</title>
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <link href="{{ url('/css/fonts.css') }}" rel="stylesheet">
    <style>
        @media print {
            #print-btn {
                display: none; /* Hide the print button */
            }
        }
    </style>
</head>
<body>
<div id="print-area">
    <div class="container px-6  grid mx-auto">
        <div class="text-right ml-auto p-2">
                    <h3>
                        <span class="font-bold">گیرنده : </span>
                        <span>{{$order->address->receptor_name}}</span>
                    </h3>
                    <h3>
                        <span class="font-bold">شماره تماس : </span>
                        <span>{{$order->address->receptor_mobile}}</span>
                    </h3>
                    <h3>
                        <span class="font-bold">آدرس : </span>
                        <span>{{$order->address->city->province->name.' - '.$order->address->city->name.' - '.$order->address->address_text}}</span>
                    </h3>
                    <h3>
                        <span class="font-bold">کد پستی : </span>
                        <span>{{$order->address->post_code}}</span>
                    </h3>
                </div>
        <hr>
        <div class="my-3">
            <div class="text-right">
                <h3 class="p-2 font-bold">
                    کد سفارش : <span>{{$order->id}}</span>
                </h3>
                <h3 class="p-2 font-bold" dir="rtl">
                    تاریخ سفارش : <span dir="ltr">{{verta($order->create_at)}}</span>
                </h3>
                <h3 class="p-2 font-bold" dir="rtl">
                    هزینه پستی سفارش : <span>
                        @if($order->post_price=='0')
                            {{number_format($order->post->price,0).' تومان '}}
                        @else
                            {{number_format($order->post_price,0).' تومان '}}
                        @endif
                    </span>
                </h3>
                <h3 class="p-2 font-bold" dir="rtl">
                    نوع ارسال سفارش : <span>
                        <span>{{$order->post->title}}</span>
                    </span>
                </h3>
                @if($order->coupon_id)
                    <h3 class="p-2 font-bold" dir="rtl">
                        درصد تخفیف سفارش : <span>{{ $order->coupon->discount .' درصد '}}</span>
                    </h3>
                @endif
                <h3 class="p-2 font-bold" dir="rtl">
                    قیمت نهایی سفارش : <span>{{number_format($order->amount,0).' تومان '}}</span>
                </h3>
                <h3 class="p-2 font-bold" dir="rtl">
                    کد رهگیری پستی سفارش : <span>{{$order->serial}}</span>
                </h3>
                <h3 class="p-2 font-bold">
                    @if($order->status==1)
                        <span class="text-xs font-semibold inline-block py-1 px-2 rounded text-emerald-600 bg-emerald-200 uppercase last:mr-0 mr-1">
                                           پرداخت شد
                    </span>
                    @else
                        <span class="text-xs font-semibold inline-block py-1 px-2 rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                                            پرداخت نشد
                    </span>
                    @endif
                    <span>  : وضعیت سفارش </span>
                </h3>
            </div>
        </div>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <table class="w-full" dir="rtl">
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
            </table>
        </div>
    </div>
</div>
<button id="print-btn" onclick="window.print()">Print</button>

<script>
    window.onload = function () {
        window.print();
    };
</script>
</body>
</html>
