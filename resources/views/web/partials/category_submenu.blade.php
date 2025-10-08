@foreach($categories as $sub_category)
    <li class="@if(count($sub_category->childrenRecursive) > 0) sub-menu @endif">
        <a href="{{url('/category/show/'.$sub_category->slug)}}">{{$sub_category->name}}</a>
        <ul>
            @if(count($sub_category->childrenRecursive) > 0)
                @foreach($sub_category->childrenRecursive as $category)
                    <li class=" @if(count($category->childrenRecursive) > 0) sub-menu @endif">
                        <a href="{{url('/category/show/'.$category->slug)}}">
                            {{$category->name}}
                        </a>
                    </li>

                    <ul>
                        @if(count($category->childrenRecursive) > 0)
                            @include('web.partials.category_submenu', ['categories'=>$category->childrenRecursive, 'level'=>1])
                        @endif
                    </ul>
                @endforeach
                    @if(count($sub_category->childrenRecursive) > 0)
                        @include('web.partials.category_submenu', ['categories'=>$category->childrenRecursive, 'level'=>1])
                    @endif
            @endif

        </ul>
    </li>
@endforeach
