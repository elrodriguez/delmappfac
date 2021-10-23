<?php

namespace App\Http\Controllers\Market\Administration;

use App\Exports\CashProductExport;
use App\Http\Controllers\Controller;
use App\Models\Catalogue\CatPaymentMethodTypes;
use App\Models\Master\Cash;
use App\Models\Master\CashDocument;
use App\Models\Master\Company;
use App\Models\Master\DocumentItem;
use App\Models\Master\SaleNoteItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class CashController extends Controller
{
    public function closeCash($id){
        $cash = Cash::findOrFail($id);

        $cash->date_closed = date('Y-m-d');
        $cash->time_closed = date('H:i:s');

        $final_balance = 0;
        $income = 0;

        foreach ($cash->cash_documents as $cash_document) {


            if($cash_document->sale_note){

                if(in_array($cash_document->sale_note->state_type_id, ['01','03','05','07','13'])){
                    $final_balance += ($cash_document->sale_note->currency_type_id == 'PEN') ? $cash_document->sale_note->total : ($cash_document->sale_note->total * $cash_document->sale_note->exchange_rate_sale);
                }

                // $final_balance += $cash_document->sale_note->total;

            }
            else if($cash_document->document){

                if(in_array($cash_document->document->state_type_id, ['01','03','05','07','13'])){
                    $final_balance += ($cash_document->document->currency_type_id == 'PEN') ? $cash_document->document->total : ($cash_document->document->total * $cash_document->document->exchange_rate_sale);
                }

                // $final_balance += $cash_document->document->total;

            }
            else if($cash_document->expense_payment){

                if($cash_document->expense_payment->expense->state_type_id == '05'){
                    $final_balance -= ($cash_document->expense_payment->expense->currency_type_id == 'PEN') ? $cash_document->expense_payment->payment:($cash_document->expense_payment->payment  * $cash_document->expense_payment->expense->exchange_rate_sale);
                }

            }

        }

        $cash->final_balance = round($final_balance + $cash->beginning_balance, 2);
        $cash->income = round($final_balance, 2);
        $cash->state = false;
        $cash->save();
        return response()->json(['success'=>true], 200);
    }

    public function report($cash) {

        $cash = Cash::findOrFail($cash);
        $company = Company::first();

        $methods_payment = CatPaymentMethodTypes::select(
                'cat_payment_method_types.id',
                'cat_payment_method_types.description AS name',
                DB::raw("(SELECT SUM(payment) FROM document_payments INNER JOIN documents ON document_payments.document_id=documents.id WHERE documents.state_type_id NOT IN ('11','13') AND document_payments.payment_method_type_id=cat_payment_method_types.id) AS payment_sum")
            )
            ->get();

        set_time_limit(0);

        $pdf = PDF::loadView('market.administration.cash_report_pdf', compact("cash", "company", "methods_payment"));

        $filename = "Reporte - {$cash->user->name} - {$cash->date_opening} {$cash->time_opening}";

        return $pdf->stream($filename.'.pdf');
    }

    public function report_products($id)
    {

        $data = $this->getDataReport($id);
        $pdf = PDF::loadView('market.administration.cash_report_product_pdf', $data);

        $filename = "Reporte_PRODUCTOS - {$data['cash']->user->name} - {$data['cash']->date_opening} {$data['cash']->time_opening}";

        return $pdf->stream($filename.'.pdf');

    }



    public function report_products_excel($id)
    {

        $data = $this->getDataReport($id);
        $filename = "Reporte_PRODUCTOS - {$data['cash']->user->name} - {$data['cash']->date_opening} {$data['cash']->time_opening}";

        return (new CashProductExport)
                ->documents($data['documents'])
                ->company($data['company'])
                ->cash($data['cash'])
                ->download($filename.'.xlsx');

    }

    public function report_general()
    {
        $cashes = Cash::select('id')->whereDate('date_opening', date('Y-m-d'))->pluck('id');
        $cash_documents =  CashDocument::whereIn('cash_id', $cashes)->get();

        $company = Company::first();
        set_time_limit(0);

        $pdf = PDF::loadView('market.administration.cash_report_general_pdf', compact("cash_documents", "company"));
        $filename = "Reporte_POS";
        return $pdf->download($filename.'.pdf');

    }

    public function getDataReport($id){

        $cash = Cash::findOrFail($id);
        $company = Company::first();
        $cash_documents =  CashDocument::select('document_id')->where('cash_id', $cash->id)->get();

        $source = DocumentItem::with('document')->whereIn('document_id', $cash_documents)->get();

        $documents = collect($source)->transform(function($row){
            return [
                'id' => $row->id,
                'number_full' => $row->document->series.'-'.$row->document->number,
                'description' => json_decode($row->item)->description,
                'quantity' => $row->quantity,
            ];
        });

        $documents = $documents->merge($this->getSaleNotesReportProducts($cash));

        return compact("cash", "company", "documents");

    }

    public function getSaleNotesReportProducts($cash){

        $cd_sale_notes =  CashDocument::select('sale_note_id')->where('cash_id', $cash->id)->get();

        $sale_note_items = SaleNoteItem::with('sale_note')->whereIn('sale_note_id', $cd_sale_notes)->get();

        return collect($sale_note_items)->transform(function($row){
            return [
                'id' => $row->id,
                'number_full' => $row->sale_note->number_full,
                'description' => $row->item->description,
                'quantity' => $row->quantity,
            ];
        });

    }
}
