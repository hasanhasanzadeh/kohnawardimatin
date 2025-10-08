@foreach($categories as $subcategory)
    @if(count($subcategory->childrenRecursive) > 0)
        <div class="dropdown-submenu-wrapper">
            <a class="dropdown-item nav-link-1" href="{{url('/category/show/'.$subcategory->slug)}}">
                {{$subcategory->name}}
            </a>
            <div class="dropdown-submenu nav-link-1">
                @include('web.partials.category_dropdown', ['categories'=>$subcategory->childrenRecursive])
            </div>
        </div>
    @else
        <a class="dropdown-item nav-link-1" href="{{url('/category/show/'.$subcategory->slug)}}">
            {{$subcategory->name}}
        </a>
    @endif
@endforeach
