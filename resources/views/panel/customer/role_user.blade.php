@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('customers.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.customers')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white rounded" >
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('customers.index') }}"
                       class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">@lang('dashboard.customers')</a>
                </div>
                <div class="flex flex-col p-2 bg-slate-100">
                    <div>{{__('dashboard.full_name') }} : {{ $customer->full_name  }}</div>
                    <div >{{__('dashboard.mobile')}}: <span dir="ltr"> {{ $customer->mobile }}</span></div>
                    <div >{{__('dashboard.mail')}}: <span dir="ltr"> {{ $customer->email }}</span></div>
                    <div>
                        @if($customer->photo)
                            <img src="{{$customer->photo->address}}" height="100" width="100" alt="" class="rounded-full mx-auto">
                        @else
                            <img src="{{url('/default-images/avatar.png')}}" height="100" width="100" alt="" class="rounded-full mx-auto">
                        @endif
                    </div>
                </div>
                <div class="mt-6 p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">{{__('dashboard.roles')}}</h2>
                    <div class="flex justify-content-around flex-wrap gap-5 m-4 p-2">
                        @if ($customer->roles)
                            @foreach ($customer->roles as $customer_role)
                                <form class="px-4 py-2 text-white rounded-md" method="POST"
                                      action="{{ route('users.roles.remove', [$customer->id, $customer_role->id]) }}"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="m-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ $customer_role->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <hr>
                    <div class="w-full mt-6">

                        <form method="POST" action="{{ route('users.roles', $customer->id) }}">
                            @csrf
                            <div class="w-full">
                                <label for="role" class="block text-sm font-medium text-gray-700">@lang('dashboard.roles')</label>
                                <select id="role" name="role" autocomplete="role-name"
                                        class="mt-1 block w-full py-2 px-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full pt-5 m-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">@lang('dashboard.assign')</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="mt-6 p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">{{__('dashboard.permissions')}}</h2>
                    <div class="flex justify-content-around flex-wrap gap-5 space-x-2 m-4 p-2">
                        @if ($customer->permissions)
                            @foreach ($customer->permissions as $customer_permission)
                                <form class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" method="POST"
                                      action="{{ route('users.permissions.revoke', [$customer->id, $customer_permission->id]) }}"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="m-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ $customer_permission->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <hr>
                    <div class="w-full mt-6">
                        <form method="POST" action="{{ route('users.permissions', $customer->id) }}">
                            @csrf
                            <div class="w-full">
                                <label for="permission"
                                       class="block text-sm font-medium text-gray-700">@lang('dashboard.permissions')</label>
                                <select id="permission" name="permission" autocomplete="permission-name"
                                        class="mt-1 block w-full py-2 px-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full pt-5">
                                <button type="submit" class="m-4 px-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">@lang('dashboard.assign')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
