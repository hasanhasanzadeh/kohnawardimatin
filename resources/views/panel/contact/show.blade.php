@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('contacts.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.contact')}}
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
                        {{$contact->id}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.photo')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if( $contact->user_id && $contact->user?->photo)
                            <a href="{{route('customers.show',$contact->user_id)}}">
                                <img src="{{$contact->user?->photo->address}}"  height="150" width="150" alt="" class="image-grayscale mx-auto">
                            </a>
                        @elseif($contact->user_id)
                            <a href="{{route('customers.show',$contact->user_id)}}">
                                <img src="{{url('/default-images/no-image.jpg')}}" height="100" width="100" alt="" class="rounded-full mx-auto">
                            </a>
                        @else
                            <img src="{{url('/default-images/no-image.jpg')}}" height="100" width="100" alt="" title="{{$contact->name}}" class="rounded-full mx-auto">
                        @endif
                    </td>
                </tr>

                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.subject')}}</td>
                    <td class="px-4 py-3 text-xs">
                        {{$contact->subject}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.name')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($contact->user_id)
                        {{$contact->user->full_name}}
                        @else
                            {{$contact->name}}
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.mail')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($contact->user_id)
                            {{$contact->user->email}}
                        @else
                            {{$contact->mail}}
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.mobile')}}</td>
                    <td class="px-4 py-3 text-sm" dir="ltr">
                        @if($contact->user_id)
                            {{$contact->user->mobile}}
                        @else
                            {{$contact->mobile}}
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.ip_address')}}</td>
                    <td class="px-4 py-3 text-sm">
                        {{$contact->ip_address}}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.description')}}</td>
                    <td class="px-4 py-3 text-sm">
                        {!!$contact->message!!}
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.status')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($contact->read==1)
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-emerald-600 bg-emerald-200 uppercase last:mr-0 mr-1">
                                 {{__('dashboard.read')}}
                            </span>
                        @elseif($contact->read==0)
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-rose-600 bg-rose-200 uppercase last:mr-0 mr-1">
                                 {{__('dashboard.notRead')}}
                            </span>
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">{{__('dashboard.created_at')}}</td>
                    <td class="px-4 py-3 text-sm">
                        @if(config('app.locale')=='fa')
                            {{verta()->instance($contact->created_at)->format('%d %B %Y')}}
                        @else
                            {{ date('d-M-y', strtotime($contact->created_at))}}
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
