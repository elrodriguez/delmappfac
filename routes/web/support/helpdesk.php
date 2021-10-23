<?php

use App\Models\Support\Administration\SupServiceAreaUser;
use Illuminate\Support\Facades\Auth;

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket'])->get('ticket', function () {

    $user_area = SupServiceAreaUser::where('user_id',Auth::id())->first();
    if($user_area){
        return view('support.helpdesk.ticket');
    }else{
        $msg = 'msg_error_area_null';
        return view('error')->with('msg',$msg);
    }

})->name('support_helpdesk_ticket');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket_nuevo'])->get('ticket/create', function () {
    return view('support.helpdesk.ticket_create');
})->name('support_helpdesk_ticket_create');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket_atender'])->get('ticket/attend/{id}', function ($id) {
    return view('support.helpdesk.ticket_attend')->with('id',$id);
})->name('support_helpdesk_ticket_attend');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket'])->get('tickets/attended', function () {
    return view('support.helpdesk.my_tickets_attended');
})->name('support_helpdesk_my_tickets_attended');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket_ver'])->get('tickets/attended/{id}', function ($id) {
    return view('support.helpdesk.my_tickets_attended_details')->with('id',$id);
})->name('support_helpdesk_my_ticket_attended_see');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket_applicant'])->get('tickets_applicant', function () {
    return view('support.helpdesk.ticket_applicant');
})->name('support_helpdesk_ticket_applicant');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket_applicant_nuevo'])->get('tickets_applicant/create', function () {
    return view('support.helpdesk.ticket_applicant_create');
})->name('support_helpdesk_ticket_applicant_create');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket_applicant_seguir'])->get('tickets_applicant/tracing/{id}', function ($id) {
    return view('support.helpdesk.ticket_applicant_tracing')->with('id',$id);
})->name('support_helpdesk_ticket_applicant_tracing');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket_applicant_eliminar'])->get('tickets_applicant/delete/{id}', [\App\Http\Controllers\Support\Helpdesk\TicketController::class, 'destroy'])->name('support_helpdesk_ticket_applicant_delete');

Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket_registrados'])->get('tickets/registered', function () {
    return view('support.helpdesk.my_tickets_registered');
})->name('support_helpdesk_my_tickets_registered');
Route::middleware(['middleware' => 'role_or_permission:soporte_tecnico_helpdesk_ticket_registrados_editar'])->get('tickets/registered/edit/{id}', function ($id) {
    return view('support.helpdesk.my_tickets_registered_edit')->with('id',$id);
})->name('support_helpdesk_my_tickets_registered_edit');

Route::post('tickets/version_sicmact/edit', [\App\Http\Controllers\Support\Helpdesk\TicketController::class, 'versionSicmactUpdate'])->name('support_helpdesk_ticket_version_sicmact_update');
