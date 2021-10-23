<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SeriesController extends Controller
{
    public function list(Request $request){

        return datatables($this->seriesJoin($request))
            ->addColumn('edit_url', function($row){
                return route('establishments_series_edit',[$row->establishment_id,$row->id]);
            })->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })->make(true);
    }
    public function seriesJoin($request){
        return Serie::query()
                    ->join('document_types','series.document_type_id','document_types.id')
                    ->select(
                        'series.*',
                        'document_types.description AS document_type_description'
                    )
                    ->where('series.establishment_id',$request->input('establishment_id'));
    }
}
