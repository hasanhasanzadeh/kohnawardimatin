<div class="w-full  md:w-1/2 px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">@lang('dashboard.gallerySelect')</label>
    <input type="file" multiple="multiple" name="gallery[]" id="gallery" class="ppearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" >
    <div id="slider" class="flex flex-wrap">
        @foreach($gallery as $photo)
            <img alt="" src="{{$photo->address}}" width="100" height="100" class="rounded m-2 object-cover">
        @endforeach
    </div>
</div>
