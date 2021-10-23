<?php

namespace App\Http\Controllers\Support\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketRecord;
use App\Exports\Support\Report\StateSummaries;
use App\Models\Master\Establishment;

class StateSummariesController extends Controller
{
    public function reportExcel(Request $request){

        $start = $request->input('date_start');
        $end  = $request->input('date_end');
        $establisment = Establishment::find($request->input('establishment_id'))->name;

        $user = Auth::user();
        $activity = new Activity;
        $activity->causedBy($user);
        $activity->routeOn(route('support_report_groups_ticket_status'));
        $activity->componentOn('support.reports.state-summaries');
        $activity->logType('download');
        $activity->log('Descargar reporte grupos-ticket-estados');
        $activity->save();

        $items = $this->groupStates($request);

        $filename = "REPORTE_GRUPOS_TICKET_ESTADOS_".$start;

        return (new StateSummaries)
            ->items($items)
            ->parameters(['start'=>$start,'end'=>$end,'establisment'=>$establisment])
            ->download($filename.'.xlsx');
    }

    public function groupStates($request){
        //dd($request->all());
        $establishment_id = $request->input('establishment_id');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        $tickets = SupTicket::where('sup_tickets.establishment_id',$establishment_id)
            ->whereBetween('sup_tickets.created_at', [$date_start, $date_end])
            ->count();

        $tickets_pending = SupTicket::where('state','sent')
            ->where('sup_tickets.establishment_id',$establishment_id)
            ->whereBetween('sup_tickets.created_at', [$date_start, $date_end])
            ->count();

        $groups = SupTicketRecord::join('sup_service_area_groups','sup_ticket_records.from_group_id','sup_service_area_groups.id')
            ->select('sup_service_area_groups.description')
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'attended' THEN 1 END) AS attended")
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'derivative' THEN 1 END) AS derivative")
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'cancel' THEN 1 END) AS cancel")
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'closed_ok' THEN 1 END) AS closed_ok")
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'closed_fail' THEN 1 END) AS closed_fail")
            ->groupBy('sup_service_area_groups.description')
            ->where('sup_ticket_records.establishment_id',$establishment_id)
            ->whereBetween('sup_ticket_records.created_at', [$date_start, $date_end])
            ->get()
            ->toArray();

        return [
            'tickets' => $tickets,
            'tickets_pending' => $tickets_pending,
            'groups' => $groups
        ];
    }
}
