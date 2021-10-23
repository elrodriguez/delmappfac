<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
/*
Route::group(['middleware' => ['auth:sanctum', 'verified','role:SuperAdmin']], function () {
    Route::get('master/users/list', [UserController::class, 'usersList']);
    Route::middleware(['middleware' => 'role_or_permission:permisos'])->get('master/users/delete/{id}', [UserController::class, 'destroy']);

    Route::get('master/roles/list', [RolesController::class, 'list']);
    Route::middleware(['middleware' => 'role_or_permission:permisos'])->get('master/roles/delete/{id}', [RolesController::class, 'destroy']);
});
*/
