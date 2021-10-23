<?php

namespace App\Http\Controllers\RRHH\Payments;

use App\Http\Controllers\Controller;
use App\Models\RRHH\Payments\EmployeeConcept;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;

class EmployeeConceptsController extends Controller
{
    public function advancements(){
        return datatables($this->advancementsJoin())
            ->addColumn('edit_url', function($row){
                return route('rrhh_payments_advancements_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('rrhh_payments_advancements_delete', $row->id);
            })
            ->editColumn('payment_date', function($row){
                if($row->payment_date){
                    return Carbon::parse($row->payment_date)->format('d/m/Y');
                }else{
                    return null;
                }
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }

    public function advancementsJoin(){
        return EmployeeConcept::query()->join('people','employee_concepts.person_id','people.id')
            ->join('concepts','employee_concepts.concept_id','concepts.id')
            ->select(
                'employee_concepts.id',
                'employee_concepts.created_at',
                'employee_concepts.payment_date',
                'employee_concepts.amount',
                'employee_concepts.state',
                'employee_concepts.observations',
                'people.trade_name',
                'concepts.description'
            )
            ->orderBy('employee_concepts.created_at','DESC');
    }
    public function advancementDelete($id){
        $advancement = EmployeeConcept::find($id);
        if($advancement->state == 1){
            $title = Lang::get('messages.failed_process');
            $message = Lang::get('messages.can_no_longer_perform_this_action');
            $state = 'error';
        }else{
            $advancement->delete();
            $title = Lang::get('messages.removed');
            $message = Lang::get('messages.was_successfully_removed');
            $state = 'success';
        }
        return response()->json([
            'title'=>$title,
            'message'=>$message,
            'state' => $state
        ], 200);
    }
}
