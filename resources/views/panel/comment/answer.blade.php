@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('comments.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.answer')}}
        </a>

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
                        @if($comment->commentable->photo)
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
            <div class="m-10">
                @include('panel.comment.comment',['object'=>$comment])
            </div>
        @endif
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <hr class="my-3">
                <form class="w-full mt-10" method="post" action="{{route('answer.save',$comment->id)}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{$comment->id}}">
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3 my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.status')}}</label>
                            <select name="status" id="status" class="form-select appearance-none block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" @if($comment->status==1) selected @endif>{{__('dashboard.active')}}</option>
                                <option value="0" @if($comment->status==0) selected @endif>{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        <div class="w-full px-3 my-3">
                            <label for="message" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.message')}} </label>
                            <textarea name="message" placeholder="{{old('message')}}" class="form-textarea appearance-none block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="message" cols="30" rows="10"></textarea>
                        </div>
                        <div class="w-full px-3 my-3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa fa-save"></i>
                                {{__('dashboard.store')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
