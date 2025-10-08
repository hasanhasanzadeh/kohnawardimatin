@foreach($categories as $subCategory)
    <tr class="text-gray-700 dark:text-gray-400">
        <td class="px-4 py-3 text-sm">
            {{$subCategory->id}}
        </td>
        <td class="px-4 py-3 text-sm">
            @if($subCategory->photo!=null)
                <a href="{{route('categories.show',$subCategory->id)}}" title="{{$subCategory->name}}"> <img src="{{$subCategory->photo->address}}"  height="100" width="100" alt="" class="image-grayscale mx-auto"></a>
            @else
                <a href="{{route('categories.show',$subCategory->id)}}" title="{{$subCategory->name}}"><img src="{{url('/images/no-image.jpg')}}" height="100" width="100" alt="" class="rounded-full mx-auto"></a>
            @endif
        </td>
        <td class="px-4 py-3 text-sm">{{str_repeat('--',$level)}} <span> </span>{{$subCategory->name}}</td>
        <td class="px-4 py-3 text-sm">
            @if($subCategory->status)
                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-emerald-600 bg-emerald-200 uppercase last:mr-0 mr-1">
                    {{__('dashboard.active')}}
                 </span>
            @else
                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                    {{__('dashboard.inactive')}}
                </span>
            @endif
        </td>
        <td class="px-4 py-3 text-sm">
            @if(config('app.locale')=='fa')
                {{verta()->instance($subCategory->created_at)->format('%d %B %Y')}}
            @else
                {{ date('d-M-y', strtotime($subCategory->created_at))}}
            @endif
        </td>

        <td class="px-4 py-3">
            <div class=" text-xl flex justify-center">
                <a href="{{route('categories.show',$subCategory->id)}}" class="text-blue-500 mx-auto" title="{{__('dashboard.show')}}">
                    <i class="fa fa-eye"></i>
                </a>
                <a href="{{route('categories.edit',$subCategory->id)}}" class="text-yellow-900 mx-auto" title="{{__('dashboard.edit')}}">
                    <i class="fa fa-edit"></i>
                </a>
                <form action="{{route('categories.destroy',$subCategory->id)}}" class="mx-auto" method="POST">
                    @csrf
                    {{method_field('DELETE')}}
                    <button class="text-red-600 show_confirm" name="delete" onclick="confirmSubmit()" type="submit" title="{{__('dashboard.delete')}}">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @if(count($subCategory->children)>0)
        @include('panel.partials.category_child',['categories'=>$subCategory->children,'level'=>$level+1])
    @endif
@endforeach
