<?php

namespace App\Http\Controllers\RRHH\Payments;

use App\Http\Controllers\Controller;
use App\Models\Logistics\Production\ProjectEmployees;
use App\Models\Master\Company;
use App\Models\Master\Establishment;
use App\Models\RRHH\Payments\EmployeeConcept;
use App\Models\RRHH\Payments\Expense;
use App\Models\RRHH\Payments\ExpenseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Mpdf\Mpdf;
use Mpdf\HTMLParserMode;

class ExpensesController extends Controller
{
    public function list(){
        return datatables($this->ticketJoin())
            ->addColumn('cancel_url', function($row){
                return route('rrhh_payments_tickts_cancel', $row->id);
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }
    public function ticketJoin(){
        return Expense::query()->join('people','expenses.person_id','people.id')
                ->join('expense_types','expenses.expense_type_id','expense_types.id')
                ->join('expense_reasons','expenses.expense_reason_id','expense_reasons.id')
                ->select(
                    'expenses.id',
                    'expenses.external_id',
                    'expenses.created_at',
                    'expenses.number',
                    'expense_types.description',
                    'people.trade_name',
                    'people.number AS person_numer',
                    'expenses.total',
                    'expenses.state'
                )
                ->where('employee_pay',true)
                ->orderBy('expenses.created_at','DESC');
    }

    public function toPrint($model,$external_id,$format = null){

        $company = Company::find(1);

        $ticket = Expense::join('people','expenses.person_id','people.id')
                        ->select(
                            'expenses.id',
                            'people.trade_name',
                            'people.number AS person_number',
                            'expenses.number AS expense_number',
                            'expenses.date_of_issue',
                            'expenses.time_of_issue',
                            'expenses.total',
                            'expenses.establishment_id'
                        )
                        ->where('external_id',$external_id)
                        ->first();
        $establishment = Establishment::find($ticket->establishment_id);
        $ticket_items = ExpenseItem::where('expense_id',$ticket->id)->get();
        $items = [];
        foreach($ticket_items as $key => $ticket_item){
            $items[$key] = [
                'description' => $ticket_item->description,
                'total' => $ticket_item->total
            ];
        }
        //dd($items);
        $data = [
            'company_name' => $company->tradename,
            'establishment_address' => $establishment->address,
            'establishment_phone' => $establishment->phone,
            'company_ruc' => $company->number,
            'company_logo' => $company->logo_store,
            'person_name' => $ticket->trade_name,
            'person_number' => $ticket->person_number,
            'expense_number' => $ticket->expense_number,
            'date_of_issue' => $ticket->date_of_issue,
            'time_of_issue' => $ticket->time_of_issue,
            'total' => $ticket->total,
            'items' => $items
        ];

        $html = view('RRHH.payments.document.document_employee')->with('data',$data)->render();

        $namefile = $external_id.'.pdf';
        $mpdf = new Mpdf();
        $path_css = asset('css/document-employee.css');
        //dd($path_css);
        $stylesheet = file_get_contents($path_css);
        //dd($html);
        $mpdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
        //dd($mpdf);
        $mpdf->Output($namefile,"I");
    }

    public function cancelExpense($id){
        $expense = Expense::find($id);
        $items = ExpenseItem::where('expense_id',$expense->id)->get();

        foreach($items as $item){
            ProjectEmployees::where('id',$item->proj_emp_id)->update(
                ['paid' => 0]
            );
            EmployeeConcept::where('id',$item->concept_id)->update([
                'state' => 0,
                'payment_date' => null
            ]);
        }

        $expense->update(['state'=>0]);

        return response()->json([
            'title'=>'Exito',
            'message'=>'Fue anulado correctamente',
            'state' => 'success'
        ], 200);
    }
}
