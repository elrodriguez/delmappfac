<?php

namespace App\Http\Controllers\Logistics\Warehouse;

use App\Exports\ReportValuedKardexExport;
use App\Http\Controllers\Controller;
use App\Models\Master\DocumentItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;

class ReportValuedKardexController extends Controller
{
    public function getData(Request $request){
        return datatables($this->itemsQuery($request))
            ->make(true);
    }
    private function itemsQuery($request){
        $start = $request->input('date_start');
        $end  = $request->input('date_end');
        $establisment = $request->input('establishment_id');

        return DocumentItem::query()->join('documents','document_items.document_id','documents.id')
            ->join('items','document_items.item_id','items.id')
            ->leftJoin('brands','items.brand_id','brands.id')
            ->select(
                'items.id',
                'items.description',
                'brands.name',
                'items.unit_type_id',
                DB::raw('SUM(quantity) AS item_quantity'),
                'items.purchase_unit_price',
                DB::raw('SUM(document_items.total) AS item_total'),
                DB::raw('SUM(document_items.quantity*items.purchase_unit_price) AS item_cost'),
                DB::raw('(SUM(document_items.total))-(SUM(document_items.quantity*items.purchase_unit_price)) AS valued_unit')
            )
            ->whereIn('state_type_id',['01','03','05','07'])
            ->when($start, function ($query) use($start,$end){
                return $query->whereBetween('documents.date_of_issue', [$start, $end]);
            }, function ($query) {
                return $query->whereDate('documents.date_of_issue', Carbon::now()->format('Y-m-d'));
            })
            ->when($establisment, function ($query, $establisment) {
                return $query->where('documents.establishment_id', $establisment);
            }, function ($query) {
                return $query->where('documents.establishment_id', 1);
            })
            ->groupBy(
                'items.id',
                'items.description',
                'brands.name',
                'items.unit_type_id',
                'items.purchase_unit_price'
            )
            ->orderBy('items.description');
    }

    public function reportAssistance(Request $request){
        $start = $request->input('date_start');
        $end  = $request->input('date_end');
        $establisment = $request->input('establishment_id');

        $user = Auth::user();
        $activity = new Activity;
        $activity->causedBy($user);
        $activity->routeOn(route('logistics_warehouse_inventory_inventory_report_valued_excel'));
        $activity->componentOn('logistics.warehouse.report_kardex_valued');
        $activity->logType('download');
        $activity->log('Descargar reporte kardex valorizado');
        $activity->save();

        $items = $this->itemsQuery($request);

        $filename = "REPORTE_KARDEX_VALORIZADO_".$start;

        return (new ReportValuedKardexExport)
            ->items($items->get()->toArray())
            ->parameters(['start'=>$start,'end'=>$end,'establisment'=>$establisment])
            ->download($filename.'.xlsx');
    }
}
