<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Person;
use App\Models\Warehouse\DocumentFishing;
use App\Models\Warehouse\DocumentFishingDetail;
use App\Models\Warehouse\Fishing;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DocumentFishingController extends Controller
{
    // public function searchCustomer(){
    //     return datatables()->eloquent($this->queryJoin())->filter(function ($query) {
    //                         if (request()->has('customer')) {
    //                             $query->where('name', 'like', "%" . request('customer') . "%");
    //                         }
    //                     })
    //                     ->toJson();

    // }
    public function searchCustomer() {
        return Person::select([
                    'countries.description As country_name',
                    'departments.description AS department_name',
                    'provinces.description AS province_name',
                    'districts.description AS district_name',
                    'people.*'
                ])
                ->join('countries', 'people.country_id', '=', 'countries.id')
                ->join('departments', 'people.department_id', '=', 'departments.id')
                ->join('provinces', 'people.province_id', '=', 'provinces.id')
                ->join('districts', 'people.district_id', '=', 'districts.id')
                ->where(DB::raw("REPLACE(people.name, ' ', '')"), 'LIKE', '%' . str_replace(' ','',request('customer')). '%')
                ->paginate(50);
    }

    public function list(){
        return datatables()->eloquent($this->joinDocumentFishing())
            ->addColumn('delete_url', function($row){
                return route('income_fishing_delete', $row->id);
            })
            ->addColumn('sacks_url', function($row){
                return route('warehouse_fishing_sacks_add', $row->id);
            })
            ->addColumn('document_fishing_number', function($row){
                return $row->serie.'-'.$row->numero;
            })
            ->editColumn('date_of_issue', function($row){
                return Carbon::parse($row->date_of_issue)->format('d/m/Y');
            })
            ->editColumn('date_of_transfer', function($row){
                return Carbon::parse($row->date_of_transfer)->format('d/m/Y');
            })
            ->order(function ($query) {
                $query->orderBy('id', 'DESC');
            })
            ->make(true);
    }
    public function joinDocumentFishing() {
        $establishments = DocumentFishing::query()
                ->select([
                    'document_fishings.id',
                    'document_fishings.date_of_issue',
                    'document_fishings.date_of_transfer',
                    'document_fishings.serie',
                    'document_fishings.numero',
                    'document_fishings.weight',
                    'people.trade_name',
                ])
                ->leftJoin('people', 'document_fishings.customer_id', '=', 'people.id');

        return $establishments;
    }
    public function destroy($id){
        $documentfishing = DocumentFishing::find($id);
        if($documentfishing){
            $array = DocumentFishingDetail::where('document_fishing_id',$documentfishing->id)->get();
            foreach($array as $fishing){
                Fishing::where('id',$fishing->id)->decrement('stock', $fishing->quantity);
            }
            DocumentFishingDetail::where('document_fishing_id',$documentfishing->id)->delete();
            $documentfishing->delete();

        }
        return response()->json(['success'=>true,'name'=>$documentfishing->numero], 200);
    }
}
