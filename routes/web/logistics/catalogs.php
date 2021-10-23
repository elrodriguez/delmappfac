<?php
use App\Http\Controllers\Logistics\Catalogs\ProductsController;
use App\Http\Controllers\Logistics\Catalogs\BrandsController;
use App\Http\Controllers\Logistics\Catalogs\CategoriesController;
use App\Http\Controllers\Logistics\Catalogs\ProvidersController;

Route::middleware(['middleware' => 'role_or_permission:productos'])->get('products', function () {
    return view('logistics.catalogs.products');
})->name('logistics_catalogs_products');

Route::get('products/list', [ProductsController::class, 'list'])->name('logistics_catalogs_products_list');
Route::middleware(['middleware' => 'role_or_permission:productos nuevo'])->get('products/create', function () {
    return view('logistics.catalogs.products_create');
})->name('logistics_catalogs_products_create');
Route::middleware(['middleware' => 'role_or_permission:productos_editar'])->get('products/edit/{id}', function ($id) {
    return view('logistics.catalogs.products_edit')->with('id',$id);
})->name('logistics_catalogs_products_edit');
Route::middleware(['middleware' => 'role_or_permission:productos'])->get('products/imports', function () {
    return view('logistics.catalogs.products_import_excel');
})->name('logistics_catalogs_products_imports');
Route::post('products/import', [ProductsController::class, 'import'])->name('logistics_catalogs_products_import');
Route::middleware(['middleware' => 'role_or_permission:productos_eliminar'])->get('products/delete/{id}', [ProductsController::class, 'destroy'])->name('logistics_catalogs_products_delete');
//Brands
Route::middleware(['middleware' => 'role_or_permission:marcas'])->get('brands', function () {
    return view('logistics.catalogs.brands');
})->name('logistics_catalogs_brands');
Route::get('brands/list', [BrandsController::class, 'list'])->name('logistics_catalogs_brands_list');
Route::middleware(['middleware' => 'role_or_permission:marcas_nuevo'])->get('brands/create', function () {
    return view('logistics.catalogs.brands_create');
})->name('logistics_catalogs_brands_create');
Route::middleware(['middleware' => 'role_or_permission:marcas_editar'])->get('brands/edit/{id}', function ($id) {
    return view('logistics.catalogs.brands_edit')->with('id',$id);
})->name('logistics_catalogs_brands_edit');
Route::middleware(['middleware' => 'role_or_permission:marcas_eliminar'])->get('brands/delete/{id}', [BrandsController::class, 'destroy'
])->name('logistics_catalogs_brands_delete');
//providers
Route::middleware(['middleware' => 'role_or_permission:proveedores'])->get('providers', function () {
    return view('logistics.catalogs.providers');
})->name('logistics_catalogs_providers');
Route::get('providers/list', [ProvidersController::class, 'list'])->name('logistics_catalogs_provider_list');
Route::middleware(['middleware' => 'role_or_permission:proveedores_nuevo'])->get('providers/create', function () {
    return view('logistics.catalogs.provider_created');
})->name('logistics_catalogs_provider_created');
Route::middleware(['middleware' => 'role_or_permission:proveedores_editar'])->get('providers/edit/{id}', function ($id) {
    return view('logistics.catalogs.provider_edit')->with('id',$id);
})->name('logistics_catalogs_provider_edit');
//category
Route::middleware(['middleware' => 'role_or_permission:logistic_catalogos_categorias'])->get('categories', function () {
    return view('logistics.catalogs.categories');
})->name('logistics_catalogs_categories');
Route::get('categories/list', [CategoriesController::class, 'list'])->name('logistics_catalogs_categories_list');
Route::middleware(['middleware' => 'role_or_permission:logistic_catalogos_categorias_nuevo'])->get('categories/create', function () {
    return view('logistics.catalogs.categories_create');
})->name('logistics_catalogs_categories_create');
Route::middleware(['middleware' => 'role_or_permission:logistic_catalogos_categorias_editar'])->get('categories/edit/{id}', function ($id) {
    return view('logistics.catalogs.categories_edit')->with('id',$id);
})->name('logistics_catalogs_categories_edit');
Route::middleware(['middleware' => 'role_or_permission:logistic_catalogos_categorias_eliminar'])->get('categories/delete/{id}', [CategoriesController::class, 'destroy'])->name('logistics_catalogs_categories_delete');