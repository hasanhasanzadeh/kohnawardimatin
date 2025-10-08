@foreach($objects as $comment)
    <div class="shadow bg-gray-100 mt-4 rounded">
        <div class="flex flex-col md:flex-row text-center md:justify-between border border-gray-100">
            <div class="flex justify-center justify-items-center py-4">
                @if($comment->user->photo_id)
                    <img class="object-cover w-12 h-12 rounded-full" src="{{$comment->user?->photo->address}}" alt="" aria-hidden="true"/>
                @else
                    <img src="{{url('/images/no-image.jpg')}}" class="object-cover w-12 h-12 rounded-full" height="50" width="50" alt="">
                @endif
                <span class="p-4 justify-items-center">{{$comment->user->full_name}}</span>
            </div>
            <div class="py-4">
                <span>{{__('dashboard.created_at')}} :</span>
                <span class="text-xl p-2 md:p-4">
                                        @if(config('app.locale')=='fa')
                        {{verta()->instance($comment->created_at)->format('%d %B %Y')}}
                    @else
                        {{ date('d-M-y', strtotime($comment->created_at))}}
                    @endif
                                    </span>
            </div>
            <div class="py-4">
                <button data-modal-target="response" onclick="sendParent({{$comment->id}})" data-modal-toggle="response" class="p-4">{{__('front.response')}}</button>
            </div>
        </div>
        <div class="text-center py-4">
            <p class="p-2 m-1 md:p-4 md:m-4">
                <span>{{__('dashboard.comment')}} :</span>
                <span>{!!$comment->message!!}</span>
            </p>
        </div>
        @if($comment->comments)
            @include('layouts.commentable',['objects'=>$comment->comments])
        @endif
    </div>

@endforeach
