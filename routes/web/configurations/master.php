<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Master\EstablishmentController;
use App\Http\Controllers\Master\CustomersController;
use App\Http\Controllers\Master\SeriesController;

Route::middleware(['middleware' => 'role_or_permission:usuarios'])->get('users', function () {
    return view('master.users');
})->name('users');

Route::middleware(['middleware' => 'role_or_permission:actividades_usuario_log'])->get('users_activity_log', function () {
    return view('master.users_activity_log');
})->name('users_activity_log');

Route::get('users_activity_log/list', [UserController::class, 'usersListActivityLog'])->name('users_activity_log_list');

Route::get('users_activity_log/details/{id}', function ($id) {
    return view('master.users_activity_log_details')->with('id',$id);
})->name('users_activity_log_details');

Route::middleware(['middleware' => 'role_or_permission:actividades_usuario_log'])->get('users_activity_log', function () {
    return view('master.users_activity_log');
})->name('users_activity_log');

Route::middleware(['middleware' => 'role_or_permission:nuevo usuario'])->get('user_created', function () {
    return view('master.users_created');
})->name('user_created');

Route::middleware(['middleware' => 'role_or_permission:editar usuario'])->get('user_edit/{id}', function ($id) {
    return view('master.users_edit')->with('id',$id);
})->name('user_edit');

Route::middleware(['middleware' => 'role_or_permission:asignar rol'])->get('user_roles/{id}', function ($id) {
    return view('master.users_roles')->with('id',$id);
})->name('user_roles');

Route::middleware(['middleware' => 'role_or_permission:roles'])->get('roles', function () {
    return view('master.roles');
})->name('roles');

Route::middleware(['middleware' => 'role_or_permission:nuevo rol'])->get('roles_create', function () {
    return view('master.roles_created');
})->name('roles_create');

Route::middleware(['middleware' => 'role_or_permission:editar rol'])->get('role_edit/{id}', function ($id) {
    return view('master.roles_edit')->with('id',$id);
})->name('role_edit');

Route::middleware(['middleware' => 'role_or_permission:permisos'])->get('permission_roles/{id}', function ($id) {
    return view('master.roles_permission')->with('id',$id);
})->name('permission_roles');

Route::get('users/list', [UserController::class, 'usersList'])->name('users_list');
Route::middleware(['middleware' => 'role_or_permission:eliminar usuario'])->get('users/delete/{id}', [UserController::class, 'destroy'])->name('users_delete');

Route::get('roles/list', [RolesController::class, 'list'])->name('roles_list');
Route::middleware(['middleware' => 'role_or_permission:eliminar rol'])->get('roles/delete/{id}', [RolesController::class, 'destroy'])->name('roles_delete');

Route::middleware(['middleware' => 'role_or_permission:establecimientos'])->get('establishments', function () {
    $parameter = \App\Models\Master\Parameter::where('id_parameter','PRT0001GN')->first();
    return view('master.establishment')->with('PRT0001GN',$parameter->value_default);
})->name('establishments');

Route::middleware(['middleware' => 'role_or_permission:Mesas'])->get('establishment_tables/{id}', function ($id) {
    return view('master.establishment_tables')->with('id',$id);
})->name('establishment_tables');

Route::get('establishment/list', [EstablishmentController::class, 'list'])->name('establishment_list');

Route::middleware(['middleware' => 'role_or_permission:nuevo establecimiento'])->get('establishments_create', function () {
    return view('master.establishments_created');
})->name('establishments_create');

Route::middleware(['middleware' => 'role_or_permission:eliminar establecimiento'])->get('establishment/delete/{id}', [EstablishmentController::class, 'destroy'])->name('establishment_delete');

Route::middleware(['middleware' => 'role_or_permission:editar establecimiento'])->get('establishments_edit/{id}', function ($id) {
    return view('master.establishments_edit')->with('id',$id);
})->name('establishments_edit');

Route::middleware(['middleware' => 'role_or_permission:maestros_establecimiento_series'])->get('establishments_series/{id}', function ($id) {
    return view('master.establishment_series')->with('id',$id);
})->name('establishments_series');
Route::post('establishment/series/list', [SeriesController::class, 'list'])->name('establishment_series_list');
Route::middleware(['middleware' => 'role_or_permission:maestros_establecimiento_series'])->get('establishments_series/create/{id}', function ($id) {
    return view('master.establishment_series_create')->with('id',$id);
})->name('establishments_series_create');
Route::middleware(['middleware' => 'role_or_permission:maestros_establecimiento_series'])->get('establishments_series/edit/{id}/{serie_id}', function ($id,$serie_id) {
    return view('master.establishment_series_edit')->with('id',$id)->with('serie_id',$serie_id);
})->name('establishments_series_edit');

//customers
Route::middleware(['middleware' => 'role_or_permission:clientes'])->get('customers', function () {
    return view('master.customers');
})->name('customers');

Route::middleware(['middleware' => 'role_or_permission:clientes nuevo'])->get('customers/create', function () {
    return view('master.customer_created');
})->name('customer_created');

Route::get('cutomers/list', [CustomersController::class, 'list'])->name('customer_list');

Route::middleware(['middleware' => 'role_or_permission:clientes editar'])->get('customers/edit/{id}', function ($id) {
    return view('master.customer_edit')->with('id',$id);
})->name('customer_edit');

Route::middleware(['middleware' => 'role_or_permission:configuracion_maestros_cuentas_bancarias'])->get('bank_account', function () {
    return view('master.bank_account');
})->name('configurations_master_bank_account');
Route::get('bank_account/list', [\App\Http\Controllers\Master\BankAccountController::class, 'list'])->name('configurations_master_bank_account_list');
Route::middleware(['middleware' => 'role_or_permission:configuracion_maestros_cuentas_bancarias_nuevo'])->get('bank_account/create', function () {
    return view('master.bank_account_create');
})->name('configurations_master_bank_account_create');
Route::middleware(['middleware' => 'role_or_permission:configuracion_maestros_cuentas_bancarias_editar'])->get('bank_account/edit/{id}', function ($id) {
    return view('master.bank_account_edit')->with('id',$id);
})->name('configurations_master_bank_account_edit');
Route::middleware(['middleware' => 'role_or_permission:configuracion_maestros_cuentas_bancarias_eliminar'])->get('bank_account/delete/{id}', [\App\Http\Controllers\Master\BankAccountController::class, 'destroy'])->name('configurations_master_bank_account_delete');