@extends('templates.admin')
@section('content')
    <div class="d-flex justify-content-around">
    <form method="POST" id="prodUpdtfrm" action="{{route('admin.products.update', $product->id)}}" class="w-50 mx-auto m-5" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="vendor_code" class="form-label">Артикул</label>
            <input type="text" class="form-control" id="vendor_code" name="vendor_code" value="{{$product->vendor_code}}">
            @error('vendor_code')
                <span class="text-danger">{{$message}}</span>
            @enderror
            @error('msg')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Цена товара</label>
            <input type="text" class="form-control" id="price" name="price" value="{{$product->price}}">
            @error('price')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="count" class="form-label">Количество товара</label>
            <input type="text" class="form-control" id="count" name="count" value="{{$product->count}}">
            @error('count')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="brand_id" class="form-label">Брэнд</label>
            <select name="brand_id" id="brand_id" class="form-control">
                @foreach ($brands as $brand)
                    <option value="{{$brand->id}}" @if ($product->getProductBrand() == $brand->id)
                        @selected(true)
                    @endif  >{{$brand->name}}</option>
                @endforeach
            </select>
            @error('brand_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="model_id" class="form-label">Модель</label>
            <select name="model_id" data-id="{{$product->model_id}}" id="model_id" class="form-control">
            </select>
            @error('model_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Категория</label>
            <select name="category_id" id="category_id" class="form-control">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" @if ($product->getProductCategory() == $category->id)
                        @selected(true)
                    @endif>{{$category->name}}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="subcategories_ids" class="form-label">Подкатегории</label>
            <fieldset id="subcategories_ids">

            </fieldset>
            @error('subcategories_ids')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label>Характеристики:</label><br>
            @foreach ($productCharacteristics as $productCharacteristic)
                <label class="form-label" for="{{$productCharacteristic->characteristic->name}}">{{$productCharacteristic->characteristic->name}}</label>
                <input type="text" class="form-control" id="{{$productCharacteristic->characteristic->name}}" value="{{$productCharacteristic->value}}" name="characteristics[]">
                <input type="hidden" class="form-control" name="prodCharacteristics_id[]" value="{{ $productCharacteristic->characteristic_id }}">
            @endforeach
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">Новые изображения</label>
            <input type="file" accept="image/*" id="url" name="urls[]" multiple>
            <div id="previews" class="d-flex">
            </div>
        </div>
        <button type="submit" id="frmSbmtBtn" class="btn btn-primary">Обновить</button>
    </form>
    <div class="m-5">
        <label class="form-label">Уже существующие изображения</label>
        <div id="imgList" class="row row-cols-3">
            @foreach ($images as $image)
            <div id="delete-form-{{$image->id}}" class="d-flex justify-content-end m-1" style="
            width: 175px;
            height: 175px;
            background-image: url({{$image->url}});
            background-size:contain;
            background-repeat:no-repeat;">
            <form action="{{route('admin.images.destroy', $image->id)}}" method="POST">
                @csrf
                @method("DELETE")
                <button data-image-id="{{$image->id}}" class="imgDltBtn d-flex justify-content-center align-items-center" style="
                    width: 25px;
                    height: 25px;
                    border-radius:50%;
                    border-color:transparent;
                    background-color:red;
                    text-align:center;
                    vertical-align:middle;
                    line-height:1;
                    margin-top: 5px;
                    margin-right: 5px;
                    color:white">
                    ✕
                </button>
            </form>
        </div>
            @endforeach
        </div>
    </div>
</div>
@endsection


@push('script')
    <script src="{{asset('/js/script.js')}}"></script>
    <script>
        let image = document.getElementById('url');
        let previews = document.getElementById('previews')
        image.addEventListener('change', (e)=>{
            e.preventDefault()
            previews.innerHTML = ``
            let files = []
            let i = 0
            for(var propName in image.files){
                if(propName == i){
                    files.push(image.files[propName]);
                }
                i++
            }
            files.forEach((file)=>{
                document.getElementById('previews').innerHTML += `<img id="preview" style="height: 150px; widgth: 150px;" src="${URL.createObjectURL(file)}"/>`
            })
        })
    </script>
    <script>
        var deleteButtons = document.querySelectorAll('.imgDltBtn');
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var imageId = this.getAttribute('data-image-id');
                var deleteForm = document.querySelector('#delete-form-' + imageId + ' form');
                deleteForm.submit();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', ()=>{
            let brandsList = document.getElementById('brand_id')
            let modelsList = document.getElementById('model_id')
            let categoriesList = document.getElementById('category_id')
            let subcategoriesList = document.getElementById('subcategories_ids')
            let imgDltBtns = document.querySelectorAll('.imgDltBtn')
            let image = document.getElementById('url');
            checkImgList()
            showSubcategories(subcategoriesList, categoriesList)
            showModels(modelsList, brandsList)
            imgDltBtns.forEach((btn)=>{
                btn.addEventListener('click', (e)=>{
                    checkImgList(imgDltBtns)
                })
            })
            image.addEventListener('change', (e)=>{
                e.preventDefault()
                checkImgList(imgDltBtns)
            })
            brandsList.addEventListener('change', async (e)=>{
                e.preventDefault()
                showModels(modelsList, brandsList)
            })
            categoriesList.addEventListener('change', async (e)=>{
                e.preventDefault()
                showSubcategories(subcategoriesList, categoriesList)
            })
        })

        function checkImgList(){
            let imgDltBtns = document.querySelectorAll('.imgDltBtn')
            let imgList = document.getElementById('imgList')
            let image = document.getElementById('url')
            let imgErrMsg = document.getElementById('imgErrMsg')
            if((imgList.childElementCount == 1)){
                imgDltBtns.forEach((btn)=>{
                    btn.disabled = true
                });
            } else {
                imgDltBtns.forEach((btn)=>{
                    btn.disabled = false
                });
            }
        }

        async function showModels(modelsList, brandsList){
            modelsList.innerHTML = ``
            let models = await postJson('{{route('admin.models.showModelsByBrand')}}', brandsList.value, '{{csrf_token()}}')
            let prodModel = modelsList.dataset.id
            models.forEach(model => {
                if(prodModel == model.id){
                    modelsList.innerHTML += `
                    <option value="${model.id}" selected>${model.name}</option>
                `
                } else {
                    modelsList.innerHTML += `
                    <option value="${model.id}">${model.name}</option>
                `
                }

            })
        }

        async function showSubcategories(subcategoriesList, categoriesList){
            subcategoriesList.innerHTML = ``
            let subcategories = await postJson('{{route('admin.subcategories.showSubcategoriesByCategory')}}', categoriesList.value, '{{csrf_token()}}')
            let prodSubcategs = await postJson('{{route('admin.subcategories.showProdSubcategs')}}', '{{$product->id}}', '{{csrf_token()}}')
            subcategories.forEach(async (subcategory) => {
                if(prodSubcategs.includes(subcategory.id)){
                    subcategoriesList.innerHTML += `
                    <input type="checkbox" value="${subcategory.id}" name="subcategories[]" id="subcategory_id${subcategory.id}" checked>
                    <label for="${subcategory.name}">${subcategory.name}</label><br>
                `
                } else {
                    subcategoriesList.innerHTML += `
                    <input type="checkbox" value="${subcategory.id}" name="subcategories[]" id="subcategory_id${subcategory.id}">
                    <label for="${subcategory.name}">${subcategory.name}</label><br>
                `
                }
            });
        }
    </script>
@endpush

