<?php

namespace App\Http\Controllers\Market\Sales;

use App\Http\Controllers\Controller;
use App\Models\Master\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    public function searchCustomers(Request $request){
        $persons = Person::where('trade_name','like','%'.$request->input('q').'%')
            ->select(
                'people.id AS value',
                DB::raw('CONCAT(people.number," - ",people.trade_name) AS text')
            )
            ->limit(200)
            ->get();

        return response()->json($persons, 200);
    }
}
