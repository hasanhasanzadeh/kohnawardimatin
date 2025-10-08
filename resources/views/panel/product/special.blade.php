@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('products.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-plus"></i>
            {{__('dashboard.create')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                @if(!$products->isEmpty())
                    <table class="w-full ">
                        <thead>
                        <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                            <th class="px-4 py-3">{{__('dashboard.id')}}</th>
                            <th class="px-4 py-3">{{__('dashboard.photo')}}</th>
                            <th class="px-4 py-3">{{__('dashboard.title')}}</th>
                            <th class="px-4 py-3">{{__('dashboard.price')}}</th>
                            <th class="px-4 py-3">{{__('dashboard.special')}}</th>
                            <th class="px-4 py-3">{{__('dashboard.expired_at')}}</th>
                            <th class="px-4 py-3">{{__('dashboard.operation')}}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                        @foreach($products as $product)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    {{$product->id}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($product->photo)
                                        <a href="{{route('products.show',$product->id)}}" title="{{$product->title}}"> <img src="{{$product->photo->address}}"  height="140" width="100" alt="" class="image-grayscale mx-auto"></a>
                                    @else
                                        <a href="{{route('products.show',$product->id)}}" title="{{$product->title}}"> <i class="fas fa-camera  text-5xl"></i></a>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    {{$product->title}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if(config('app.locale')=='en')
                                        {{number_format($product->price,2)}}
                                    @else
                                        {{number_format($product->price,0) .' '.__('dashboard.toman')}}
                                    @endif

                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($product->special==1)
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-emerald-600 bg-emerald-200 last:mr-0 mr-1">
                                            {{__('dashboard.active')}}
                                        </span>
                                    @elseif($product->status==0)
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-rose-600 bg-rose-200 last:mr-0 mr-1">
                                             {{__('dashboard.inactive')}}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if(config('app.locale')=='fa')
                                        {{verta()->instance($product->expired_at)->format('%d %B %Y')}}
                                    @else
                                        {{ date('d-M-y', strtotime($product->expired_at))}}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm flex justify-between justify-center my-auto">
                                    <a href="{{route('products.show',$product->id)}}" class="text-blue-500" title="{{__('dashboard.show')}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{route('products.edit',$product->id)}}" class="text-yellow-900" title="{{__('dashboard.edit')}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{route('products.status',$product->id)}}" method="GET" id="form-1">
                                        @csrf
                                        <input type="hidden" name="status" value="{{$product->status}}">
                                        <button type="submit"  class="@if($product->status=='active') text-green-600 @elseif($product->status=='inactive') text-red-600 @elseif($product->status=='soon') text-yellow-700 @endif text-2xl" title="{{__('dashboard.status')}}">
                                            @if($product->status=='active')
                                                <i class="fa-solid fa-circle-check"></i>
                                            @elseif($product->status=='inactive')
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            @elseif($product->status=='soon')
                                                <i class="fa-regular fa-rectangle-xmark"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{route('products.destroy',$product->id)}}" id="form-2" method="POST">
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
            @if(!$products->isEmpty())
                <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                  {{__('dashboard.number')}}  {{$products->count()}}
                </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                  <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center px-4" dir="ltr">
                       {{$products->links()}}
                    </ul>
                  </nav>
                </span>
                </div>
            @endif
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
