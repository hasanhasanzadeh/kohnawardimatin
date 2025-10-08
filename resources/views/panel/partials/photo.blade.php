<div class="w-full md:w-1/2 px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="image">
        {{__('dashboard.photo_select')}}
        <span class="px-4 text-red-500 text-sm">*</span>
    </label>
    <input class="appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="image" name="image" type="file" placeholder="{{__('dashboard.photo_select')}}">
    <img id="image-select" alt=""   src="@if($photo!=null) {{$photo->address}} @endif"  class="object-cover shadow rounded @if($photo==null) hidden @endif" width="150" height="150">
</div>
