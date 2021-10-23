<?php
Route::middleware(['middleware' => 'role_or_permission:market_reportes_ventas_vendedor'])->get('sales_seller', function () {
    return view('market.reports.sales_seller');
})->name('market_reports_sales_seller');

Route::middleware(['middleware' => 'role_or_permission:market_reportes_productos_mas_vendidos'])->get('most_selled_products', function () {
    return view('market.reports.most_selled_products');
})->name('market_reports_most_selled_products');
Route::middleware(['middleware' => 'role_or_permission:market_reportes_ventas_por_productos'])->get('sales_by_products', function () {
    return view('market.reports.sales_products');
})->name('market_reports_sales_products');
