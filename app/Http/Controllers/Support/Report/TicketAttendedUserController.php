<?php

namespace App\Http\Controllers\Support\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\Support\Helpdesk\SupTicketRecord;
use App\Exports\Support\Report\TicketAttendedUserExport;
use App\Models\Master\Establishment;

class TicketAttendedUserController extends Controller
{
    public function reportExcel(Request $request){

        $start = $request->input('date_start');
        $end  = $request->input('date_end');
        $establisment = Establishment::find($request->input('establishment_id'))->name;

        $user = Auth::user();
        $activity = new Activity;
        $activity->causedBy($user);
        $activity->routeOn(route('support_report_groups_ticket_status'));
        $activity->componentOn('support.reports.ticket-attended-user');
        $activity->logType('download');
        $activity->log('Descargar reporte ticket atendidos por usuarios');
        $activity->save();

        $items = $this->usersStates($request);

        $filename = "REPORTE_TICKET_ATENDIDOS_USUARIOS_".$start;

        return (new TicketAttendedUserExport)
            ->items($items)
            ->parameters(['start'=>$start,'end'=>$end,'establisment'=>$establisment])
            ->download($filename.'.xlsx');
    }

    public function usersStates($request){

        $establishment_id = $request->input('establishment_id');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        return SupTicketRecord::join('users','sup_ticket_records.user_id','users.id')
            ->join('people','users.person_id','people.id')
            ->select(
                'people.trade_name',
                'sup_ticket_records.state'
            )
            ->selectRaw('COUNT(user_id) AS quantity')
            ->where('sup_ticket_records.establishment_id',$establishment_id)
            ->whereBetween('sup_ticket_records.created_at', [$date_start, $date_end])
            ->groupBy(['people.trade_name','state','user_id'])
            ->orderBy('people.trade_name')
            ->get()
            ->toArray();
    }
}
