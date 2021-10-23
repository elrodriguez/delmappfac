<?php

namespace App\Http\Controllers\Logistics\Production;

use App\Http\Controllers\Controller;
use App\Models\Logistics\Production\Project;
use App\Models\Logistics\Production\ProjectMaterial;
use App\Models\Master\Person;
use App\Models\Warehouse\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ProjectsController extends Controller
{
    public function list(){
        return datatables($this->projectQuery())
            ->addColumn('edit_url', function($row){
                return route('logistics_production_projects_edit', $row->id);
            })
            ->addColumn('stages_url', function($row){
                return route('logistics_production_projects_stages', $row->id);
            })
            ->addColumn('materials_url', function($row){
                return route('logistics_production_projects_material', $row->id);
            })
            ->addColumn('employees_url', function($row){
                return route('logistics_production_projects_employees', $row->id);
            })
            ->addColumn('other_expenses_url', function($row){
                return route('logistics_production_projects_other_expenses', $row->id);
            })
            ->editColumn('date_start', function($row){
                return Carbon::parse($row->date_start)->format('d/m/Y');
            })
            ->editColumn('date_end', function($row){
                return Carbon::parse($row->date_end)->format('d/m/Y');
            })
            ->editColumn('investment', function($row){
                return ceil($row->investment);
            })
            ->make(true);
    }
    private function projectQuery(){
        return Project::query()->leftJoin('people AS re','projects.person_id','re.id')
                ->leftJoin('people AS cu','projects.person_customer_id','cu.id')
                ->select(
                    'projects.id',
                    'projects.description',
                    'projects.date_start',
                    'projects.date_end',
                    'projects.budget',
                    'projects.investment',
                    'projects.state',
                    'projects.observation',
                    're.trade_name AS responsable_name',
                    'cu.trade_name AS customer_name'
                )
                ->orderBy('projects.created_at','DESC');
    }
    public function responsable(){
        $person = Person::query()->join('employees','employees.person_id','people.id')
                    ->select(
                        'people.trade_name',
                        'people.number',
                        'people.id'
                    );
        return datatables()->eloquent($person)->filter(function ($query) {
                if (request()->has('responsable')) {
                    $query->where('name', 'like', "%" . request('responsable') . "%");
                }
            })
            ->toJson();
    }
    public function client(){
        $person = Person::query()->join('customers','customers.person_id','people.id')
                    ->select(
                        'people.trade_name',
                        'people.number',
                        'customers.id'
                    )
                    ->limit(100);
        return datatables()->eloquent($person)->filter(function ($query) {
                if (request()->has('customer')) {
                    $query->where('people.trade_name', 'like', "%" . request('customer') . "%");
                }
            })
            ->toJson();
    }
    public function searchItems(Request $request){


        $items = Item::leftJoin('brands','items.brand_id','brands.id')
            ->select(
                'items.id',
                'items.internal_id',
                'items.description',
                'items.purchase_unit_price',
                'items.stock',
                'brands.name'
            )
            ->where('items.internal_id', '=', $request->input('search'))
            ->orWhere(DB::raw("REPLACE(items.description, ' ', '')"), 'like', "%" .str_replace(' ','',$request->input('search')). "%")
            ->orderBy('items.description')
            ->limit(100)
            ->get();

        $data = [];
                
        foreach ($items as $key => $item){
            $file = 'storage/items/'.$item->id.'.jpg';
            $image = '';
            if(file_exists(public_path($file))){
                $image = asset('storage/items/'.$item->id.'.jpg');
            }else{
                $image = ui_avatars_url($item->description,50,'none',0);
            }
            $data[$key] = [
                'id' => $item->id,
                'internal_id' => $item->id,
                'description' => $item->description,
                'purchase_unit_price' => $item->purchase_unit_price,
                'stock' => $item->stock,
                'name' => $item->name,
                'image_url' => $image,
            ];
        }

        return response()->json(['success'=>true,'data'=>$data], 200);
        
    }


    public function updateQuantityMaterial(Request $request){
        $value = $request->value;
        $id = $request->pk;
        $fun = $request->fun;
        $material = ProjectMaterial::where('id',$id);
        $price = $material->first()->unit_price;
        $state = $material->first()->state;

        $msg = Lang::get('messages.was_successfully_updated');
        $tit = Lang::get('messages.congratulations');
        $ico = 'success';

        if($state == 0){
            if($fun == 'qu'){
                $material->update([
                    'quantity' => $value,
                    'expenses' => ($value*$price)
                ]);
            }
        }else if($state == 2){
            if($fun == 'os'){
                $material->update([
                    'observations'=> $value,
                ]);
            }else if($fun == 'pe'){
                $tt = ($material->first()->pending_quantity + $material->first()->lost_quantity + $material->first()->obsolete_quantity + $value);
                if($tt <= $material->first()->quantity){
                    $material->update([
                        'pending_quantity'=>$value,
                    ]);
                }else{
                    $msg = 'Sobre paso la cantidad';
                    $tit = 'Error';
                    $ico = 'error';
                }
            }else if($fun == 'lo'){
                $tt = ($material->first()->pending_quantity + $material->first()->lost_quantity + $material->first()->obsolete_quantity + $value);
                if($tt <= $material->first()->quantity){
                    $material->update([
                        'lost_quantity'=>$value,
                    ]);
                }else{
                    $msg = 'Sobre paso la cantidad';
                    $tit = 'Error';
                    $ico = 'error';
                }
            }else if($fun == 'ob'){
                $tt = ($material->first()->pending_quantity + $material->first()->lost_quantity + $material->first()->obsolete_quantity + $value);
                if($tt <= $material->first()->quantity){
                    $material->update([
                        'obsolete_quantity'=>$value,
                    ]);
                }else{
                    $msg = 'Sobre paso la cantidad';
                    $tit = 'Error';
                    $ico = 'error';
                }
            }else if($fun == 'so'){
                if($value > 0){
                    $material->update([
                        'leftovers_quantity'=>$value,
                    ]);
                }
            }
        }else{
            $msg = 'El estado ya no corresponde para poder editar el valor';
            $tit = 'Error';
            $ico = 'error';
        }
        return response()->json(['success'=>true,'data'=>[
            'msg' => $msg,
            'tit' => $tit,
            'ico' => $ico
        ]], 200);
    }
    public function updatePriceMaterial(Request $request){
        $price = $request->value;
        $id = $request->pk;
        $material = ProjectMaterial::where('id',$id);
        $quantity = $material->first()->quantity;
        $material->update([
            'unit_price'=>$price,
            'expenses' => ($quantity*$price)
        ]);
    }

    public function searchSupplier(){
        return datatables()->eloquent($this->supplierJoin())->filter(function ($query) {
                            if (request()->has('supplier')) {
                                $query->where('trade_name', 'like', "%" . request('supplier') . "%");
                            }
                        })
                        ->toJson();
    }
    private function supplierJoin(){
        return Person::join('suppliers','suppliers.person_id','people.id')
            ->join('countries', 'people.country_id', '=', 'countries.id')
            ->join('departments', 'people.department_id', '=', 'departments.id')
            ->join('provinces', 'people.province_id', '=', 'provinces.id')
            ->join('districts', 'people.district_id', '=', 'districts.id')
            ->select(
                'suppliers.id',
                'countries.description As country_name',
                'departments.description AS department_name',
                'provinces.description AS province_name',
                'districts.description AS district_name',
                'people.number',
                'people.trade_name',
                'people.email'
            )
            ->limit(100);
    }
}
