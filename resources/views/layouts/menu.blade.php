@foreach($category_sub as $cat)
    <li>
        <a href="{{route('category.show',$cat->slug)}}" class="flex items-center text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500 group">
            <span class="sr-only">{{$cat->name}}</span>
            @if($cat->photo_id)
                <img src="{{$cat->photo->address}}" class="rounded p-2" width="40" height="40" alt="{{$cat->title}}">
            @endif
            {{$cat->name}}
        </a>
    </li>
@endforeach
