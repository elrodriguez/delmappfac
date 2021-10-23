<?php

namespace App\Http\Controllers\Academic\Administration;

use App\Http\Controllers\Controller;
use App\Models\Academic\Administration\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DiscountController extends Controller
{
    public function list(){
        return datatables(Discount::query())
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->addColumn('edit_url', function($row){
                return route('academic_discounts_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('academic_discounts_delete', $row->id);
            })
            ->make(true);
    }
    public function destroy($id){
        $discount = Discount::find($id);
        if($discount){
            $discount->delete();
        }
        return response()->json(['success'=>true,'name'=>$discount->name], 200);
    }
}
