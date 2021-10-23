<?php
Route::get('home', function () {
    return view('onlineshop.client.home');
})->name('onlineshop_public_home');
Route::get('contact', function () {
    return view('onlineshop.client.contact');
})->name('onlineshop_public_contact');
Route::get('register', function () {
    return view('onlineshop.client.register');
})->name('onlineshop_public_register');
Route::get('my_account', function () {
    return view('onlineshop.client.myaccount');
})->name('onlineshop_public_myaccount');
Route::get('product_details/{seourl}', function ($seourl) {
    return view('onlineshop.client.product_details')->with('seourl',$seourl);
})->name('onlineshop_public_product_details');

Route::get('products/{cat?}', function ($cat = null) {
    return view('onlineshop.client.products')->with('cat',$cat);
})->name('onlineshop_public_products');