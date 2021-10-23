<?php
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_categorias'])->get('category', function () {
    return view('support.administration.category');
})->name('support_administration_category');
Route::get('category/list', [\App\Http\Controllers\Support\Administration\CategoryController::class, 'list'])->name('support_administration_category_list');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_categorias_nuevo'])->get('category/create', function () {
    return view('support.administration.category_create');
})->name('support_administration_category_create');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_categorias_editar'])->get('category/edit/{id}', function ($id) {
    return view('support.administration.category_edit')->with('id',$id);
})->name('support_administration_category_edit');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_categorias_eliminar'])->get('category/delete/{id}', [\App\Http\Controllers\Support\Administration\CategoryController::class, 'destroy'])->name('support_administration_category_delete');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_area_usuarios'])->get('area_users', function () {
    return view('support.administration.area_user');
})->name('support_administration_area_user');
Route::get('area_users/list', [\App\Http\Controllers\Support\Administration\ServiceAreaUsersController::class, 'list'])->name('support_administration_area_users_list');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_area_usuarios_nuevo'])->get('area_users/create', function () {
    return view('support.administration.area_user_create');
})->name('support_administration_area_user_create');

Route::post('area_users/search/users', [\App\Http\Controllers\Support\Administration\ServiceAreaUsersController::class, 'searchUser'])->name('support_administration_area_users_search_users');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_area_usuarios_eliminar'])->get('area_users/delete/{id}', [\App\Http\Controllers\Support\Administration\ServiceAreaUsersController::class, 'destroy'])->name('support_administration_area_users_delete');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_grupos'])->get('groups', function () {
    return view('support.administration.groups');
})->name('support_administration_groups');
Route::get('groups/list', [\App\Http\Controllers\Support\Administration\GroupsController::class, 'list'])->name('support_administration_groups_list');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_grupos_nuevo'])->get('groups/create', function () {
    return view('support.administration.groups_create');
})->name('support_administration_groups_create');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_grupos_editar'])->get('groups/edit/{id}', function ($id) {
    return view('support.administration.groups_edit')->with('id',$id);
})->name('support_administration_groups_edit');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_administracion_grupos_eliminar'])->get('groups/delete/{id}', [\App\Http\Controllers\Support\Administration\GroupsController::class, 'destroy'])->name('support_administration_groups_delete');
