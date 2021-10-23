<?php

Route::middleware(['middleware' => 'role_or_permission:market_administration_caja_chica'])->get('cash', function () {
    return view('market.administration.cash');
})->name('market_administration_cash');

Route::middleware(['middleware' => 'role_or_permission:market_administration_caja_chica_cerrar'])->get('cash/delete/{id}', [\App\Http\Controllers\Market\Administration\CashController::class, 'closeCash'])->name('market_administration_cash_close');
Route::get('cash/report/{id}', [\App\Http\Controllers\Market\Administration\CashController::class, 'report'])->name('market_administration_cash_report_pdf');
Route::get('cash/report_products/{id}', [\App\Http\Controllers\Market\Administration\CashController::class, 'report_products'])->name('market_administration_cash_report_products_pdf');
Route::get('cash/report_products_excel/{id}', [\App\Http\Controllers\Market\Administration\CashController::class, 'report_products_excel'])->name('market_administration_cash_reportproducts_excel_pdf');
