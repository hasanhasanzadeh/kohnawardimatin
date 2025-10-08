@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('customers.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.customer')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('customers.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap mx-3 my-2">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="full_name">
                                {{__('dashboard.full_name')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="full_name" name="full_name" type="text" value="{{old('full_name')}}" placeholder="{{__('dashboard.enterFullName')}}">
                        </div>

                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.status')}}</label>
                            <select name="status" id="status" class="form-select appearance-none block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" selected>{{__('dashboard.active')}}</option>
                                <option value="0">{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="mobile">
                                {{__('dashboard.mobile')}}
                            </label>
                            <input type="tel" dir="ltr" name="mobile" placeholder="{{__('dashboard.enterMobile')}}" value="{{old('mobile')}}" id="mobile" class="appearance-none block w-full dark:bg-gray-700 dark:text-gray-200 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input" >
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="email">
                                {{__('dashboard.mail')}}
                            </label>
                            <input type="email" name="email" placeholder="{{__('dashboard.enterEmail')}}" value="{{old('mail')}}" id="email" class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input text-left" >
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="birthday">
                                {{__('dashboard.birthday')}}
                            </label>
                            <input type="date" name="birthday" placeholder="{{__('dashboard.enterBirthday')}}" value="{{old('birthday')}}" id="birthday" class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input text-left" >
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="national_code">
                                {{__('dashboard.national_code')}}
                            </label>
                            <input type="text" maxlength="10" name="national_code" placeholder="{{__('dashboard.enterNationalCode')}}" value="{{old('national_code')}}" id="national_code" class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input text-left" >
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="card_number">
                                {{__('dashboard.card_number')}}
                            </label>
                            <input type="text" maxlength="16" name="card_number" placeholder="{{__('dashboard.enterCardNumber')}}" value="{{old('card_number')}}" id="card_number" class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input text-left" >
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="gender">
                                {{__('dashboard.gender')}}
                            </label>
                            <select class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 border border-gray-200 rounded py-3 px-8 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="gender" name="gender" >
                                <option value="male" selected>@lang('dashboard.male')</option>
                                <option value="female">@lang('dashboard.female')</option>
                            </select>
                        </div>
                        @include('panel.partials.photo',['photo'=>null])
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
        $('#city_id').select2({
            placeholder: '{{__('dashboard.city')}}',
            ajax: {
                url: '{{route('city.search')}}',
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
