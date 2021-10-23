<?php

namespace App\Http\Controllers\RRHH\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RRHH\Administration\Concept;

class ConceptsController extends Controller
{
    public function list(){
        return datatables($this->conceptJoin())
            ->addColumn('edit_url', function($row){
                return route('rrhh_administration_concepts_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('rrhh_administration_concepts_delete', $row->id);
            })
            ->make(true);
    }
    public function conceptJoin(){
        return Concept::query()->select([
            'id',
            'description',
            'percentage',
            'operation'
        ]);
    }
    public function destroy($id){
        $item = Concept::find($id);
        if($item){
            $item->delete();
        }
        return response()->json(['success'=>true,'name'=>$item->description], 200);
    }
}
