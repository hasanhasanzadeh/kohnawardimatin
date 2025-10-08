@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                @if(!$contacts->isEmpty())
                    <table class="w-full ">
                        <thead>
                        <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">{{__('dashboard.row')}}</th>
                            <th class="px-4 py-3">{{__('dashboard.photo')}}</th>
                            <th class="px-4 py-3">@sortablelink('subject',__('dashboard.subject'))</th>
                            <th class="px-4 py-3">@sortablelink('mail',__('dashboard.email'))</th>
                            <th class="px-4 py-3">@sortablelink('mobile',__('dashboard.mobile'))</th>
                            <th class="px-4 py-3">@sortablelink('status',__('dashboard.status'))</th>
                            <th class="px-4 py-3">@sortablelink('ip_address',__('dashboard.ip_address'))</th>
                            <th class="px-4 py-3">@sortablelink('created_at',__('dashboard.created_at'))</th>
                            <th class="px-4 py-3">{{__('dashboard.operation')}}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                        @php $row=1 @endphp
                        @foreach($contacts as $contact)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    {{$row++}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($contact->user_id && $contact->user?->photo)
                                        <a href="{{route('customers.show',$contact->user_id)}}" title="{{$contact->user->mobile}}">
                                            <img src="{{$contact->user?->photo->address}}" height="70" width="70" alt=""
                                                 class="rounded-full mx-auto"></a>
                                    @elseif($contact->user_id)
                                        <a href="{{route('customers.show',$contact->user_id)}}" title="{{$contact->user->full_name}}">
                                            <img src="{{url('/default-images/avatar.png')}}" height="70" width="70" alt="" class="rounded-full mx-auto">
                                        </a>
                                    @else
                                        <img src="{{url('/default-images/avatar.png')}}" height="70" width="70" alt="" class="rounded-full mx-auto" title="{{$contact->name}}">
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs">
                                        {{$contact->subject}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($contact->user_id)
                                        {{$contact->user->email}}
                                    @else
                                        {{$contact->mail}}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm" dir="ltr">
                                    @if($contact->user_id)
                                        {{$contact->user->mobile}}
                                    @else
                                        {{$contact->mobile}}
                                    @endif
                                </td>
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
                                <td class="px-4 py-3 text-sm">
                                    {{$contact->ip_address}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if(config('app.locale')=='fa')
                                        {{verta()->instance($contact->created_at)->format('%d %B %Y')}}
                                    @else
                                        {{ date('d-M-y', strtotime($contact->created_at))}}
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class=" text-xl flex justify-center">
                                        <a href="{{route('contacts.show',$contact->id)}}" class="text-blue-500 mx-auto"
                                           title="{{__('dashboard.show')}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <form action="{{route('contacts.destroy',$contact->id)}}" class="mx-auto" method="POST">
                                            @csrf
                                            {{method_field('DELETE')}}
                                            <button class="text-red-600 show_confirm" name="delete"
                                                    onclick="confirmSubmit()" type="submit"
                                                    title="{{__('dashboard.delete')}}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-4xl text-center text-gray-700 dark:text-gray-100">
                        {{__('dashboard.showEmpty')}}
                        <h2 class="text-center py-3 " id="smill">
                            <i class="far fa-grin-alt fa-3x"></i>
                        </h2>
                    </div>
                @endif
            </div>
            @if(!$contacts->isEmpty())
                <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                  {{__('dashboard.number')}}  {{$contacts->count()}}
                </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                  <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center px-4" dir="ltr">
                        {!! $contacts->appends(Request::except('page'))->render() !!}
                    </ul>
                  </nav>
                </span>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.show_confirm').click(function (e) {
            if (!confirm('{{__('dashboard.delete')}}')) {
                e.preventDefault();
            }
        });
    </script>
@endsection
