@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('categories.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.categories')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <table class="w-full ">
                <thead>
                <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                    <th class="px-4 py-3">{{__('dashboard.id')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.description')}}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.id')}}</td>
                    <td class="px-4 py-3 text-sm">
                        {{$category->id}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.photo')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if( $category->photo)
                             <img src="{{$category->photo->address}}"  height="150" width="150" alt="" class="image-grayscale mx-auto">
                        @else
                            <img src="{{url('/default-images/no-image.jpg')}}" height="100" width="100" alt="" class="rounded-full mx-auto">
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.parent')}}</td>
                    <td class="px-4 py-3 text-xs">
                        @if($category->parent_id!=0)
                            {{\App\Models\Category::find($category->parent_id)->value('name')}}
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.category')}}</td>
                    <td class="px-4 py-3 text-xs">
                        {{$category->name}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.slug')}}</td>
                    <td class="px-4 py-3 text-xs">
                        {{$category->slug}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.status')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($category->status==1)

                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-emerald-600 bg-emerald-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.active')}}
                                        </span>
                        @elseif($category->status==0)

                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-rose-600 bg-rose-200 uppercase last:mr-0 mr-1">
                                            {{__('dashboard.inactive')}}
                            </span>
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.created_at')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if(config('app.locale')=='fa')
                            {{verta()->instance($category->created_at)->format('%d %B %Y')}}
                        @else
                            {{ date('d-M-y', strtotime($category->created_at))}}
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
