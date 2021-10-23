<?php

namespace App\Http\Controllers\Logistics\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Master\Document;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse\Purchase;

class InventoryKardexController extends Controller
{
    protected $balance = 0;
    protected $restante = 0;

    public function inventoryKardexItemsSearch(Request $request){
        
        return datatables($this->inventoryKardexItemsQuery($request))
            ->addColumn('transaction_type', function($row){
                if ($row->inventory_kardexable_type == 'App\Models\Warehouse\Inventory'){
                    return $row->inventory_description;
                }elseif($row->inventory_kardexable_type == 'App\Models\Warehouse\Purchase'){
                    if ($row->quantity>0){
                        return 'Compra';
                    }else{
                        return 'Anulación Compra';
                    }
                }elseif($row->inventory_kardexable_type == 'App\Models\Master\Document'){
                    if ($row->quantity>0){
                        return 'Anulación Venta';
                    }else{
                        return 'Venta';
                    }
                }
            })
            ->addColumn('quantity_entry', function($row){
                if ($row->inventory_kardexable_type == 'App\Models\Warehouse\Inventory'){
                    if ($row->quantity>0){
                        return $row->quantity;
                    }else{
                        return '-';
                    }
                }elseif($row->inventory_kardexable_type == 'App\Models\Warehouse\Purchase'){
                    if ($row->quantity>0){
                        return $row->quantity;
                    }else{
                        return '-';
                    }
                }elseif($row->inventory_kardexable_type == 'App\Models\Master\Document'){
                    if ($row->quantity>0){
                        return $row->quantity;
                    }else{
                        return '-';
                    }
                }
            })
            ->addColumn('quantity_exit', function($row) {
                if ($row->inventory_kardexable_type == 'App\Models\Warehouse\Inventory'){
                    if ($row->quantity<0){
                        return $row->quantity;
                    }else{
                        return '-';
                    }
                }elseif($row->inventory_kardexable_type == 'App\Models\Warehouse\Purchase'){
                    if ($row->quantity<0){
                        return $row->quantity;
                    }else{
                        return '-';
                    }
                }elseif($row->inventory_kardexable_type == 'App\Models\Master\Document'){
                    if ($row->quantity<0){
                        return $row->quantity;
                    }else{
                        return '-';
                    }
                }
            })
            ->addColumn('number', function($row) {
                if($row->inventory_kardexable_type == 'App\Models\Warehouse\Purchase'){
                    return $row->purchase_number;
                }elseif($row->inventory_kardexable_type == 'App\Models\Master\Document'){
                    return $row->document_number;
                }
            })
            ->addColumn('balance', function($row) {
                return $this->balance = $this->balance+$row->quantity;
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('date_of_issue', function($row){
                return Carbon::parse($row->date_of_issue)->format('d/m/Y');
            })
            ->make(true);
   }

    public function inventoryKardexItemsQuery($request){

        $start = $request->input('date_start');
        $end = $request->input('date_end');
        $item_id = $request->input('item_id');
        $warehouse_id = $request->input('warehouse_id');

       
        //$this->calculateRemaining($request);

        $items = InventoryKardex::query()->join('items','inventory_kardex.item_id','items.id')
                ->leftJoin('purchases', function($query)
                {
                    $query->on('inventory_kardex.inventory_kardexable_id','purchases.id')
                        ->where('inventory_kardex.inventory_kardexable_type', Purchase::class);
                })
                ->leftJoin('documents', function($query)
                {
                    $query->on('inventory_kardex.inventory_kardexable_id','documents.id')
                        ->where('inventory_kardex.inventory_kardexable_type', Document::class);
                })
                ->leftJoin('inventories', function($query)
                {
                    $query->on('inventory_kardex.inventory_kardexable_id','inventories.id')
                        ->where('inventory_kardex.inventory_kardexable_type', Inventory::class);
                })
                ->select(
                    'items.id',
                    'items.internal_id',
                    'items.description',
                    'inventories.description AS inventory_description',
                    'inventory_kardex.date_of_issue',
                    'inventory_kardex.inventory_kardexable_type',
                    'inventory_kardex.created_at',
                    'inventory_kardex.quantity',
                    DB::raw("CONCAT(purchases.series,'-',purchases.number) AS purchase_number"),
                    DB::raw("CONCAT(documents.series,'-',documents.number) AS document_number")
                )
                ->where('inventory_kardex.warehouse_id',$warehouse_id)
                ->where('inventory_kardex.item_id',$item_id)
                ->whereBetween('inventory_kardex.date_of_issue', [$start, $end]);

        return $items;
    }

    public function calculateRemaining($request)
    {
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        $item_id = $request->input('item_id');
        $warehouse_id = $request->input('warehouse_id');

        $page = $request->page;

        if($page >= 2) {

            //$warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();

            if($date_start && $date_end) {
                $records = InventoryKardex::where([
                    ['warehouse_id', $warehouse_id],
                    ['item_id',$item_id],
                    ['date_of_issue', '<=', $date_start]
                ])->first();

                $ultimate = InventoryKardex::select(DB::raw('COUNT(*) AS t, MAX(id) AS id'))
                    ->where([
                        ['warehouse_id', $warehouse_id],
                        ['item_id',$item_id],
                        ['date_of_issue', '<=', $date_start]
                    ])->first();

                if (isset($records->date_of_issue) && Carbon::parse($records->date_of_issue)->eq(Carbon::parse($date_start))) {
                    $quantityOld = InventoryKardex::select(DB::raw('SUM(quantity) AS quantity'))
                        ->where([
                            ['warehouse_id', $warehouse_id],
                            ['item_id',$item_id],
                            ['date_of_issue', '<=', $date_start]
                        ])->first();
                    $quantityOld->quantity = 0;
                }elseif($ultimate->t == 1) {
                    $quantityOld = InventoryKardex::select(DB::raw('SUM(quantity) AS quantity'))
                    ->where([
                        ['warehouse_id', $warehouse_id],
                        ['item_id',$item_id],
                        ['date_of_issue', '<=', $date_start]
                    ])->first();
                } else {
                    $quantityOld = InventoryKardex::select(DB::raw('SUM(quantity) AS quantity'))
                        ->where([
                            ['warehouse_id', $warehouse_id],
                            ['item_id',$item_id],
                            ['date_of_issue', '<=', $date_start]
                        ])->whereNotIn('id', [$ultimate->id])->first();
                }

                $data = InventoryKardex::select('quantity')
                    ->where([['warehouse_id', $warehouse_id],['item_id',$item_id]])
                    ->whereBetween('date_of_issue', [$date_start, $date_end])
                    // ->when($date_start, function ($query) use ($date_start, $date_end){
                    //     return $query->whereBetween('date_of_issue', [$date_start, $date_end]);
                    // })
                    ->limit(($page*$this->visible)-$this->visible)->get();

                for($i=0;$i<=count($data)-1;$i++) {
                    $this->restante += $data[$i]->quantity;
                }

                $this->restante += $quantityOld->quantity;

                $this->balance = $this->restante;

            } else {
                $data = InventoryKardex::where('warehouse_id', $warehouse_id)->where('item_id',$item_id)
                    ->limit(($page*$this->visible)-$this->visible)->get();
                for($i=0;$i<=count($data)-1;$i++) {
                    $this->restante+=$data[$i]->quantity;
                }
            }
            return $this->balance = $this->restante;

        } else {

            if($date_start && $date_end) {

                //$warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();

                $records = InventoryKardex::where([
                        ['warehouse_id', $warehouse_id],
                        ['item_id',$item_id],
                        ['date_of_issue', '<=', $date_start]
                    ])->first();

                $ultimate = InventoryKardex::select(DB::raw('COUNT(*) AS t, MAX(id) AS id'))
                    ->where([
                        ['warehouse_id', $warehouse_id],
                        ['item_id',$item_id],
                        ['date_of_issue', '<=', $date_start]
                    ])->first();

                if (isset($records->date_of_issue) && Carbon::parse($records->date_of_issue)->eq(Carbon::parse($date_start))) {
                    $quantityOld = InventoryKardex::select(DB::raw('SUM(quantity) AS quantity'))
                        ->where([
                            ['warehouse_id', $warehouse_id],
                            ['item_id',$item_id],
                            ['date_of_issue', '<=', $date_start]
                        ])->first();
                    $quantityOld->quantity = 0;
                }elseif($ultimate->t == 1) {
                    $quantityOld = InventoryKardex::select(DB::raw('SUM(quantity) AS quantity'))
                    ->where([
                        ['warehouse_id', $warehouse_id],
                        ['item_id',$item_id],
                        ['date_of_issue', '<=', $date_start]
                    ])->first();
                } else {
                    $quantityOld = InventoryKardex::select(DB::raw('SUM(quantity) AS quantity'))
                        ->where([
                            ['warehouse_id', $warehouse_id],
                            ['item_id',$item_id],
                            ['date_of_issue', '<=', $date_start]
                        ])->whereNotIn('id', [$ultimate->id])->first();
                }
                return $this->balance = $quantityOld->quantity;
            }

        }

    }
}
