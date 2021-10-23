<?php

Route::middleware(['middleware' => 'role_or_permission:rrhh_pagos_adelantos'])->get('advancements', function () {
    return view('RRHH.payments.advancements');
})->name('rrhh_payments_advancements');
Route::get('advancements/list', [\App\Http\Controllers\RRHH\Payments\EmployeeConceptsController::class, 'advancements'])->name('rrhh_payments_advancements_list');
Route::middleware(['middleware' => 'role_or_permission:rrhh_pagos_adelantos_nuevo'])->get('advancements/create', function () {
    return view('RRHH.payments.advancements_create');
})->name('rrhh_payments_advancements_create');
Route::middleware(['middleware' => 'role_or_permission:rrhh_pagos_adelantos_editar'])->get('advancements/edit/{id}', function ($id) {
    return view('RRHH.payments.advancements_edit')->with('id',$id);
})->name('rrhh_payments_advancements_edit');
Route::middleware(['middleware' => 'role_or_permission:rrhh_pagos_adelantos_eliminar'])->get('advancements/delete/{id}', [\App\Http\Controllers\RRHH\Payments\EmployeeConceptsController::class, 'advancementDelete'])->name('rrhh_payments_advancements_delete');
Route::middleware(['middleware' => 'role_or_permission:rrhh_boletas'])->get('tickts', function () {
    return view('RRHH.payments.ticket');
})->name('rrhh_payments_ticket');
Route::get('tickets/list', [\App\Http\Controllers\RRHH\Payments\ExpensesController::class, 'list'])->name('rrhh_payments_tickts_list');
Route::middleware(['middleware' => 'role_or_permission:rrhh_boletas_nuevo'])->get('tickts/create', function () {
    return view('RRHH.payments.ticket_create');
})->name('rrhh_payments_ticket_create');
Route::middleware(['middleware' => 'role_or_permission:rrhh_boletas_imprimir'])->get('print/{model}/{external_id}/{format?}', [\App\Http\Controllers\RRHH\Payments\ExpensesController::class, 'toPrint']);
Route::middleware(['middleware' => 'role_or_permission:rrhh_boletas_anular'])->get('tickets/cancel/{id}', [\App\Http\Controllers\RRHH\Payments\ExpensesController::class, 'cancelExpense'])->name('rrhh_payments_tickts_cancel');
