<?php

namespace App\Http\Controllers\Logistics\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse\InventoriesTransfer;
use Carbon\Carbon;

class TransferController extends Controller
{
    public function list(){
        return datatables()->eloquent($this->inventory())
                ->editColumn('created_at', function($row){
                    return Carbon::parse($row->created_at)->format('d/m/Y H:i:s');
                })
                ->toJson();
    }

    public function inventory(){
        return InventoriesTransfer::query()
            ->with(array('warehouse' => function($query) {
                $query->select('id','description');
            }))
            ->with(array('warehouse_destination' => function($query) {
                $query->select('id','description');
            }))
            ->with(array('inventory' => function($query) {
                $query->with(array('item' => function($query) {
                    $query->select('id','description');
                }));
            }))
            ->orderBy('created_at','DESC');
    }
}
