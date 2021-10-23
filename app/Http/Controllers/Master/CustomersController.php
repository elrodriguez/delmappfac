<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CustomersController extends Controller
{
    public function list(){
        return datatables($this->customersjoin())
            ->addColumn('edit_url', function($row){
                return route('customer_edit', $row->id);
            })
            ->editColumn('birth_date', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }
    public function customersjoin(){
        return PersonTypeDetail::query()->select('people.*')
            ->join('people','person_type_details.person_id','people.id')
            ->where('person_type_details.person_type_id',1);
    }
}
