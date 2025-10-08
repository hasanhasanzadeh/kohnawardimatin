<div class="w-full md:w-1/2 px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-white" for="email">
       <span> {{__('dashboard.mail')}}</span>
    </label>
    <input type="email"  name="email" placeholder="{{__('dashboard.enterEmail')}}" value="{{$object->media_id?$object->media->email:($user->email?$user->email:old('mail'))}}" id="email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input" >
</div>

<div class="w-full md:w-1/2 px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-white" for="tel">
        <span>{{__('dashboard.tel')}}</span>
        <span class="text-red-600 text-xl px-1">*</span>
    </label>
    <input type="tel"  name="tel" placeholder="{{__('dashboard.enterTel')}}" value="{{$object->media_id?$object->media->tel:($user->mobile?$user->mobile:old('tel'))}}" id="tel" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input" >
</div>
<input type="hidden" name="map_data" id="map_data" value="{{$object->media_id?$object->media->map_data:null}}">
<div id="map" class="w-full px-3 my-3">

</div>
