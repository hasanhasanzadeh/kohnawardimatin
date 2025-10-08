@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('customers.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.customers')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <table class="w-full ">
                <thead>
                <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                    <th class="px-4 py-3">{{__('dashboard.id')}}</th>
                    <th class="px-4 py-3">{{__('dashboard.photo')}}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.photo')}}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($customer->photo)
                                <img src="{{$customer->photo->address}}"  height="90" width="90"  class="rounded-full w-12 h-12 mx-auto" alt="">
                            @else
                                <img src="{{url('/default-images/avatar.png')}}" height="100" width="100" alt="" class="rounded-full mx-auto">
                            @endif
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.full_name')}}</td>
                        <td class="px-4 py-3 text-xs">
                            {{$customer->full_name}}
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.mobile')}}</td>
                        <td class="px-4 py-3 text-sm" dir="ltr">
                            {{$customer->mobile}}
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.mail')}}</td>
                        <td class="px-4 py-3 text-xs">
                            {{$customer->email}}
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">آدرس آی پی</td>
                        <td class="px-4 py-3 text-xs">
                            {{$customer->ip_address}}
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.email_verified')}}</td>
                        <td class="px-4 py-3 text-xs">
                            @if($customer->email_verified_at)
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-blue-600 bg-blue-200 uppercase last:mr-0 mr-1">
                                    @lang('dashboard.active')
                                </span>
                            @else
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                                    @lang('dashboard.inactive')
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.gender')}}</td>
                        <td class="px-4 py-3 text-xs">
                             <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-blue-600 bg-blue-200 uppercase last:mr-0 mr-1">
                                 @switch($customer->gender)
                                     @case('male') @lang('dashboard.male') @break
                                     @case('female') @lang('dashboard.female') @break
                                     @default @lang('dashboard.genderSelect') @break
                                 @endswitch
                            </span>
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.birthday')}}</td>
                        <td class="px-4 py-3 text-xs">
                             <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                            {{$customer->birthday}}
                            </span>
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.card_number')}}</td>
                        <td class="px-4 py-3 text-xs">
                             <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                            {{$customer->card_number}}
                            </span>
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.national_code')}}</td>
                        <td class="px-4 py-3 text-xs">
                             <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-red-600 bg-red-200 uppercase last:mr-0 mr-1">
                            {{$customer->national_code}}
                            </span>
                        </td>
                    </tr>
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">{{__('dashboard.created_at')}}</td>
                        <td class="px-4 py-3 text-sm">
                            @if(config('app.locale')=='fa')
                                {{verta()->instance($customer->created_at)->format('%d %B %Y')}}
                            @else
                                {{ date('d-M-y', strtotime($customer->created_at))}}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

