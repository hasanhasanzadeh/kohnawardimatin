@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('symbols.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-plus"></i>
            {{__('dashboard.create')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                @if(!$symbols->isEmpty())
                    <table class="w-full ">
                        <thead>
                        <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                            <th class="px-4 py-3">{{__('dashboard.row')}}</th>
                            <th class="px-4 py-3">@sortablelink('title', __('dashboard.title'))</th>
                            <th class="px-4 py-3">{{__('dashboard.photo')}}</th>
                            <th class="px-4 py-3">{{__('dashboard.settings')}}</th>
                            <th class="px-4 py-3">@sortablelink('created_at', __('dashboard.created_at'))</th>
                            <th class="px-4 py-3">{{__('dashboard.operation')}}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                        @php $row=1 @endphp
                        @foreach($symbols as $symbol)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    {{$row++}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{$symbol->title}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($symbol->photo)
                                        <img src="{{$symbol->photo->address}}"  height="90" width="90" alt="" class="rounded-full w-12 h-12 mx-auto">
                                    @else
                                        <img src="{{url('/default-images/no-image.jpg')}}" height="100" width="100" alt="" class="rounded-full mx-auto">
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @if($symbol->setting->logo_id)
                                        <img src="{{$symbol->setting->logo->address}}"  height="90" width="90" alt="" class="rounded-full w-12 h-12 mx-auto">
                                    @else
                                        <img src="{{url('/default-images/no-image.jpg')}}" height="100" width="100" alt="" class="rounded-full mx-auto">
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if(config('app.locale')=='fa')
                                    {{verta()->instance($symbol->created_at)->format('%d %B %Y')}}
                                    @else
                                        {{ date('d-M-y', strtotime($symbol->created_at))}}
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class=" text-xl flex justify-center">
                                    <a href="{{route('symbols.show',$symbol->id)}}" class="text-blue-500 mx-auto" title="{{__('dashboard.show')}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{route('symbols.edit',$symbol->id)}}" class="text-yellow-400 mx-auto" title="{{__('dashboard.edit')}}">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                        <form action="{{route('symbols.destroy',$symbol->id)}}" class="mx-auto" method="POST">
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
                        <h2 class="text-center py-3 text-6xl">
                            <i class="far fa-grin-alt"></i>
                        </h2>
                    </div>
                @endif
            </div>
            @if(!$symbols->isEmpty())
                <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                  {{__('dashboard.number')}}  {{$symbols->count()}}
                </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                  <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center px-4 text-center" dir="ltr">
                        {!! $symbols->appends(Request::except('page'))->render() !!}
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
