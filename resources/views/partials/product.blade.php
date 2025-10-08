@foreach($objects as $product)
        <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="{{route('product.show',$product->slug)}}">
                @if(!$product->photo_id)
                    <img src="{{$product->photo->address}}"  alt="" class="rounded-t mx-auto w-full h-96">
                @else
                    <img src="{{url('/images/no-image.jpg')}}" alt="" class="rounded-t mx-auto w-full h-96">
                @endif
            </a>
            <div class="px-5 p-5">
                <a href="{{route('product.show',$product->slug)}}">
                    <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{$product->title}}</h5>
                </a>
                <div class="flex flex-wrap flex-col items-center justify-between">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white py-2">
                        <span class="px-3">{{number_format($product->price,0).' '.__('front.toman') }}</span>
                    </h3>
                    <hr class="text-gray-100 w-full border-1">
                    <div class="flex flex-wrap justify-center text-gray-900 dark:text-white py-4">
                        <a href="{{route('like.add',$product->id)}}">
                            @if(auth()->check())
                                @if(\App\Models\Like::where('user_id',auth()->user()->id)->where('likeable_id',$product->id)->where('likeable_type','App\Models\Advertise')->first())
                                    <span class="px-1"><i class="fa-solid fa-heart text-red-600"></i></span>
                                    <span class="px-1">{{$product->likeCount($product->id)}}</span>
                                @else
                                    <span class="px-1"><i class="fa-regular fa-heart"></i></span>
                                    <span class="px-1">{{$product->likeCount($product->id)}}</span>
                                @endif
                            @else
                                <span class="px-1"><i class="fa-regular fa-heart"></i></span>
                                <span class="px-1">{{$product->likeCount($product->id)}}</span>
                            @endif
                        </a>
                        <span>
                              <i class="fa fa-eye text-blue-500"></i>
                              <span class="px-2">{{number_format($product->view_count,0)}}</span>
                        </span>
                        <span>
                             <i class="fa fa-comments text-gray-400"></i>
                             <span class="px-2">{{App\Models\Comment::where('commentable_type',get_class($product))->where('commentable_id',$advertise->id)->count()}}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
@endforeach
