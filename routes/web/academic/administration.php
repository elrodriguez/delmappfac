<?php
use App\Http\Controllers\Academic\Administration\PostulantController;
use App\Http\Controllers\Academic\Administration\ProductServicesController;
use App\Http\Controllers\Academic\Administration\StudentsController;
use App\Http\Controllers\Academic\Administration\TeachersController;
use App\Http\Controllers\Academic\Administration\CoursesController;
use App\Http\Controllers\Academic\Administration\CurriculaController;
use App\Http\Controllers\Academic\Administration\DiscountController;
use App\Http\Controllers\Academic\Administration\PackagesController;
use App\Http\Controllers\Academic\Administration\SeasonsController;

Route::middleware(['middleware' => 'role_or_permission:academico_curricula'])->get('curriculas', function () {
    return view('academic.administration.curricula');
})->name('academic_curriculas');
Route::middleware(['middleware' => 'role_or_permission:academico_curricula'])->get('curriculas/list', [CurriculaController::class, 'list'])->name('academic_curriculas_list');
Route::middleware(['middleware' => 'role_or_permission:academico_curricula_nuevo'])->get('curriculas/create', function () {
    return view('academic.administration.curricula_create');
})->name('academic_curricula_create');
Route::middleware(['middleware' => 'role_or_permission:academico_curricula_editar'])->get('curriculas/edit/{id}', function ($id) {
    return view('academic.administration.curricula_edit')->with('id',$id);
})->name('academic_curricula_edit');
Route::middleware(['middleware' => 'role_or_permission:academico_temporadas'])->get('seasons', function () {
    return view('academic.administration.seasons');
})->name('academic_seasons');
Route::middleware(['middleware' => 'role_or_permission:academico_temporadas'])->get('seasons/list', [SeasonsController::class, 'list'])->name('academic_seasons_list');
Route::middleware(['middleware' => 'role_or_permission:academico_temporadas_nuevo'])->get('seasons/create', function () {
    return view('academic.administration.seasons_create');
})->name('academic_seasons_create');
Route::middleware(['middleware' => 'role_or_permission:academico_temporadas_editar'])->get('seasons/edit/{id}', function ($id) {
    return view('academic.administration.seasons_edit')->with('id',$id);
})->name('academic_seasons_edit');

Route::middleware(['middleware' => 'role_or_permission:Cursos'])->get('courses', function () {
    return view('academic.administration.courses');
})->name('academic_courses');
Route::get('courses/list', [CoursesController::class, 'list'])->name('academic_courses_list');
Route::middleware(['middleware' => 'role_or_permission:Cursos Nuevo'])->get('courses/create', function () {
    return view('academic.administration.courses_create');
})->name('academic_courses_create');
Route::middleware(['middleware' => 'role_or_permission:Cursos Editar'])->get('courses/edit/{id}', function ($id) {
    return view('academic.administration.courses_edit')->with('id',$id);
})->name('academic_courses_edit');
Route::middleware(['middleware' => 'role_or_permission:Cursos Eliminar'])->get('courses/delete/{id}', [CoursesController::class, 'destroy'])->name('academic_courses_delete');
Route::middleware(['middleware' => 'role_or_permission:Curso año grado y seccion'])->get('administration/courses/academic_charges/{id}', function ($id) {
    return view('academic.administration.academic_charges')->with('id',$id);
})->name('academic_courses_academic_charges');

Route::middleware(['middleware' => 'role_or_permission:Docente'])->get('teachers', function () {
    return view('academic.administration.teachers');
})->name('academic_teachers');
Route::get('teachers/list', [TeachersController::class, 'list'])->name('academic_teachers_list');
Route::middleware(['middleware' => 'role_or_permission:Docente Nuevo'])->get('teachers/create', function () {
    return view('academic.administration.teachers_create');
})->name('academic_teachers_create');
Route::middleware(['middleware' => 'role_or_permission:Docente Editar'])->get('teachers/edit/{id}', function ($id) {
    return view('academic.administration.teachers_edit')->with('id',$id);
})->name('academic_teachers_edit');
Route::middleware(['middleware' => 'role_or_permission:Docente Eliminar'])->get('teachers/delete/{id}', [TeachersController::class, 'destroy'])->name('academic_teachers_delete');
Route::middleware(['middleware' => 'role_or_permission:Docente Asignar Cursos'])->get('teachers/assign/courses/{id}', function ($id) {
    return view('academic.administration.teacher_courses')->with('id',$id);
})->name('academic_teachers_courses');

Route::middleware(['middleware' => 'role_or_permission:Docente Asignar Cursos'])->get('teachers/assign/courses_free/{id}', function ($id) {
    return view('academic.administration.teacher_courses_free')->with('id',$id);
})->name('academic_teachers_courses_free');

