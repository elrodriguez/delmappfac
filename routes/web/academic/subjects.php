<?php
use App\Http\Controllers\Academic\Subjects\SubCourseTopicsController;
use App\Http\Controllers\Academic\Subjects\SubStudentTestController;

Route::middleware(['middleware' => 'role_or_permission:Listar_cursos_docente'])->get('courses', function () {
    return view('academic.subjects.courses_teacher');
})->name('subjects_courses_teacher');
Route::middleware(['middleware' => 'role_or_permission:temas_del_curso'])->get('courses/topic/{id}/{ct}', function ($id,$ct) {
    return view('academic.subjects.courses_topics')->with('id',$id)->with('ct',$ct);
})->name('subjects_courses_themes');
Route::post('courses/topics/update', [SubCourseTopicsController::class, 'update'])->name('subjects_courses_topics_update');
Route::get('courses/upload/file/ckfinder', function () {
    return view('vendor.ckfinder.browser');
})->name('subjects_courses_upload_ckfinder');
Route::get('courses/topic/class/content/{course}/{topic}/{activity}', function ($course,$topic,$activity) {
    return view('academic.subjects.activity_content_edit')->with('course',$course)->with('topic',$topic)->with('activity',$activity);
})->name('subjects_courses_topic_activity_edit');
Route::get('courses/topics/delete/{id}', [SubCourseTopicsController::class, 'deleteTopic']);
Route::get('courses/topic/class/forum/{course}/{topic}/{activity}', function ($course,$topic,$activity) {
    return view('academic.subjects.activity_forum_edit')->with('course',$course)->with('topic',$topic)->with('activity',$activity);
})->name('subjects_courses_topic_forum_edit');
Route::get('courses/topic/class/forum/comment/edit/{course}/{topic}/{activity}/{comment}', function ($course,$topic,$activity,$comment) {
    return view('academic.subjects.activity_comment_edit')->with('course',$course)->with('topic',$topic)->with('activity',$activity)->with('comment',$comment);
})->name('subjects_courses_topic_class_activity_comment_edit');
Route::get('courses/topics/class/delete/{id}', [SubCourseTopicsController::class, 'deleteClass']);
Route::get('courses/topic/class/question/{course}/{topic}/{activity}', function ($course,$topic,$activity) {
    return view('academic.subjects.activity_question_edit')->with('course',$course)->with('topic',$topic)->with('activity',$activity);
})->name('subjects_courses_topic_question_edit');
Route::get('courses/topic/class/homework/{course}/{topic}/{activity}', function ($course,$topic,$activity) {
    return view('academic.subjects.activity_homework_edit')->with('course',$course)->with('topic',$topic)->with('activity',$activity);
})->name('subjects_courses_topic_homework_edit');
Route::get('courses/topic/class/test/{course}/{topic}/{activity}', function ($course,$topic,$activity) {
    return view('academic.subjects.activity_test')->with('course',$course)->with('topic',$topic)->with('activity',$activity);
})->name('subjects_courses_topic_test');
Route::get('courses/topic/class/test/question/{course}/{topic}/{activity}/{question?}', function ($course,$topic,$activity,$question=null) {
    return view('academic.subjects.activity_test_question')->with('course',$course)->with('topic',$topic)->with('activity',$activity)->with('question',$question);
})->name('subjects_courses_topic_test_question');
Route::post('courses/topics/class/activity/test/enswers/update', [SubCourseTopicsController::class, 'updateAnswers'])->name('subjects_courses_topics_test_enswers_update');
Route::post('courses/topics/class/activity/test/update/student', [SubStudentTestController::class, 'update'])->name('subjects_courses_topics_test_update_student');
Route::post('courses/topics/class/activity/test/enswers/update/student', [SubStudentTestController::class, 'updateAnswer'])->name('subjects_courses_topics_test_enswer_update_student');
Route::middleware(['middleware' => 'role_or_permission:listado_alumno_del_curso'])->get('courses/notes/{id}/{ct}', function ($id,$ct) {
    return view('academic.subjects.courses_students')->with('id',$id)->with('ct',$ct);
})->name('subjects_courses_students');

Route::post('courses/topics/class/activity/homework/points/update', [\App\Http\Controllers\Academic\Subjects\ActivityHomeworkController::class, 'homeworkUpdatePoints'])->name('subjects_courses_topics_homework_points_update');

