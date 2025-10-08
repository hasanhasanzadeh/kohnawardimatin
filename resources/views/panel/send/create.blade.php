@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('sends.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.orders_sms')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('sends.store')}}">
                    @csrf
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label for="user_id" class="block uppercase dark:text-gray-50 tracking-wide text-gray-700 text-xs font-bold mb-2">{{__('dashboard.customer')}}</label>
                            <select name="user_id"  id="user_id" class="form-select dark:bg-gray-700 dark:text-gray-200 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">

                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 text-xs font-bold mb-2">{{__('dashboard.status')}}</label>
                            <select name="status" id="status" class="form-select appearance-none dark:bg-gray-700 dark:text-gray-200 block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" selected>{{__('dashboard.active')}}</option>
                                <option value="0">{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        <div class="w-full px-3  my-3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa fa-save"></i>
                                {{__('dashboard.store')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#user_id').select2({
            placeholder: '{{__('dashboard.customer')}}',
            ajax: {
                url: '{{route('customers.search')}}',
                dataType: 'json',
                delay: 220,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (data) {
                            return {
                                text:' '+data.full_name+' - '+data.mobile+' - '+data.email+' ',
                                id: data.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
