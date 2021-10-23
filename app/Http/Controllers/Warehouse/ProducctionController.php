<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\DocumentProduction;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\Kardex;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Block\Element\Document;

class ProducctionController extends Controller
{
    public function list(){
        return datatables()->eloquent($this->joinDocumentFishing())
            ->addColumn('delete_url', function($row){
                return route('production_delete', $row->id);
            })
            ->editColumn('date_of_issue', function($row){
                return Carbon::parse($row->date_of_issue)->format('d/m/Y');
            })
            ->order(function ($query) {
                $query->orderBy('document_productions.id', 'DESC');
            })
            ->make(true);
    }
    public function joinDocumentFishing() {
        return  DocumentProduction::query()
                ->select([
                    'items.description',
                    'brands.name',
                    'document_productions.id',
                    'document_productions.code_id',
                    'document_productions.quantity',
                    'document_productions.date_of_issue',
                    'document_productions.quantity_boxes',
                    'document_productions.pallets',
                    'document_productions.filas',
                    'document_productions.cajas',
                    'document_productions.unidades',
                    'document_productions.cubetas'
                ])
                ->join('items', 'document_productions.item_id', '=', 'items.id')
                ->join('brands', 'document_productions.brand_id', '=', 'brands.id');
    }

    public function destroy($id){
        $documentproduction = DocumentProduction::find($id);
        if($documentproduction){

            Item::where('id',$documentproduction->item_id)->increment('stock', $documentproduction->quantity);
            Kardex::where('document_production_id',$id)->delete();
            InventoryKardex::where('inventory_kardexable_id',$id)
                ->where('inventory_kardexable_type','=',DocumentProduction::class)
                ->delete();

            $documentproduction->delete();

        }
        return response()->json(['success'=>true,'name'=>$documentproduction->code_id], 200);
    }

    public function boxtodaybybrands(){
        return DocumentProduction::join('items', 'document_productions.item_id', '=', 'items.id')
            ->join('brands', 'document_productions.brand_id', '=', 'brands.id')
            ->select([
                'items.description',
                'brands.name',
                DB::raw('SUM(document_productions.quantity_boxes) as stock')
            ])
            ->groupBy('items.description')
            ->groupBy('brands.name')
            ->get();
    }
}
