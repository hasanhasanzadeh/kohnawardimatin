@extends('layouts.master')

@section('style')
    <link rel="stylesheet" href="{{url('/css/select2.min.css')}}">
@endsection

@section('content')
    <div class="flex flex-col md:flex-row">
        <aside class="z-40 w-full md:w-64 h-full" >
            <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                @include('layouts.sidebar')
            </div>
        </aside>
        <div class="p-4 w-full">
            <div class="border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 my-4">
                <div class="flex justify-center h-auto rounded bg-gray-50 dark:bg-gray-800">
                    <form class="w-full" method="post" action="{{route('profiles.update')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="flex flex-wrap mx-3 my-2">
                            <div class="w-full md:w-1/2 px-3 my-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="full_name">
                                    {{__('dashboard.full_name')}}
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="full_name" name="full_name" type="text" value="{{$user->full_name}}" placeholder="{{__('dashboard.enterFullName')}}">
                            </div>
                            <div class="w-full md:w-1/2 px-3 my-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="mobile">
                                    {{__('dashboard.mobile')}}
                                </label>
                                <input type="tel" dir="ltr" name="mobile" placeholder="{{__('dashboard.enterMobile')}}" value="{{$user->mobile}}" id="mobile" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input" >
                            </div>
                            <div class="w-full md:w-1/2 px-3 my-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                                    {{__('dashboard.mail')}}
                                </label>
                                <input type="email" name="email" placeholder="{{__('dashboard.enterEmail')}}" value="{{$user->email}}" id="email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input text-left">
                            </div>
                            <div class="w-full md:w-1/2 px-3 my-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="birthday">
                                    {{__('dashboard.birthday')}}
                                </label>
                                <input type="date" name="birthday" placeholder="{{__('dashboard.enterBirthday')}}" value="{{$user->birthday}}" id="birthday" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input text-left" >
                            </div>

                            <div class="w-full md:w-1/2 px-3 my-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="gender">
                                    {{__('dashboard.gender')}}
                                </label>
                                <select class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-8 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="gender" name="gender" >
                                    <option value="male" @if($user->gender=='male') selected @endif > @lang('dashboard.male')</option>
                                    <option value="female" @if($user->gender=='female') selected @endif >@lang('dashboard.female')</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/2 px-3 my-3">
                                @include('panel.partials.select_photo' ,[ 'object'=>\App\Models\Photo::where('user_id',auth()->user()->id)->get(),'subject'=>$user->photo_id?$user->photo:null])
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
    </div>
@endsection
@section('script')
    <script src="{{url('/js/select2.min.js')}}"></script>
    <script type="text/javascript">
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
