@foreach($categories as $subCategory)
    <div class="checkbox">
        <input id="category_{{$subCategory->id}}" @if( request('category') && in_array($subCategory->id, (array)request('category'))) checked @endif class="try" name="category[]" value="{{$subCategory->id}}" type="checkbox">
        <label for="category_{{$subCategory->id}}">
            {{$subCategory->name}}
        </label>
    </div>
    @if(count($subCategory->childrenRecursive) > 0)
        <ul>
            @include('web.categories.subCat', ['categories'=>$subCategory->childrenRecursive, 'level'=>1])
        </ul>
    @endif
@endforeach
