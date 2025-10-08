@foreach($categories as $sub_category)
    <li class="list-item list-item-has-children">
        <a class="nav-link" href="{{url('/category/show/'.$sub_category->slug)}}">{{$sub_category->name}}</a>
        <ul class="sub-menu nav">
          @if(count($sub_category->childrenRecursive) > 0)
             @foreach($sub_category->childrenRecursive as $category)
             <li class="list-item">
                 <a href="{{url('/category/show/'.$category->slug)}}" class="nav-link">
                     {{$category->name}}
                 </a>
             </li>
                    @if(count($category->childrenRecursive) > 0)
                        @include('web.partials.cat_list', ['categories'=>$category->childrenRecursive, 'level'=>1])
                    @endif
             @endforeach

          @endif
       </ul>
    </li>
@endforeach