Route::get('courses/topic/class/test/correct/{course}/{topic}/{activity}', function ($course,$topic,$activity) {
    return view('academic.subjects.activity_test_correct')->with('course',$course)->with('topic',$topic)->with('activity',$activity);
})->name('subjects_courses_activity_test_correct');

Route::middleware(['middleware' => 'role_or_permission:listado_alumno_del_curso'])->get('courses/assistance/{id}/{ct}', function ($id,$ct) {
    return view('academic.subjects.courses_students_assistance')->with('id',$id)->with('ct',$ct);
})->name('subjects_courses_students_assistance');

Route::middleware(['middleware' => 'role_or_permission:listado_alumno_del_capacitacion_asistencia'])->get('assistance', function () {
    return view('academic.subjects.courses_training_students_assistance');
})->name('subjects_training_students_assistance');

///////rutas alumno/////////
Route::middleware(['middleware' => 'role_or_permission:mis_cursos'])->get('mycourses', function () {
    return view('academic.subjects.student_mycourses');
})->name('subjects_student_my_courses');
Route::middleware(['middleware' => 'role_or_permission:mis_cursos_temas'])->get('mycourses/topic/{cu}/{mt}', function ($cu,$mt) {
    return view('academic.subjects.student_mycourses_topics')->with('cu',$cu)->with('mt',$mt);
})->name('subjects_student_mycourse_themes');
Route::get('mycourses/topic/exam/{cu}/{mt}/{code}', function ($cu,$mt,$code) {
    return view('academic.subjects.student_mycourses_exam')->with('cu',$cu)->with('mt',$mt)->with('code',$code);
})->name('subjects_student_mycourse_themes_exam');
Route::get('mycourses/topic/forum/{cu}/{mt}/{code}', function ($cu,$mt,$code) {
    return view('academic.subjects.student_mycourses_forum')->with('cu',$cu)->with('mt',$mt)->with('code',$code);
})->name('subjects_student_mycourse_themes_forum');
Route::get('mycourses/topic/forum/comment/{cu}/{mt}/{code}/{comment}', function ($cu,$mt,$code,$comment) {
    return view('academic.subjects.student_mycourses_comment_edit')->with('cu',$cu)->with('mt',$mt)->with('code',$code)->with('comment_id',$comment);
})->name('subjects_student_mycourse_themes_forum_comment_edit');
Route::get('mycourses/topic/question/{cu}/{mt}/{code}', function ($cu,$mt,$code) {
    return view('academic.subjects.student_mycourses_question')->with('cu',$cu)->with('mt',$mt)->with('code',$code);
})->name('subjects_student_mycourse_themes_question');
Route::get('mycourses/topic/homework/{cu}/{mt}/{code}', function ($cu,$mt,$code) {
    return view('academic.subjects.student_mycourses_homework')->with('cu',$cu)->with('mt',$mt)->with('code',$code);
})->name('subjects_student_mycourse_themes_homework');
Route::post('mycourses/topic/homework/store', [\App\Http\Controllers\Academic\Subjects\ActivityHomeworkController::class, 'storeHomeworkStuden'])->name('academic_subjects_student_homework_store');

Route::get('courses/topic/class/video/{course}/{topic}/{activity}', function ($course,$topic,$activity_id) {
    $activity = \App\Models\Academic\Subjects\ClassActivity::where('id',$activity_id)->first();
    return view('academic.subjects.activity_video_edit')->with('course',$course)->with('topic',$topic)->with('activity',$activity);
})->name('subjects_courses_topic_video_edit');

Route::post('courses/topic/class/video/vimeo/store', [\App\Http\Controllers\Academic\Subjects\VideoUploadController::class, 'vimeo'])->name('academic_subjects_student_video_vimeo_store');

Route::get('courses/topic/class/file/{course}/{topic}/{activity}', function ($course,$topic,$activity_id) {
    $activity = \App\Models\Academic\Subjects\ClassActivity::where('id',$activity_id)->first();
    return view('academic.subjects.activity_file_edit')->with('course',$course)->with('topic',$topic)->with('activity',$activity);
})->name('subjects_courses_topic_file_edit');

Route::post('courses/topic/class/file/dropbox/upload', [\App\Http\Controllers\Academic\Subjects\FileDropBoxController::class, 'upload'])->name('academic_subjects_student_file_dropbox_store');

Route::get('courses/topic/class/file2/dropbox/download/{id}', [\App\Http\Controllers\Academic\Subjects\FileDropBoxController::class, 'download'])->name('academic_subjects_student_file_dropbox_download');