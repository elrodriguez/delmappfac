<?php

namespace App\Http\Controllers\Academic\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic\Administration\Postulant;
use Illuminate\Support\Carbon;

class PostulantController extends Controller
{
    public function list(){
        return datatables(Postulant::query())
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }
    public function destroy($id){
        $establishment = Postulant::find($id);
        $data = 'fail';
        if($establishment){
            $establishment->delete();
        }
        return response()->json(['success'=>true,'name'=>$establishment->name], 200);
    }
}
