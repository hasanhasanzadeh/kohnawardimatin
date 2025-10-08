@extends('layout.app')

@section('content')
    <!-- component -->
    <div class="flex h-screen">
        <!-- Right Pane -->
        <div class="w-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 lg:w-1/2 flex items-center justify-center">
            <div class="max-w-md w-full p-6">
                <div class="block items-center justify-center">
                    <div class="text-sm font-semibold mb-6 text-gray-500">
                        <a href="{{url('/')}}" class="flex justify-center items-center">
                            <img src="{{$setting->logo->address??'https://flowbite.com/docs/images/logo.svg'}}" alt="{{$setting->title}}" class="h-20 rounded-full">
                        </a>
                    </div>
                    <h1 class="text-xl font-semibold mb-6 text-black text-center dark:text-stone-100">
                        ورود / ثبت نام
                    </h1>
                </div>
                <form action="{{route('login')}}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="mobile_email" class="block font-medium text-gray-700 dark:text-gray-200 p-1">شماره موبایل یا ایمیل :</label>
                        <input type="text" id="mobile_email" name="mobile_email" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500" required placeholder="شماره موبایل یا ایمیل خود را وارد کنید">
                    </div>
                    <div class="flex items-start mb-6">
                        <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-purple-300 h-4 w-4 rounded" >
                        </div>
                        <div class="text-sm mr-3">
                            <label for="remember" class="font-medium dark:text-gray-100 text-gray-900">من را به خاطر بسپار</label>
                        </div>
                    </div>
{{--                    <div class="text-center">--}}
{{--                        <div class="flex justify-center text-center items-center px-3 py-2">--}}
{{--                            {!! NoCaptcha::renderJs(app()->getLocale()) !!}--}}
{{--                            {!! NoCaptcha::display() !!}--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div>
                        <button type="submit" class="w-full bg-purple-500 text-dark p-2 text-white rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-700 focus:text-black focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 transition-colors duration-300 my-2">ورود</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Left Pane -->
        @include('layout.left')
    </div>
@endsection
