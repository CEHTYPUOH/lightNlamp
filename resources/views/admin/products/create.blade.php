@extends('templates.admin')
@section('content')
    <form method="POST" id="prodCreateFrm" action="{{route('admin.products.store')}}" class="w-50 mx-auto m-5" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="vendor_code" class="form-label">Артикул</label>
            <input type="text" class="form-control" id="vendor_code" name="vendor_code">
            @error('vendor_code')
                <span class="text-danger">{{$message}}</span>
            @enderror
            @error('msg')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Цена товара</label>
            <input type="text" class="form-control" id="price" name="price" value="{{old('price')}}">
            @error('price')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="count" class="form-label">Количество товара</label>
            <input type="text" class="form-control" id="count" name="count" value="{{old('count')}}">
            @error('count')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="brand_id" class="form-label">Брэнд</label>
            <select name="brand_id" id="brand_id" class="form-control">
                @foreach ($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select>
            @error('brand_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="model_id" class="form-label">Модель</label>
            <select name="model_id" id="model_id" class="form-control">
            </select>
            @error('model_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Категория</label>
            <select name="category_id" id="category_id" class="form-control">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
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
            @foreach ($characteristics as $characteristic)
                <label class="form-label" for="{{$characteristic->name}}">{{$characteristic->name}}</label>
                <input type="text" class="form-control" id="{{$characteristic->name}}" name="characteristics[]">
                <input type="hidden" class="form-control" name="characteristics_id[]" value="{{ $characteristic->id }}">
            @endforeach
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">Изображения</label>
            <input type="file" accept="image/*" id="url" name="urls[]" multiple>
            <div id="previews" class="d-flex">
            </div>
        </div>
        <span hidden id="charactersErrMsg" class="text-danger">Нужно заполнить все характеристики</span><br>
        <span hidden id="imgErrMsg" class="text-danger">Нужно загрузить хотя бы одно изображение</span><br>
        <button id="frmSbmtBtn" type="submit" class="btn btn-primary" style="margin-top: 10px">Создать</button>
    </form>
@endsection

@push('script')
    <script src="{{asset('/js/script.js')}}"></script>
    <script>
        let image = document.getElementById('url')
        let previews = document.getElementById('previews')
        image.addEventListener('change', (e)=>{
            e.preventDefault()
            previews.innerHTML = ``
            let files = []
            let i = 0
            for(let propName in image.files){
                if(propName == i){
                    files.push(image.files[propName]);
                }
                i++
            }
            files.forEach((file)=>{
                document.getElementById('previews').innerHTML += `<img id="preview" class="w-75 h-75" src="${URL.createObjectURL(file)}"/>`
            })
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', ()=>{
            let brandsList = document.getElementById('brand_id')
            let modelsList = document.getElementById('model_id')
            let categoriesList = document.getElementById('category_id')
            let subcategoriesList = document.getElementById('subcategories_ids')
            showSubcategories(subcategoriesList, categoriesList)
            showModels(modelsList, brandsList)

            document.getElementById('frmSbmtBtn').addEventListener('click', async (e)=>{
                checkImgList();
            })
            document.getElementById('url').addEventListener('change', (e)=>{
                checkImgList();
            })
            brandsList.addEventListener('change', async (e)=>{
                e.preventDefault();
                await showModels(modelsList, brandsList)
            })
            categoriesList.addEventListener('change', async (e)=>{
                e.preventDefault();
                await showSubcategories(subcategoriesList, categoriesList)
            })
        })

        function checkImgList(){
            let image = document.getElementById('url')
            let imgErrMsg = document.getElementById('imgErrMsg')
            if(!("0" in image.files)){
                imgErrMsg.hidden = false
                e.preventDefault()
            } else {
                imgErrMsg.hidden = true
            }
        }

        async function showModels(modelsList, brandsList){
            modelsList.innerHTML = ``
            let models = await postJson('{{route('admin.models.showModelsByBrand')}}', brandsList.value, '{{csrf_token()}}')
            models.forEach(model => {
                modelsList.innerHTML += `
                    <option value="${model.id}">${model.name}</option>
                `
            })
        }

        async function showSubcategories(subcategoriesList, categoriesList){
            subcategoriesList.innerHTML = ``
            let subcategories = await postJson('{{route('admin.subcategories.showSubcategoriesByCategory')}}', categoriesList.value, '{{csrf_token()}}')
            subcategories.forEach(subcategory => {
                subcategoriesList.innerHTML += `
                    <input type="checkbox" value="${subcategory.id}" name="subcategories[]" id="subcategory_id${subcategory.id}">
                    <label for="${subcategory.name}">${subcategory.name}</label><br>
                `
            })
        }
    </script>
@endpush
