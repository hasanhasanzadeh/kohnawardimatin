@extends('layouts.master')

@section('content')
    <div class="flex flex-col md:flex-row">
        <aside class="z-40 w-full md:w-64 h-full" >
            <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                @include('layouts.sidebar')
            </div>
        </aside>
        <div class="p-4 w-full">
            <a class="bg-blue-600 hover:bg-blue-800 text-white rounded py-2 px-5 my-4" href="{{route('profiles.edit')}}">
                @lang('dashboard.edit')
            </a>
            <div class="border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 my-4">
                <div class="flex justify-center h-auto rounded bg-gray-50 dark:bg-gray-800">
                    <table class="w-full">
                        <tbody class="text-center">
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{__('dashboard.photo')}}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($user->photo_id)
                                    <img src="{{$user->photo->address}}"  height="90" width="90"  class="rounded-full w-12 h-12 mx-auto" alt="">
                                @else
                                    <img src="{{url('/images/no-image.jpg')}}" height="100" width="100" alt="" class="rounded-full mx-auto">
                                @endif
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{__('dashboard.full_name')}}</td>
                            <td class="px-4 py-3 text-xs">
                                {{$user->full_name}}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{__('dashboard.mobile')}}</td>
                            <td class="px-4 py-3 text-sm" dir="ltr">
                                {{$user->mobile}}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{__('dashboard.mail')}}</td>
                            <td class="px-4 py-3 text-xs">
                                {{$user->email}}
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{__('dashboard.gender')}}</td>
                            <td class="px-4 py-3 text-xs">
                             <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-blue-600 bg-blue-200 uppercase last:mr-0 mr-1">
                                 @switch($user->gender)
                                     @case('male') @lang('dashboard.male') @break
                                     @case('female') @lang('dashboard.female') @break
                                 @endswitch
                            </span>
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{__('dashboard.birthday')}}</td>
                            <td class="px-4 py-3 text-xs">
                             <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                            {{$user->birthday}}
                            </span>
                            </td>
                        </tr>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">{{__('front.registry_date')}}</td>
                            <td class="px-4 py-3 text-xl">
                                @if(config('app.locale')=='fa')
                                    {{verta()->instance($user->created_at)->format('%d %B %Y')}}
                                @else
                                    {{ date('d-M-y', strtotime($user->created_at))}}
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
