<?php
use App\Http\Controllers\Academic\Enrollment\CadastresController;

Route::middleware(['middleware' => 'role_or_permission:matricula_registrar'])->get('register', function () {
    return view('academic.enrollment.enrollment_register');
})->name('enrollment_register');
Route::middleware(['middleware' => 'role_or_permission:Lista_matriculados'])->get('list', function () {
    return view('academic.enrollment.enrollment_register_list');
})->name('enrollment_register_list');
Route::get('cadastres/list/school', [CadastresController::class, 'list'])->name('enrollment_cadastre_list');

Route::middleware(['middleware' => 'role_or_permission:Lista_matriculados'])->get('list_courses', function () {
    return view('academic.enrollment.enrollment_register_list_courses');
})->name('enrollment_register_list_courses');

Route::get('cadastres/list/courses', [CadastresController::class, 'listCadastresCourses'])->name('enrollment_cadastre_list_courses');
