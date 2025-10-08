@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-sm" >
            <div class="w-full overflow-x-auto">
                <?php $row=1;?>
                @if(!$payments->isEmpty())
                    <table class="w-full ">
                        <thead>
                        <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                            <th class="px-4 py-3">{{__('dashboard.row')}}</th>
                            <th class="px-4 py-3">{{__('dashboard.profile')}}</th>
                            <th class="px-4 py-3">@sortablelink('amount', __('dashboard.amount'))</th>
                            <th class="px-4 py-3">@sortablelink('status',__('dashboard.status'))</th>
                            <th class="px-4 py-3">@sortablelink('type',__('dashboard.type'))</th>
                            <th class="px-4 py-3">@sortablelink('RefID',__('dashboard.payment_id'))</th>
                            <th class="px-4 py-3">@sortablelink('created_at',__('dashboard.created_at'))</th>
                            <th class="px-4 py-3">{{__('dashboard.operation')}}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                        @foreach($payments as $payment)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    {{$row++}}
                                </td>
                                <td class="px-4 py-3 text-sm" dir="ltr">
                                    <a href="{{route('customers.show',$payment->user->id)}}" title="{{$payment->user->full_name??$payment->user->mobile}}">
                                        @if($payment->user?->photo)
                                            <img src="{{$payment->user?->photo->address}}"  height="80" width="80" alt="" class="rounded-full w-12 h-12 mx-auto">
                                        @else
                                            <img src="{{url('/default-images/avatar.png')}}" height="80" width="80" alt="" class="rounded-full w-12 h-12 mx-auto">
                                        @endif
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if(config('app.locale')=='en')
                                        {{number_format($payment->amount,2)}}
                                    @else
                                        {{number_format($payment->amount,0) .' '.__('dashboard.toman')}}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($payment->status=='done')
                                        <span class="text-sm font-semibold inline-block py-1 px-2 rounded text-emerald-600 bg-emerald-200  last:mr-0 mr-1">
                                            {{__('dashboard.Done')}}
                                        </span>
                                    @elseif($payment->status=='undone')
                                        <span class="text-sm font-semibold inline-block py-1 px-2 rounded text-red-600 bg-red-200 last:mr-0 mr-1">
                                            {{__('dashboard.Fail')}}
                                        </span>
                                    @elseif($payment->status=='pending')
                                        <span class="text-sm font-semibold inline-block py-1 px-2 rounded text-red-600 bg-red-200 last:mr-0 mr-1">
                                            {{__('dashboard.Pending')}}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($payment->paymentable_type=='App\Models\Wallet')
                                        <span class="text-sm font-semibold inline-block py-1 px-2 rounded text-blue-600 bg-blue-200  last:mr-0 mr-1">
                                            شارژ کیف پول
                                        </span>
                                    @elseif($payment->paymentable_type=='App\Models\Order')
                                        <span class="text-sm font-semibold inline-block py-1 px-2 rounded text-emerald-600 bg-emerald-200 last:mr-0 mr-1">
                                            سفارش محصول
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                        {{ $payment->RefID}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if(config('app.locale')=='fa')
                                        {{verta()->instance($payment->created_at)->format('%d %B %Y - H:i:s')}}
                                    @else
                                        {{ date('d-M-y - H:i:s', strtotime($payment->created_at))}}
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class=" text-xl flex justify-center">
                                        @if($payment->paymentable_type=='App\Models\Order')
                                            <a href="{{route('orders.show',$payment->paymentable_id)}}" class="text-blue-500 mx-auto" title="{{__('dashboard.show')}}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
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
            @if(!$payments->isEmpty())
                <div class="grid px-4 py-3 text-sm font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                  {{__('dashboard.number')}}  {{$payments->count()}}
                </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                  <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center px-4" dir="ltr">
                        {!! $payments->appends(Request::except('page'))->render() !!}
                    </ul>
                  </nav>
                </span>
                </div>
            @endif
        </div>
    </div>
@endsection
