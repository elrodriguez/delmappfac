<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Establishment;
use Illuminate\Support\Carbon;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;

class EstablishmentController extends Controller
{
    public function list(){
        return datatables(Establishment::query())
            ->addColumn('edit_url', function($row){
                return route('establishments_edit', $row->id);
            })->addColumn('delete_url', function($row){
                return route('establishment_delete', $row->id);
            })->addColumn('tables_url', function($row){
                return route('establishment_tables', $row->id);
            })->addColumn('series_url', function($row){
                return route('establishments_series', $row->id);
            })->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })->make(true);
    }
    public function destroy($id){
        $establishment = Establishment::find($id);
        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(Establishment::class,$establishment->id);
        $activity->causedBy($user);
        $activity->routeOn(route('establishment_delete',$id));
        $activity->dataOld($establishment);
        $activity->logType('destroy');
        $activity->log('El usuario eliminó el registro');
        $activity->save();

        if($establishment){
            $establishment->delete();
        }
        return response()->json(['success'=>true,'name'=>$establishment->name], 200);
    }
}
