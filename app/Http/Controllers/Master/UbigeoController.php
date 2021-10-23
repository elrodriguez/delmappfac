<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UbigeoController extends Controller
{
    public function ubigeo(){
        $array = DB::table('districts')
                ->join('provinces','districts.province_id','provinces.id')
                ->join('departments','provinces.department_id','departments.id')
                ->select(
                    'districts.id  AS district_id',
                    'districts.description  AS district_name',
                    'provinces.id  AS province_id',
                    'provinces.description  AS province_name',
                    'departments.id  AS department_id',
                    'departments.description  AS department_name'
                )
                ->orderBy('departments.description')
                ->orderBy('provinces.description')
                ->orderBy('districts.description')
                ->get();
        $department_name = '';
        $province_name = '';
        $departments = [];
        $k = 0;
        foreach($array as $department){
            if($department_name != $department->department_name){
                $provinces = [];
                $c = 0;
                foreach($array as $province){
                    if($province->department_id == $department->department_id){

                        if($province_name != $province->province_name){
                            $districts = [];
                            $i = 0;
                            foreach($array as $district){
                                if($province->province_id == $district->province_id){
                                    $districts[$i++] = [
                                        'id' => $district->district_id,
                                        'name' => $district->district_name,
                                        'all_id' => $district->department_id .'*'.$district->province_id .'*'.$district->district_id
                                    ];
                                }
                            }
                            $provinces[$c++] = [
                                'id' => $province->province_id,
                                'name' => $province->province_name,
                                'items' => $districts
                            ];
                        }
                        $province_name = $province->province_name;
                    }
                }
                $departments[$k++] = [
                    'id' => $department->department_id,
                    'name' => $department->department_name,
                    'items' => $provinces
                ];
            }
            $department_name = $department->department_name;
        }

        return json_encode($departments);
    }
}
