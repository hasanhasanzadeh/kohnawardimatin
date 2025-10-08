@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('orders.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.orders')}}
        </a>
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
                        <td class="px-4 py-3 text-sm">
                                {{$product->pivot->qty}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{number_format($product->pivot->price,0)}}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{number_format($product->pivot->price*$product->pivot->qty,0)}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr class="text-gray-700 dark:text-gray-400 p-4 text-center">
                    <td>@lang('dashboard.address')</td>
                    <td class="px-4 py-3 text-sm" colspan="1">{{$order->address->city->province->name.'-'.$order->address->city->name.'-'.$order->address->address_text}}</td>
                    <td class="px-4 py-3 text-sm" colspan="1">هزینه پست</td>
                    <td class="px-4 py-3 text-sm" colspan="1">
                        @if($setting->free_post > $order->amount && $order->post_id)
                            {{ number_format($order->post->price,0) }}
                        @else
                            <span>رایگان</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{number_format($order->products->sum('pivot.qty'),0) }}
                    </td>
                    <td class="px-4 py-3 text-sm" colspan="2">
                        @if($setting->free_post > $order->amount && $order->post_id)
                            {{ number_format($order->post->price,0) }}
                            {{number_format($order->products->sum('pivot.price')+$order->post->price,0) }}
                        @else
                            {{number_format($order->products->sum('pivot.price'),0) }}
                        @endif
                        <span>تومان</span>
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400 p-4 text-center">
                    <td>@lang('dashboard.full_name')</td>
                    <td class="px-4 py-3 text-sm">{{$order->user->full_name}}</td>
                    <td class="px-4 py-3 text-sm">موبایل</td>
                    <td class="px-4 py-3 text-sm">{{$order->user->mobile}}</td>
                    <td class="px-4 py-3 text-sm">ایمیل</td>
                    <td class="px-4 py-3 text-sm" colspan="2">{{$order->user->email}}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
