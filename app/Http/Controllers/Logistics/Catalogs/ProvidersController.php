<?php

namespace App\Http\Controllers\Logistics\Catalogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use Illuminate\Support\Carbon;

class ProvidersController extends Controller
{
    public function list(){
        return datatables($this->providersjoin())
            ->addColumn('edit_url', function($row){
                return route('logistics_catalogs_provider_edit', $row->id);
            })
            ->editColumn('birth_date', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->editColumn('time_arrival', function($row){
                return Carbon::parse($row->time_arrival)->format('H:i:s');;
            })
            ->make(true);
    }
    public function providersjoin(){
        return PersonTypeDetail::query()
            ->select(
                'people.*',
                'suppliers.time_arrival'
            )
            ->join('people','person_type_details.person_id','people.id')
            ->join('suppliers','people.id','suppliers.person_id')
            ->where('person_type_details.person_type_id',2);
    }
}
