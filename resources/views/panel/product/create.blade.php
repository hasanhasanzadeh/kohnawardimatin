@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('products.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.products')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('products.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div id="attributes" data-attributes="{{ json_encode(\App\Models\Attribute::all()->pluck('name')) }}"></div>
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="title">
                                {{__('dashboard.title')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="title" name="title" type="text" value="{{old('title')}}" placeholder="{{__('dashboard.enterTitle')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50  font-bold mb-2" for="slug">
                                {{__('dashboard.slug')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700  dark:bg-gray-700 dark:text-gray-200  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="slug" name="slug" type="text" value="{{old('slug')}}" placeholder="{{__('dashboard.enterSlug')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="original_name">
                                {{__('dashboard.original_name')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <input class="appearance-none block w-full bg-gray-200  dark:bg-gray-700 dark:text-gray-200  text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="original_name" name="original_name" type="text" value="{{old('original_name')}}" placeholder="{{__('dashboard.enterOriginalName')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="expired_at">
                                {{__('dashboard.expired_at')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <input class="appearance-none block w-full bg-gray-200  dark:bg-gray-700 dark:text-gray-200  text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="expired_at" name="expired_at" type="date" value="{{old('expired_at')}}" placeholder="{{__('dashboard.enterExpiredAt')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label class="block uppercase tracking-wide text-gray-700 font-bold dark:text-gray-50 mb-2" for="category_id">
                                {{__('dashboard.categorySelect')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <select name="categories[]" multiple="multiple" class="appearance-none px-10 block   dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 focus:outline-none focus:bg-white focus:border-gray-500 text-left" id="categories">
                                <option value="">{{__('dashboard.categorySelect')}}</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label class="block uppercase tracking-wide text-gray-700 font-bold dark:text-gray-50 mb-2" for="brand_id">
                                {{__('dashboard.brandSelect')}}
                            </label>
                            <select name="brand_id" class="appearance-none px-10 block w-full  dark:bg-gray-700 dark:text-gray-200  bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 focus:outline-none focus:bg-white focus:border-gray-500 text-left" id="brand_id">
                                <option value="">{{__('dashboard.brandSelect')}}</option>
                            </select>
                        </div>
                        <div class="w-full p-3 bg-slate-400 rounded m-3">
                            <h6 class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">ویژگی محصول</h6>
                            <hr>
                            <div id="attribute_section">

                            </div>
                            <div class="w-full overflow-x-auto" >
                                <div class="flex flex-wrap mx-3 mb-2">
                                    <div class="w-full md:w-1/3 px-3  my-1">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="button" id="add_product_attribute">ویژگی جدید</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label for="special" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">
                                {{__('dashboard.special')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <select name="special" id="special" class="form-select appearance-none  dark:bg-gray-700 dark:text-gray-200 block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1"  selected >{{__('dashboard.active')}}</option>
                                <option value="0">{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">
                                {{__('dashboard.status')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <select name="status" id="status" class="form-select appearance-none  dark:bg-gray-700 dark:text-gray-200 block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="active" selected>{{__('dashboard.active')}}</option>
                                <option value="inactive">{{__('dashboard.inactive')}}</option>
                                <option value="soon">{{__('dashboard.soon')}}</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <div class="flex justify-between">
                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="original_price">
                                    {{__('dashboard.original_price')}}
                                    <span class="font-bold text-red-600 px-2">*</span>
                                </label>
                                <span class="original_price font-bold mb-2 dark:text-gray-50"></span>
                            </div>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700  dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="original_price" name="original_price" type="text" value="{{old('original_price')}}" placeholder="{{__('dashboard.enterOriginalPrice')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <div class="flex justify-between">
                                <label class="block uppercase tracking-wide text-gray-700 font-bold dark:text-gray-50 mb-2" for="buy_price">
                                    {{__('dashboard.buy_price')}}
                                    <span class="font-bold text-red-600 px-2">*</span>
                                </label>
                                <span class="buy_price font-bold mb-2 dark:text-gray-50"></span>
                            </div>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 rounded dark:bg-gray-700 dark:text-gray-200  py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="buy_price" name="buy_price" type="text" value="{{old('buy_price')}}" placeholder="{{__('dashboard.enterBuyPrice')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 font-bold dark:text-gray-50 mb-2" for="discount">
                                {{__('dashboard.discount')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 rounded  dark:bg-gray-700 dark:text-gray-200 py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="discount" name="discount" type="text" value="{{old('discount')}}" placeholder="{{__('dashboard.enterDiscount')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <div class="flex justify-between">
                                <label class="block uppercase tracking-wide text-gray-700 font-bold dark:text-gray-50 mb-2" for="price">
                                    {{__('dashboard.price')}}
                                    <span class="font-bold text-red-600 px-2">*</span>
                                </label>
                                <span class="price font-bold mb-2 dark:text-gray-50"></span>
                            </div>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 rounded dark:bg-gray-700 dark:text-gray-200  py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="price" name="price" type="text" value="{{old('price')}}" placeholder="{{__('dashboard.enterPrice')}}">
                        </div>
                        <div class="w-full  px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 font-bold mb-2 dark:text-gray-50" for="quantity">
                                {{__('dashboard.quantity')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 rounded  dark:bg-gray-700 dark:text-gray-200 py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="quantity" name="quantity" type="number" min="0" value="{{old('quantity')}}" placeholder="{{__('dashboard.enterQuantity')}}">
                        </div>
                        @include('panel.partials.photo',['photo'=>null])
                        @include('panel.partials.photo_gallery',['gallery'=>[]])
                        <div class="w-full px-3  my-3">
                            <label for="description" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">
                                {{__('dashboard.description')}}
                            </label>
                            <textarea name="description" class="form-textarea appearance-none block w-full dark:bg-gray-700 dark:text-gray-200  bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="{{__('dashboard.enterDescription')}}" id="description" cols="30" rows="10">{{old('description')}}</textarea>
                        </div>
                        <div class="w-full px-3  my-3">
                            <label for="attribute" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">
                                {{__('dashboard.attribute')}}
                            </label>
                            <textarea name="attribute" class="form-textarea appearance-none block w-full  dark:bg-gray-700 dark:text-gray-200 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="{{__('dashboard.enterAttribute')}}" id="attribute" cols="30" rows="10">{{old('attribute')}}</textarea>
                        </div>
                        @include('panel.partials.meta')
                        <div class="w-full px-3  my-3">
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
    <script src="{{url('/js/numtopersian.min.js')}}"></script>
    <script src="{{asset('plugin/ckeditor/ckeditor.js')}}"></script>
    <script>
        $('body').on('keyup', '#price', function() {
            let price=Num2persian($(this).val())+" {{__('dashboard.toman')}} ";
            $('.price').html(price);
        });
        $('body').on('keyup', '#buy_price', function() {
            let buy_price=Num2persian($(this).val())+" {{__('dashboard.toman')}} ";
            $('.buy_price').html(buy_price);
        });
        $('body').on('keyup', '#original_price', function() {
            let original_price=Num2persian($(this).val())+" {{__('dashboard.toman')}} ";
            $('.original_price').html(original_price);
        });
        $('body').on('keyup', '#discount', function() {
            let discount=$(this).val();
            let original=$('#original_price').val();
            let result=$('#price').val(original-(original*discount/100));
            let price_1=Num2persian($('#price').val())+" {{__('dashboard.toman')}} ";
            console.log(result+'  '+price_1);
            $('.price').html(price_1);
        });

        CKEDITOR.replace('description',{
            customConfig: 'config.js',
            toolbar: 'simple',
            language: '{{Config::get('app.locale')}}',
            removePlugins: 'cloudservices, easyimage',
            filebrowserImageUploadUrl: '/panel/upload-image?type=Images',
            filebrowserUploadMethod: 'form',
            filebrowserUploadUrl:'/panel/upload-image?type=Images',
            filebrowserImage2BrowseUrl:'/panel/upload-image?type=Images',
            filebrowserImageBrowseUrl: '/panel/upload-image?type=Images',
            filebrowserBrowseUrl: '/panel/upload-image?type=Files',
        })
        CKEDITOR.replace('attribute',{
            customConfig: 'config.js',
            toolbar: 'simple',
            language: '{{Config::get('app.locale')}}',
            removePlugins: 'cloudservices, easyimage',
            filebrowserImageUploadUrl: '/panel/upload-image?type=Images',
            filebrowserUploadMethod: 'form',
            filebrowserUploadUrl:'/panel/upload-image?type=Images',
            filebrowserImage2BrowseUrl:'/panel/upload-image?type=Images',
            filebrowserImageBrowseUrl: '/panel/upload-image?type=Images',
            filebrowserBrowseUrl: '/panel/upload-image?type=Files',
        })
        $('#categories').select2({
            placeholder: '{{ __("dashboard.categorySelect") }}',
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('category.search') }}',
                dataType: 'json',
                delay: 220,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            }
        });

        $('#brand_id').select2({
            placeholder: '{{__('dashboard.brandSelect')}}',
            ajax: {
                url: '{{route('brand.search')}}',
                dataType: 'json',
                delay: 220,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (data) {
                            return {
                                text: data.title,
                                id: data.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $("#title").keyup(function() {
            let title=$('#title').val();
            $.ajax({
                type: 'POST',
                url: "{{route('make.slug')}}",
                data: {
                    '_token':"{{csrf_token()}}",
                    'title':title
                },
                success: function(res){
                    $("#slug").val(res);
                }, error: function(){
                    console.log('error for slug make')
                }
            });
        });
    </script>
    <script>
        let changeAttributeValues = (event , id) => {
            let valueBox = $(`select[name='attributes[${id}][value]']`);

            //
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/json'
                }
            })
            //
            $.ajax({
                type : 'POST',
                url : '/panel/attribute/values',
                data : JSON.stringify({
                    name : event.target.value
                }),
                success : function(res) {
                    valueBox.html(`
                            <option value="" selected>انتخاب کنید</option>
                            ${
                        res.data.map(function (item) {
                            return `<option value="${item}">${item}</option>`
                        })
                    }
                        `);
                }
            });
        }

        let createNewAttr = ({ attributes , id }) => {

            return `
                    <div class="w-full overflow-x-auto" id="attribute-${id}">
                        <div class="flex flex-wrap mx-3 mb-2">
                             <div class="w-full md:w-1/3 px-3 my-1">
                                     <label class="lock uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">عنوان ویژگی</label>
                                     <select name="attributes[${id}][name]" onchange="changeAttributeValues(event, ${id});" class="attribute-select appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                        <option value="">انتخاب کنید</option>
                                        ${
                                            attributes.map(function(item) {
                                                return `<option value="${item}">${item}</option>`
                                            })
                                        }
                                     </select>
                                </div>
                             <div class="w-full md:w-1/3 px-3 my-1">
                                     <label class="lock uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">مقدار ویژگی</label>
                                     <select name="attributes[${id}][value]" class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white attribute-select">
                                            <option value="">انتخاب کنید</option>
                                     </select>
                                </div>
                             <div class="w-full md:w-1/3 px-3 my-1">
                                <label class="lock uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">اقدامات</label>
                                <div>
                                    <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="document.getElementById('attribute-${id}').remove()">حذف</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `
        }

        $('#add_product_attribute').click(function() {
            let attributesSection = $('#attribute_section');
            let id = attributesSection.children().length;

            let attributes = $('#attributes').data('attributes');

            attributesSection.append(
                createNewAttr({
                    attributes,
                    id
                })
            );

            $('.attribute-select').select2({ tags : true });
        });
    </script>
@endsection

