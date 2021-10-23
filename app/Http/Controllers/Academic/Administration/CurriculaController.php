<?php

namespace App\Http\Controllers\Academic\Administration;

use App\Http\Controllers\Controller;
use App\Models\Academic\Administration\Curricula;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CurriculaController extends Controller
{
    public function list(){
        return datatables(Curricula::query())
            ->addColumn('edit_url', function($row){
                return route('academic_curricula_edit', $row->id);
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }
}
