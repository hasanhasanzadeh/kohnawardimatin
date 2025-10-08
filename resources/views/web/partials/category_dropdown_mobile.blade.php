@foreach($categories as $category)
    @if(count($category->childrenRecursive) > 0)
        <a class="submenu-item submenu-toggle" data-toggle="collapse" 
           data-target="#submenu-{{$category->id}}" 
           aria-expanded="false" aria-controls="submenu-{{$category->id}}">
            <i class="fa fa-folder mr-2"></i>
            {{$category->name}}
            <i class="fa fa-chevron-down submenu-arrow float-left"></i>
        </a>
        <div class="collapse submenu" id="submenu-{{$category->id}}">
            <div class="submenu-content">
                <a class="submenu-item" href="{{url('/category/show/'.$category->slug)}}">
                    <i class="fa fa-arrow-left mr-2"></i>
                    {{$category->name}}
                </a>
                @include('web.partials.category_dropdown_mobile', ['categories'=>$category->childrenRecursive])
            </div>
        </div>
    @else
        <a class="submenu-item" href="{{url('/category/show/'.$category->slug)}}">
            <i class="fa fa-tag mr-2"></i>
            {{$category->name}}
        </a>
    @endif
@endforeach