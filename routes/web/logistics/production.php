<?php

Route::middleware(['middleware' => 'role_or_permission:proyectos'])->get('projects', function () {
    return view('logistics.production.projects');
})->name('logistics_production_projects');
Route::get('projects/list', [\App\Http\Controllers\Logistics\Production\ProjectsController::class, 'list'])->name('logistics_production_projects_list');

Route::middleware(['middleware' => 'role_or_permission:proyectos_nuevo'])->get('projects/create', function () {
    return view('logistics.production.projects_create');
})->name('logistics_production_projects_create');
Route::post('projects/responsable', [\App\Http\Controllers\Logistics\Production\ProjectsController::class, 'responsable'])->name('logistics_production_projects_responsable');
Route::post('projects/client', [\App\Http\Controllers\Logistics\Production\ProjectsController::class, 'client'])->name('logistics_production_projects_client');
Route::middleware(['middleware' => 'role_or_permission:proyectos_editar'])->get('projects/edit/{id}', function ($id) {
    return view('logistics.production.projects_edit')->with('id',$id);
})->name('logistics_production_projects_edit');
Route::middleware(['middleware' => 'role_or_permission:projectos_etapas'])->get('projects/stages/{id}', function ($id) {
    return view('logistics.production.projects_stages')->with('id',$id);
})->name('logistics_production_projects_stages');
Route::middleware(['middleware' => 'role_or_permission:projectos_materiales'])->get('projects/materials/{id}', function ($id) {
    return view('logistics.production.projects_materials')->with('id',$id);
})->name('logistics_production_projects_material');
Route::post('projects/search/items', [\App\Http\Controllers\Logistics\Production\ProjectsController::class, 'searchItems'])->name('logistics_production_projects_search_items');
Route::post('projects/materials/quantity/update', [\App\Http\Controllers\Logistics\Production\ProjectsController::class, 'updateQuantityMaterial'])->name('logistics_production_projects_update_quantity');
Route::post('projects/materials/price/update', [\App\Http\Controllers\Logistics\Production\ProjectsController::class, 'updatePriceMaterial'])->name('logistics_production_projects_update_price');
Route::middleware(['middleware' => 'role_or_permission:projectos_empleados'])->get('projects/employees/{id}', function ($id) {
    return view('logistics.production.projects_employees')->with('id',$id);
})->name('logistics_production_projects_employees');
Route::middleware(['middleware' => 'role_or_permission:proyectos_otros_gastos'])->get('projects/other_expenses/{id}', function ($id) {
    return view('logistics.production.projects_other_expenses')->with('id',$id);
})->name('logistics_production_projects_other_expenses');
Route::middleware(['middleware' => 'role_or_permission:proyectos_otros_gastos'])->get('projects/other_expenses/create/{id}', function ($id) {
    return view('logistics.production.projects_other_expenses_create')->with('project_id',$id);
})->name('logistics_production_projects_other_expenses_create');
Route::post('projects/search/supplier', [\App\Http\Controllers\Logistics\Production\ProjectsController::class, 'searchSupplier'])->name('logistics_production_projects_supplier');
