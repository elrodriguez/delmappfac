<?php
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_reportes_incidencias'])->get('incidents', function () {
    return view('support.reports.ticket_reports_incidents');
})->name('support_reports_ticket_incidents');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_reportes_resumenes_estados'])->get('state_summaries', function () {
    return view('support.reports.ticket_reports_state_summaries');
})->name('support_reports_ticket_state_summaries');

Route::post('state_summaries/excel',[\App\Http\Controllers\Support\Report\StateSummariesController::class, 'reportExcel'])->name('support_report_groups_ticket_status');
Route::post('incidents/excel',[\App\Http\Controllers\Support\Report\IncidentsController::class, 'reportExcel'])->name('support_report_incidents');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_reportes_ruta_ticket'])->get('ticket_path', function () {
    return view('support.reports.ticket_route');
})->name('support_reports_ticket_path');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_reportes_ticket_por_usuario'])->get('ticket_attended_user', function () {
    return view('support.reports.ticket_attended_user');
})->name('support_reports_ticket_attended_user');
Route::post('ticket_attended_user/excel',[\App\Http\Controllers\Support\Report\TicketAttendedUserController::class, 'reportExcel'])->name('support_report_ticket_attended_users');