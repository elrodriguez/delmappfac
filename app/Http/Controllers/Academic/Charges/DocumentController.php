<?php

namespace App\Http\Controllers\Academic\Charges;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Person;

class DocumentController extends Controller
{
    public function searchCustomers(){
        return datatables()->eloquent($this->queryJoin())->filter(function ($query) {
                            if (request()->has('customer')) {
                                $query->where(function($query) {
                                    $query->where('name', 'like', "%" . request('customer') . "%")
                                          ->orWhere('number', '=', request('customer'));
                                });
                            }
                        })
                        ->toJson();

    }
    public function queryJoin() {
        return Person::query()->select([
                    'countries.description As country_name',
                    'departments.description AS department_name',
                    'provinces.description AS province_name',
                    'districts.description AS district_name',
                    'people.*'
                ])
                ->leftJoin('countries', 'people.country_id', '=', 'countries.id')
                ->leftJoin('departments', 'people.department_id', '=', 'departments.id')
                ->leftJoin('provinces', 'people.province_id', '=', 'provinces.id')
                ->leftJoin('districts', 'people.district_id', '=', 'districts.id');
    }
}