Route::middleware(['middleware' => 'role_or_permission:Postulante'])->get('postulants', function () {
    return view('academic.administration.postulants');
})->name('postulants');

Route::middleware(['middleware' => 'role_or_permission:alumnos'])->get('students', function () {
    return view('academic.administration.students');
})->name('academic_students');
Route::get('administration/students/list', [StudentsController::class, 'list'])->name('academic_students_list');
Route::middleware(['middleware' => 'role_or_permission:alumnos nuevo'])->get('students/create', function () {
    return view('academic.administration.students_create');
})->name('academic_students_create');
Route::middleware(['middleware' => 'role_or_permission:alumnos editar'])->get('students/edit/{id}', function ($id) {
    return view('academic.administration.students_edit')->with('id',$id);
})->name('academic_students_edit');
Route::middleware(['middleware' => 'role_or_permission:alumnos eliminar'])->get('students/delete/{id}', [StudentsController::class, 'destroy'])->name('academic_students_delete');
Route::middleware(['middleware' => 'role_or_permission:apoderado'])->get('students/representative/{person_id}/{student_id}', function ($person_id,$student_id) {
    return view('academic.administration.students_representative')->with('person_id',$person_id)->with('student_id',$student_id);
})->name('academic_students_representative');
Route::post('students/representative/search_people', [StudentsController::class, 'searchPeople'])->name('students_search_people');

Route::middleware(['middleware' => 'role_or_permission:servicios_academico'])->get('products_services', function () {
    return view('academic.administration.product_service');
})->name('academic_products_and_services');
Route::get('product_service/list', [ProductServicesController::class, 'list'])->name('academic_products_and_services_list');
Route::middleware(['middleware' => 'role_or_permission:servicios_academico_nuevo'])->get('products_services/create', function () {
    return view('academic.administration.product_service_create');
})->name('academic_products_and_services_create');
Route::middleware(['middleware' => 'role_or_permission:servicios_academico_editar'])->get('products_services/edit/{id}', function ($id) {
    return view('academic.administration.product_service_edit')->with('id',$id);
})->name('academic_products_and_services_edit');

Route::middleware(['middleware' => 'role_or_permission:descuento_academico'])->get('discounts', function () {
    return view('academic.administration.discounts');
})->name('academic_discounts');
Route::get('discounts/list', [DiscountController::class, 'list'])->name('academic_discounts_list');
Route::middleware(['middleware' => 'role_or_permission:descuento_academico_nuevo'])->get('discounts/create', function () {
    return view('academic.administration.discounts_create');
})->name('academic_discounts_create');
Route::middleware(['middleware' => 'role_or_permission:descuento_academico_editar'])->get('discounts/edit/{id}', function ($id) {
    return view('academic.administration.discounts_edit')->with('id',$id);
})->name('academic_discounts_edit');
Route::middleware(['middleware' => 'role_or_permission:descuento_academico_eliminar'])->get('discounts/delete/{id}', [DiscountController::class, 'destroy'])->name('academic_discounts_delete');

Route::middleware(['middleware' => 'role_or_permission:Paquete_compromisos_promociones'])->get('packages', function () {
    return view('academic.administration.packages');
})->name('academic_packages');
Route::get('packages/list', [PackagesController::class, 'list'])->name('academic_packages_list');
Route::middleware(['middleware' => 'role_or_permission:pcp_nuevo'])->get('packages/create', function () {
    return view('academic.administration.packages_create');
})->name('academic_packages_create');
Route::middleware(['middleware' => 'role_or_permission:pcp_editar'])->get('packages/edit/{id}', function ($id) {
    return view('academic.administration.packages_edit')->with('id',$id);
})->name('academic_packages_edit');
Route::middleware(['middleware' => 'role_or_permission:pcp_eliminar'])->get('packages/delete/{id}', [PackagesController::class, 'destroy'])->name('academic_packages_delete');
Route::middleware(['middleware' => 'role_or_permission:pcp_agregar_items'])->get('packages/add_items/{id}', function ($id) {
    return view('academic.administration.packages_add_items')->with('id',$id);
})->name('academic_add_items_edit');

Route::get('postulants/list', [PostulantController::class, 'list'])->name('postulants_list');

Route::middleware(['middleware' => 'role_or_permission:Postulante nuevo'])->get('postulants_create', function () {
    return view('academic.administration.postulants_create');
})->name('postulants_create');

Route::middleware(['middleware' => 'role_or_permission:importar_alumnos_excel'])->get('students/import/excel', function () {
    return view('academic.administration.students_import_excel');
})->name('academic_importar_alumnos_excel');
Route::post('students/import', [StudentsController::class, 'import'])->name('academic_administration_students_import');
