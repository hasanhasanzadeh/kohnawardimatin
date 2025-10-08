@extends('panel.layouts.panel')


@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('cities.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.cities')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('cities.update',$city->id)}}">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$city->id}}">
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="city_name">
                                {{__('dashboard.city_name')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 rounded dark:bg-gray-700 dark:text-gray-200 py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="city_name" name="city_name" type="text" value="{{$city->name}}" placeholder="{{__('dashboard.enterCityName')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label for="province_id" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.province')}}</label>
                            <select name="province_id" class="appearance-none px-10 block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="province_id">
                                <option value="{{$city->province_id}}" selected>{{$city->province->name}}</option>
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
        $('#province_id').select2({
            placeholder: '{{__('dashboard.province')}}',
            ajax: {
                url: '{{route('province.search')}}',
                dataType: 'json',
                delay: 220,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (data) {
                            return {
                                text: data.name,
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
