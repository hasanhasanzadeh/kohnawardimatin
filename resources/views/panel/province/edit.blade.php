@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('provinces.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.provinces')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('provinces.update',$province->id)}}">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$province->id}}">
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="province_name">
                                {{__('dashboard.province_name')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="province_name" name="province_name" type="text" value="{{$province->name}}" placeholder="{{__('dashboard.enterProvinceName')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label for="country_id" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.country_name')}}</label>
                            <select name="country_id" id="country_id" class="form-select dark:bg-gray-700 dark:text-gray-200 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="{{$province->country_id}}"  selected >{{$province->country->country_name}}</option>
                            </select>
                        </div>

                        <div class="w-full px-3 my-3">
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
        $('#country_id').select2({
            placeholder: '{{__('dashboard.country_name')}}',
            ajax: {
                url: '{{route('country.search')}}',
                dataType: 'json',
                delay: 220,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (data) {
                            return {
                                text: data.country_name,
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
