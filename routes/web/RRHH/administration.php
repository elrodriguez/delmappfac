<?php

Route::middleware(['middleware' => 'role_or_permission:rrhh_administration_employees'])->get('employees', function () {
    return view('RRHH.administration.employee');
})->name('rrhh_administration_employees');
Route::middleware(['middleware' => 'role_or_permission:rrhh_administration_employees_create'])->get('employees/create', function () {
    return view('RRHH.administration.employee_create');
})->name('rrhh_administration_employees_create');
Route::get('employees/list', [\App\Http\Controllers\RRHH\Administration\EmployeesController::class, 'list'])->name('rrhh_administration_employees_list');
Route::middleware(['middleware' => 'role_or_permission:rrhh_administration_employees_editar'])->get('employees/edit/{id}', function ($id) {
    return view('RRHH.administration.employee_edit')->with('id',$id);
})->name('rrhh_administration_employees_edit');
Route::middleware(['middleware' => 'role_or_permission:rrhh_administration_employees_import_excel'])->get('employees/import/excel', function () {
    return view('RRHH.administration.employee_import_excel');
})->name('rrhh_administration_employees_import_excel');
Route::post('employees/import', [\App\Http\Controllers\RRHH\Administration\EmployeesController::class, 'import'])->name('rrhh_administration_employees_import');
Route::post('employees/search', [\App\Http\Controllers\RRHH\Administration\EmployeesController::class, 'searchEmployee'])->name('rrhh_administration_employees_search');
//concepts
Route::middleware(['middleware' => 'role_or_permission:rrhh_administration_concepts'])->get('concepts', function () {
    return view('RRHH.administration.concepts');
})->name('rrhh_administration_concepts');
Route::get('concepts/list', [\App\Http\Controllers\RRHH\Administration\ConceptsController::class, 'list'])->name('rrhh_administration_concepts_list');
Route::middleware(['middleware' => 'role_or_permission:rrhh_administration_concepts_create'])->get('concepts/create', function () {
    return view('RRHH.administration.concepts_create');
})->name('rrhh_administration_concepts_create');
Route::middleware(['middleware' => 'role_or_permission:rrhh_administration_concepts_edit'])->get('concepts/edit/{id}', function ($id) {
    return view('RRHH.administration.concepts_edit')->with('id',$id);
})->name('rrhh_administration_concepts_edit');
Route::middleware(['middleware' => 'role_or_permission:rrhh_administration_concepts_delete'])->get('concepts/delete/{id}', [\App\Http\Controllers\RRHH\Administration\ConceptsController::class, 'destroy'
])->name('rrhh_administration_concepts_delete');