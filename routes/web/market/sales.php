<?php
Route::middleware(['middleware' => 'role_or_permission:ventas_nuevo_comprobante'])->get('documents_create', function () {
    $exists = \App\Models\Master\Cash::where('user_id',auth()->user()->id)->where('state',true)->first();
    if($exists){
        return view('market.sales.document_create');
    }else{
        return redirect()->route('market_administration_cash');
    }
})->name('market_sales_document_create');

Route::post('products_search', [\App\Http\Controllers\Market\Sales\ProductsController::class, 'searchItems'])->name('market_sales_products_search');
Route::middleware(['middleware' => 'role_or_permission:ventas_lista_comprobantes'])->get('documents_list', function () {
    return view('market.sales.document_list');
})->name('market_sales_document_list');
Route::middleware(['middleware' => 'role_or_permission:market_ventas_documentos_nota'])->get('note/{id}', function ($id) {
    return view('market.sales.note')->with('external_id',$id);
})->name('market_sales_note');
Route::get('sale/search_customers',[\App\Http\Controllers\Market\Sales\CustomersController::class, 'searchCustomers'])->name('market_sales_customers_search');
