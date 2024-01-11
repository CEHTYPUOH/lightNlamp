<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController as AdminBrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CharacteristicController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\ImageController;
use App\Http\Controllers\admin\ModelController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;
use App\Http\Controllers\admin\ProductCharacteristicController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
use App\Http\Controllers\admin\ProductSubcategoryController;
use App\Http\Controllers\admin\SubcategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('products');
    Route::get('/products/show/{product}', 'show')->name('products.show');
});

Route::get('/about', function(){
    return view('about.index');
})->name('about');

Route::get('/payndelivery', function(){
    return view('payndelivery.index');
})->name('payndelivery');

Route::get('/contacts', function(){
    return view('contacts.index');
})->name('contacts');

Route::controller(CartController::class)->group(function(){
    Route::get('/cart', 'index')->name('cart');
    Route::post('/cart/add', 'add')->name('cart.add');
    Route::post('/cart/remove', 'remove')->name('cart.remove');
    Route::post('/cart/destroy', 'destroy')->name('cart.destroy');
    Route::post('/cart/order', 'doOrder')->name('cart.order');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users/auth', function(){
        return view('login.login');
    })->name('users.auth');
    Route::get('/users/register', 'create')->name('users.create');
    Route::get('/users/logout', 'logout')->name('users.logout');
    Route::patch('/users/update/{user}', 'update')->name('users.update');
    Route::post('/users/store', 'store')->name('users.store');
    Route::post('/users/login', 'login')->name('users.login');
});

Route::controller(OrderController::class)->group(function () {
    Route::get('/orders', 'index')->name('orders');
    Route::delete('/orders/delete/{order}', 'destroy')->name('orders.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::get('/logout', 'logout')->name('logout');
        Route::post('/auth', 'login')->name('auth');
    });
    Route::middleware('can:admin')->group(function (){
        Route::get('/', function(){
            return view('admin.index');
        })->name('main');
        Route::controller(AdminOrderController::class)->group(function () {
            Route::get('/orders', 'index')->name('orders');
            Route::get('/orders/edit/{order}', 'edit')->name('orders.edit');
            Route::get('/orders/show/{order}', 'show')->name('orders.show');
            Route::patch('/orders/update/{order}', 'update')->name('orders.update');
            Route::delete('/orders/destroy/{order}', 'destroy')->name('orders.destroy');
        });
        Route::controller(AdminBrandController::class)->group(function () {
            Route::get('/brands', 'index')->name('brands');
            Route::get('/brands/create', 'create')->name('brands.create');
            Route::post('/brands/store', 'store')->name('brands.store');
            Route::get('/brands/edit/{brand}', 'edit')->name('brands.edit');
            Route::patch('/brands/update/{product}', 'update')->name('brands.update');
            Route::delete('/brands/destroy/{product}', 'destroy')->name('brands.destroy');
        });
        Route::controller(ModelController::class)->group(function () {
            Route::get('/models', 'index')->name('models');
            Route::get('/models/create', 'create')->name('models.create');
            Route::post('/models/store', 'store')->name('models.store');
            Route::get('/models/edit/{model}', 'edit')->name('models.edit');
            Route::post('/models/showModels', 'showModelsByBrand')->name('models.showModelsByBrand');
            Route::patch('/models/update/{model}', 'update')->name('models.update');
            Route::delete('/models/destroy/{model}', 'destroy')->name('models.destroy');
        });
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories', 'index')->name('categories');
            Route::get('/categories/create' , 'create')->name('categories.create');
            Route::post('/categories/store', 'store')->name('categories.store');
            Route::get('/categories/edit/{category}', 'edit')->name('categories.edit');
            Route::get('/categories/show/{category}', 'show')->name('categories.show');
            Route::patch('/categories/update/{category}', 'update')->name('categories.update');
            Route::delete('/categories/destroy/{category}', 'destroy')->name('categories.destroy');
        });
        Route::controller(CountryController::class)->group(function(){
            Route::get('/countires', 'index')->name('countries');
            Route::get('/countries/create', 'create')->name('countries.create');
            Route::post('/countries/store', 'store')->name('countries.store');
            Route::get('/countries/edit/{country}', 'edit')->name('countries.edit');
            Route::patch('/countries/update/{country}', 'update')->name('countries.update');
            Route::delete('/countries/destroy/{country}', 'destroy')->name('countries.destroy');
        });
        Route::controller(CharacteristicController::class)->group(function(){
            Route::get('/characteristics', 'index')->name('characteristics');
            Route::get('/characteristics/create', 'create')->name('characteristics.create');
            Route::post('/characteristics/store', 'store')->name('characteristics.store');
            Route::get('/characteristics/edit/{characteristic}', 'edit')->name('characteristics.edit');
            Route::post('/characteristics/getAllCharacters', 'getAllCharacters')->name('characteristics.getAllCharacters');
            Route::patch('/characteristics/update/{characteristic}', 'update')->name('characteristics.update');
            Route::delete('/characteristics/destroy/{characteristic}', 'destroy')->name('characteristics.destroy');
        });
        Route::controller(SubcategoryController::class)->group(function(){
            Route::get('/subcategories', 'index')->name('subcategories');
            Route::get('/subcategories/create', 'create')->name('subcategories.create');
            Route::post('/subcategories/store', 'store')->name('subcategories.store');
            Route::post('/subcategories/showSubcategories', 'showSubcategoriesByCategory')->name('subcategories.showSubcategoriesByCategory');
            Route::post('/subcategories/showProdSubcategs', 'showProdSubcategs')->name('subcategories.showProdSubcategs');
            Route::get('/subcategories/edit/{subcategory}', 'edit')->name('subcategories.edit');
            Route::get('/subcategories/show/{subcategory}', 'show')->name('subcategories.show');
            Route::patch('/subcategories/update/{subcategory}', 'update')->name('subcategories.update');
            Route::delete('/subcategories/destroy/{subcategory}', 'destroy')->name('subcategories.destroy');
        });
        Route::controller(ImageController::class)->group(function(){
            Route::get('/images/create', 'create')->name('images.create');
            Route::post('/images/store', 'store')->name('images.store');
            Route::delete('/images/destroy/{image}', 'destroy')->name('images.destroy');
        });
        Route::controller(AdminProductController::class)->group(function () {
            Route::get('/products', 'index')->name('products');
            Route::get('/products/create', 'create')->name('products.create');
            Route::get('/products/show/{product}', 'show')->name('products.show');
            Route::post('/products/store', 'store')->name('products.store');
            Route::get('/products/edit/{product}', 'edit')->name('products.edit');
            Route::patch('/products/update/{product}', 'update')->name('products.update');
            Route::delete('/products/destroy/{product}', 'destroy')->name('products.destroy');
        });
        Route::controller(ProductSubcategoryController::class)->group(function(){
            Route::get('/product_subcategories', 'index')->name('product_subcategories');
            Route::get('/product_subcategories/create', 'create')->name('product_subcategories.create');
            Route::post('/product_subcategories/store', 'store')->name('product_subcategories.store');
            Route::post('/product_subcategories/changeCategory', 'changeCategory')->name('product_subcategories.changeCategory');
        });
        Route::controller(ProductCharacteristicController::class)->group(function(){
            Route::get('/product_characteristics', 'index')->name('product_characteristics');
            Route::get('/product_characteristics/create', 'create')->name('product_characteristics.create');
            Route::post('/product_characteristics/store', 'store')->name('product_characteristics.store');
        });
    });
});
