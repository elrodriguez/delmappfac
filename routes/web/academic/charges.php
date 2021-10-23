<?php
use App\Http\Controllers\Academic\Charges\ChargesDownloadController;

Route::middleware(['middleware' => 'role_or_permission:academico_nuevo_comprobante'])->get('new_document', function () {
    $exists = \App\Models\Master\Cash::where('user_id',auth()->user()->id)->where('state',true)->first();
    if($exists){
        return view('academic.charges.new_document');
    }else{
        return redirect()->route('market_administration_cash');
    }
})->name('charges_new_document');

Route::post('charges/new_document/search_customer', [\App\Http\Controllers\Academic\Charges\DocumentController::class, 'searchCustomers'])->name('academic_search_customer');

Route::get('print/{model}/{external_id}/{format?}', [ChargesDownloadController::class, 'toPrintInvoice']);

Route::middleware(['middleware' => 'role_or_permission:academico_listado_comprobante'])->get('list_document', function () {
    return view('academic.charges.list_document');
})->name('charges_list_document');
