@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('products.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.products')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <table class="w-full ">
                <thead>
                <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                    <th class="px-4 py-3">{{__('dashboard.id')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.description')}}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.id')}}</td>
                    <td class="px-4 py-3 text-sm">
                        {{$product->id}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.photo')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if( $product->photo)
                             <img src="{{$product->photo->address}}"  height="150" width="150" alt="" class="image-grayscale mx-auto">
                        @else
                            <i class="fas fa-camera  text-5xl"></i>
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.gallery')}}</td>
                    <td class="px-4 py-3 text-sm mx-4">
                        <div class="flex justify-center flex-wrap">
                            @if( !$product->images->isEmpty())
                                @foreach($product->images as $picture)
                                    <img src="{{$picture->address}}"  height="70" width="70" alt="" class="image-grayscale mx-auto">
                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.categories')}}</td>
                    <td class="px-4 py-3 text-sm mx-4">
                        <div class="flex justify-center flex-wrap">
                            @if( $product->categories)
                                @foreach($product->categories as $category)
                                    <span class="p-2 m-2 rounded bg-green-500 text-green-100">{{$category->name}}</span>
                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.title')}}</td>
                    <td class="px-4 py-3">
                        {{$product->title}}
                    </td>
                </tr>

                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.sku')}}</td>
                    <td class="px-4 py-3 ">
                        {{$product->sku}}
                    </td>
                </tr>

                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.slug')}}</td>
                    <td class="px-4 py-3 ">
                        {{$product->slug}}
                    </td>
                </tr>

                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.original_name')}}</td>
                    <td class="px-4 py-3">
                        {{$product->original_name}}
                    </td>
                </tr>

                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.quantity')}}</td>
                    <td class="px-4 py-3">
                        {{$product->quantity}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.buy_price')}}</td>
                    <td class="px-4 py-3">
                        {{number_format($product->buy_price,0) .' '.__('dashboard.toman')}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.original_price')}}</td>
                    <td class="px-4 py-3">
                        {{number_format($product->original_price,0) .' '.__('dashboard.toman')}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.discount')}}</td>
                    <td class="px-4 py-3 ">
                        {{$product->discount}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.price')}}</td>
                    <td class="px-4 py-3">
                        {{number_format($product->price,0) .' '.__('dashboard.toman')}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.description')}}</td>
                    <td class="px-4 py-3 text-sm">
                        {!!$product->description!!}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.attribute')}}</td>
                    <td class="px-4 py-3 text-sm">
                        {!!$product->attribute!!}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.status')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($product->status=='active')
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-emerald-600 bg-emerald-200 last:mr-0 mr-1">
                                  {{__('dashboard.active')}}
                            </span>
                        @elseif($product->status=='inactive')
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-rose-600 bg-rose-200 last:mr-0 mr-1">
                                 {{__('dashboard.inactive')}}
                            </span>
                        @elseif($product->status=='soon')
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-yellow-600 bg-yellow-200 last:mr-0 mr-1">
                                 {{__('dashboard.soon')}}
                            </span>
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.created_at')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if(config('app.locale')=='fa')
                            {{verta()->instance($product->created_at)->format('%d %B %Y')}}
                        @else
                            {{ date('d-M-y', strtotime($product->created_at))}}
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
