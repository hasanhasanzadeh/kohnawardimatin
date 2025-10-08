@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('roles.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.roles')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <div class="flex flex-col p-2 bg-slate-100">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('roles.update', $role->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="w-full md:w-1/2 px-3 my-3">
                                <label for="name" class="block text-sm font-medium dark:text-gray-50 text-gray-700">{{__('dashboard.name')}}</label>
                                <div class="mt-1">
                                    <input type="hidden" name="id" value="{{$role->id}}">
                                    <input type="text" id="name" name="name" value="{{ $role->name }}"
                                           class="block w-full dark:bg-gray-700 dark:text-gray-200 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 px-3 my-3">
                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="display_name">
                                    {{__('dashboard.display_name')}}
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="display_name" name="display_name" type="text" value="{{$role->display_name}}" placeholder="{{__('dashboard.display_name')}}">
                            </div>
                            <div class="w-full px-3 my-3">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{__('dashboard.edit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="w-full mt-6 p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">{{__('dashboard.role').' '.__('dashboard.permission')}}</h2>
                    <div class="w-full mt-4 p-2  flex justify-content-around flex-wrap gap-5 text-justify">
                        @if ($role->permissions)
                            @foreach ($role->permissions as $role_permission)
                                <form class="w-1/2 py-2 text-white rounded-md" method="POST"
                                      action="{{ route('roles.permissions.revoke', [$role->id, $role_permission->id]) }}"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 mx-auto text-white font-bold py-2 px-4 rounded">{{ $role_permission->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="w-full px-3 my-3">
                        <form method="POST" action="{{ route('roles.permissions', $role->id) }}">
                            @csrf
                            <div class="w-full px-3 my-3">
                                <label for="permission"
                                       class="block text-sm font-medium dark:text-gray-50 text-gray-700">{{__('dashboard.permission')}}</label>
                                <select id="permission" multiple name="permission[]" autocomplete="permission-name"
                                        class="mt-1 block w-full py-2 px-10 dark:bg-gray-700 dark:text-gray-200 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}" @if(in_array($permission->name,$role->permissions->pluck('name')->toArray(),true)) selected @endif >{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    <div class="w-full px-3 my-3">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">@lang('dashboard.assign')</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#permission').select2({
            tags : true ,
            placeholder: '{{__('dashboard.permissionSelect')}}',
            ajax: {
                url: '{{route('permission.search')}}',
                dataType: 'json',
                delay: 220,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (data) {
                            return {
                                text: data.name,
                                id: data.name
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
