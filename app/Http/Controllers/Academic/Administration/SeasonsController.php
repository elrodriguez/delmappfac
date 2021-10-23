<?php

namespace App\Http\Controllers\Academic\Administration;

use App\Http\Controllers\Controller;
use App\Models\Academic\Administration\AcademicSeason;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    public function list(){
        return datatables(AcademicSeason::query())
            ->addColumn('edit_url', function($row){
                return route('academic_seasons_edit', $row->id);
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }
}
