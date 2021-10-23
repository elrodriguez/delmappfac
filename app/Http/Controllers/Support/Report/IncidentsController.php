<?php

namespace App\Http\Controllers\Support\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\Support\Helpdesk\SupTicket;
use App\Exports\Support\Report\IncidentsExport;
use App\Models\Master\Establishment;
use Illuminate\Support\Facades\DB;

class IncidentsController extends Controller
{
    public function reportExcel(Request $request){

        $start = $request->input('date_start');
        $end  = $request->input('date_end');
        $establisment = Establishment::find($request->input('establishment_id'))->name;

        $user = Auth::user();
        $activity = new Activity;
        $activity->causedBy($user);
        $activity->routeOn(route('support_report_incidents'));
        $activity->componentOn('support.reports.ticket-incidents');
        $activity->logType('download');
        $activity->log('Descargar reporte incidencias');
        $activity->save();

        $items = $this->groupStates($request);

        $filename = "REPORTE_TICKET_INCIDENCIAS_".$start;

        return (new IncidentsExport)
            ->items($items)
            ->parameters(['start'=>$start,'end'=>$end,'establisment'=>$establisment])
            ->download($filename.'.xlsx');
    }

    public function groupStates($request){

        $establishment_id = $request->input('establishment_id');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        $summary = SupTicket::join('establishments','sup_tickets.establishment_id','establishments.id')
            ->join('sup_categories','sup_tickets.sup_category_id','sup_categories.id')
            ->join('sup_categories AS c2','sup_categories.sup_category_id','c2.id')
            ->join('sup_service_areas','sup_tickets.sup_service_area_id','sup_service_areas.id')
            ->where('sup_tickets.establishment_id',$establishment_id)
            ->whereBetween('sup_tickets.created_at', [$date_start, $date_end])
            ->select(
                'sup_tickets.created_at',
                'sup_tickets.internal_id',
                'sup_tickets.state',
                'sup_tickets.description_of_problem',
                'establishments.name',
                'sup_categories.short_description AS subcategory_description',
                'c2.short_description AS category_description',
                'sup_service_areas.description AS area_description'
            )
            ->selectSub(function($query) {
                $query->from('sup_ticket_solutions')->select(
                    DB::raw('CONCAT("[",GROUP_CONCAT(JSON_OBJECT("description",solution_description)),"]")')
                )
                ->whereColumn('sup_ticket_solutions.sup_ticket_id','sup_tickets.id');
            }, 'solutions')
            ->selectSub(function($query) {
                $query->from('sup_ticket_users')->join('users','sup_ticket_users.user_id','users.id')
                ->select(
                    'users.email'
                )
                ->whereColumn('sup_ticket_users.sup_ticket_id','sup_tickets.id')
                ->where('sup_ticket_users.type','applicant');
            }, 'user_email')
            ->selectRaw("(TIMESTAMPDIFF(MINUTE,sup_tickets.created_at,sup_tickets.updated_at)) AS time_elapsed")
            ->selectRaw("((sup_tickets.days*1440)+(sup_tickets.hours*60)+sup_tickets.minutes) AS time_limit")
            ->orderBy('sup_tickets.created_at','DESC')
            ->get()
            ->toArray();

        return $summary;
    }
}
