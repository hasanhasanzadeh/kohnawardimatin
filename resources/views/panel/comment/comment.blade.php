@if($object->comments)
    @foreach($object->comments as $comment)
        <hr>
                        <div class="grid grid-cols-1 gap-2">
            <a href="#" class="w-full flex p-4 items-center m-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <div>
                    @if($comment->user?->photo)
                        <img src="{{$comment->user?->photo->address}}"  height="70" width="70" alt="{{$comment->user->full_name}}" title="{{$comment->user->full_name}}" class="object-cover rounded-full w-20 h-20">
                    @else
                        <img src="{{url('/default-images/avatar.png')}}" height="70" width="70" alt="{{$comment->user->full_name}}" title="{{$comment->user->full_name}}" class="object-cover rounded-full w-20 h-20">
                    @endif
                </div>
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <h5 class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <span class="px-3">تاریخ و ساعت :</span>
                        <span>
                    {{verta()->instance($comment->created_at)->format('%d %B %Y - H:i')}}
                </span>
                    </h5>
                    <h5 class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <span class="px-3">نام و نام خانوادگی :</span>
                        <span>
                    {{$comment->user->full_name}}
                </span>
                    </h5>
                    <p class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        <span class="px-3">نظر :</span>
                        {{$comment->message}}
                    </p>
                </div>
            </a>
        </div>
                    @if($comment->commentable_type=="App\Models\Product")
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{route('products.show',$comment->commentable_id)}}" class="w-full flex p-4 items-center m-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div>
                                    <img src="{{$comment->commentable->photo->address}}"  height="70" width="70" alt="{{$comment->commentable->title}}" title="{{$comment->commentable->title}}" class="object-cover rounded-full w-20 h-20">
                                </div>
                                <div class="flex flex-col justify-between p-4 leading-normal">
                                    <h5 class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                        <span class="px-3">تاریخ و ساعت :</span>
                                        <span>
                                            {{verta()->instance($comment->created_at)->format('%d %B %Y - H:i')}}
                                        </span>
                                    </h5>
                                    <h5 class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                        <span class="px-3">محصول :</span>
                                        <span class="px-3">{{$comment->commentable->title}} :</span>
                                    </h5>
                                    <p class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        <span class="px-3">نظر :</span>
                                        {{$comment->message}}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @elseif($comment->commentable_type=="App\Models\User")
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{route('customers.show',$comment->commentable_id)}}" class="w-full flex p-4 items-center m-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div>
                                    @if($comment->user?->photo)
                                        <img src="{{$comment->commentable->photo->address}}"  height="70" width="70" alt="{{$comment->commentable->full_name}}" title="{{$comment->commentable->full_name}}" class="object-cover rounded-full w-20 h-20">
                                    @else
                                        <img src="{{url('/default-images/avatar.png')}}" height="70" width="70" alt="{{$comment->commentable->full_name}}" title="{{$comment->commentable->full_name}}" class="object-cover rounded-full w-20 h-20">
                                    @endif
                                </div>
                                <div class="flex flex-col justify-between p-4 leading-normal">
                                    <h5 class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                        <span class="px-3">تاریخ و ساعت :</span>
                                        <span>
                                            {{verta()->instance($comment->created_at)->format('%d %B %Y - H:i')}}
                                        </span>
                                    </h5>
                                    <h5 class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                        <span class="px-3">نام و نام خانوادگی :</span>
                                        <span>
                                            {{$comment->commentable->full_name}}
                                        </span>
                                    </h5>
                                    <p class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        <span class="px-3">نظر :</span>
                                        {{$comment->message}}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endif

        @if($comment->comments)
            @include('panel.comment.comment',['object'=>$comment])
        @endif
    @endforeach
@endif







