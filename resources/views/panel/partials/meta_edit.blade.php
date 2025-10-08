<div class="w-full px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="meta_title">
        {{__('dashboard.meta_title')}}
    </label>
    <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="meta_title" name="meta_title" type="text" value="{{$object->meta?$object->meta->meta_title:old('meta_title')}}" placeholder="{{__('dashboard.enterMetaTitle')}}">
</div>

<div class="w-full px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="meta_keywords">
        {{__('dashboard.meta_keywords')}}
    </label>
    <textarea  name="meta_keywords" placeholder="{{__('dashboard.enterMetaKeywords')}}"  id="meta_keywords" rows="5" class="appearance-none block w-full dark:bg-gray-700 dark:text-gray-200 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input" >{{$object->meta?$object->meta->meta_keywords:old('meta_keywords')}}</textarea>
</div>
<div class="w-full px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="meta_description">
        {{__('dashboard.meta_description')}}
    </label>
    <textarea  name="meta_description" placeholder="{{__('dashboard.enterMetaDescription')}}"  id="meta_description" rows="5" class="appearance-none block w-full dark:bg-gray-700 dark:text-gray-200 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input" >{{$object->meta?$object->meta->meta_description:old('meta_description')}}</textarea>
</div>
