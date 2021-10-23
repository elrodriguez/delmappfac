<?php
Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_administracion_promociones'])->get('administration/promotions', function () {
    return view('onlineshop.admin.promotions');
})->name('onlineshop_administration_promotions');

Route::get('administration/promotions/list', [\App\Http\Controllers\OnlineShop\Admin\PromotionsController::class, 'list'])->name('onlineshop_administration_promotions_list');

Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_administracion_promociones_create'])->get('administration/promotions/create', function () {
    return view('onlineshop.admin.promotions_create');
})->name('onlineshop_administration_promotions_create');
Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_administracion_promociones_edit'])->get('administration/promotions/edit/{id}', function ($id) {
    return view('onlineshop.admin.promotions_edit')->with('id',$id);
})->name('onlineshop_administration_promotions_edit');

Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_administracion_promociones_delete'])->get('administration/promotions/delete/{id}', [\App\Http\Controllers\OnlineShop\Admin\PromotionsController::class, 'destroy'])->name('onlineshop_administration_promotions_delete');
Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_administracion_productos'])->get('administration/products', function () {
    return view('onlineshop.admin.products');
})->name('onlineshop_administration_products');
Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_administracion_promociones_items'])->get('administration/promotions/items/{id}', function ($id) {
    return view('onlineshop.admin.promotions_items')->with('id',$id);
})->name('onlineshop_administration_promotions_items');

Route::get('administration/products/list', [\App\Http\Controllers\OnlineShop\Admin\ItemsController::class, 'list'])->name('onlineshop_administration_products_list');
Route::post('administration/products/save', [\App\Http\Controllers\OnlineShop\Admin\ItemsController::class, 'saveItems'])->name('onlineshop_administration_products_save');

Route::get('administration/products/gallery/{id}', function ($id) {
    return view('onlineshop.admin.products_gallery')->with('id',$id);
})->name('onlineshop_administration_products_gallery');

Route::get('administration/products/items/search',[\App\Http\Controllers\OnlineShop\Admin\ItemsController::class, 'searchProducts'])->name('onlineshop_administration_promotions_items_search');

Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_administracion_configuraciones'])->get('administration/configurations', function () {
    return view('onlineshop.admin.configurations');
})->name('onlineshop_administration_configurations');

Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_atencion_mensajes'])->get('attention/customer_messages', function () {
    return view('onlineshop.admin.customer_messages');
})->name('onlineshop_attention_customer_messages');
Route::get('attention/read_message/{id}', function ($id) {
    return view('onlineshop.admin.read_message')->with('message_id',$id);
})->name('onlineshop_attention_read_message');
Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_atencion_mensajes_enviados'])->get('attention/sent_messages', function () {
    return view('onlineshop.admin.sent_messages');
})->name('onlineshop_attention_sent_messages');
Route::middleware(['middleware' => 'role_or_permission:tienda_virtual_atencion_mensajes_papelera'])->get('attention/trash_messages', function () {
    return view('onlineshop.admin.trash_messages');
})->name('onlineshop_attention_trash_messages');