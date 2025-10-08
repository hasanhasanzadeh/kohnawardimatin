<ul class="space-y-2 font-medium">
    <li>
        <a href="{{route('profiles.show')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
            @if($user->photo_id)
                <img class="object-cover w-10 h-10 rounded-full" src="{{$user->photo->address}}" alt="{{$user->full_name}}" height="70" width="70" aria-hidden="true"/>
            @else
                <img src="{{url('/images/no-image.jpg')}}" class="object-cover w-10 h-10 rounded-full" height="70" width="70" alt="">
            @endif
            <span class="mx-3">@lang('front.profile')</span>
        </a>
    </li>
    @if(!$user->roles->isEmpty())
        <li>
            <a href="{{route('panel.admin')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fa fa-dashboard text-gray-500 transition duration-75 dark:text-gray-400"></i>
                <span class="flex-1 mx-3 whitespace-nowrap">@lang('front.panel')</span>
            </a>
        </li>
    @endif
    <li>
        <a href="{{route('comment.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
            <i class="fa fa-comments text-gray-500 transition duration-75 dark:text-gray-400"></i>
            <span class="flex-1 mx-3 whitespace-nowrap">@lang('front.comments')</span>
            <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{$bale->userBale()['comment_count']}}</span>
        </a>
    </li>
    <li>
        <a href="{{route('like.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
            <i class="fa fa-heart text-gray-500 transition duration-75 dark:text-gray-400"></i>
            <span class="flex-1 mx-3 whitespace-nowrap">@lang('front.likes')</span>
            <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{$bale->userBale()['like_count']}}</span>
        </a>
    </li>
    <li>
        <a href="{{route('logout')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path></svg>
            <span class="flex-1 ml-3 whitespace-nowrap">@lang('front.logout')</span>
        </a>
    </li>
</ul>
