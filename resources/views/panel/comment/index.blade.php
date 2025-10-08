@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                @if(!$comments->isEmpty())
                    <table class="w-full ">
                        <thead>
                        <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                            <th class="px-4 py-3">{{__('dashboard.row')}}</th>
                            <th class="px-4 py-3">@sortablelink('profile',__('dashboard.profile'))</th>
                            <th class="px-4 py-3">@sortablelink('message',__('dashboard.message'))</th>
                            <th class="px-4 py-3">@sortablelink('status',__('dashboard.status'))</th>
                            <th class="px-4 py-3">@sortablelink('created_at',__('dashboard.created_at'))</th>
                            <th class="px-4 py-3">{{__('dashboard.operation')}}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                        @php $row=1 @endphp
                        @foreach($comments as $comment)
                            <tr class="text-gray-700 dark:text-gray-400" title="{!! $comment->message !!}">
                                <td class="px-4 py-3 text-sm">
                                    {{$row++}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{route('customers.show',$comment->user_id)}}" title="{{$comment->user->full_name}}">
                                        @if($comment->user?->photo)
                                            <img src="{{$comment->user?->photo->address}}"  height="70" width="70" alt="" class="rounded-full w-12 h-12 mx-auto">
                                        @else
                                            <img src="{{url('/default-images/avatar.png')}}" height="70" width="70" alt="" class="rounded-full w-12 h-12 mx-auto">
                                        @endif
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    {!!substr($comment->message,0,100).'...'!!}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($comment->status)
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
                                        {{verta()->instance($comment->created_at)->format('%d %B %Y')}}
                                    @else
                                        {{ date('d-M-y', strtotime($comment->created_at))}}
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class=" text-xl flex justify-center">
                                        <a href="{{route('comments.answer',$comment->id)}}" class="text-blue-500 px-2" title="{{__('dashboard.answer')}}">
                                                <i class="fa fa-comment"></i>
                                        </a>
                                        <a href="{{route('comments.status',$comment->id)}}" class="@if($comment->status==1) text-green-600 @else text-red-600 @endif px-2 mx-auto" title="{{__('dashboard.status')}}">
                                            @if($comment->status==1)
                                                <i class="fa-solid fa-circle-check"></i>
                                            @else
                                                <i class="fa-solid fa-circle-xmark"></i>
                                            @endif
                                        </a>
                                        <form action="{{route('comments.destroy',$comment->id)}}" class="mx-auto" method="POST">
                                            @csrf
                                            {{method_field('DELETE')}}
                                            <button class="text-red-600 show_confirm" name="delete" onclick="confirmSubmit()" type="submit" title="{{__('dashboard.delete')}}">
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
            @if(!$comments->isEmpty())
                <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                  {{__('dashboard.number')}}  {{$comments->count()}}
                </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                  <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center px-4" dir="ltr">
                        {!! $comments->appends(Request::except('page'))->render() !!}
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
        $('.show_confirm').click(function(e) {
            if(!confirm('{{__('dashboard.delete')}}')) {
                e.preventDefault();
            }
        });
    </script>
@endsection
