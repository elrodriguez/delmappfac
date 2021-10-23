<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Catalogue\IdentityDocumentType;
use App\Models\Catalogue\TransferReasonType;
use App\Models\Catalogue\TransportModeType;
use App\Models\Catalogue\UnitType;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\Brand;
use App\Models\Warehouse\DocumentFishing;
use App\Models\Warehouse\DocumentFishingDetail;
use App\Models\Warehouse\Fishing;
use App\Models\Warehouse\Pier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\WithPagination;

class FishingCreateForm extends Component
{
    public $serie;
    public $numero;
    public $f_issuance;
    public $f_transfer;
    public $customer_id;
    public $fishing_items = [];
    public $modo_traslado;
    public $motivo_traslado;
    public $medida = 'M36';
    public $peso;
    public $observacion;
    public $descripcion_traslado;
    public $paquetes;
    public $observaciones;
    public $pais_desde = 'PE';
    public $ubigeo_desde;
    public $pais_llegada = 'PE';
    public $ubigeo_llegada;
    public $transporte_tipo_documento;
    public $transporte_numero;
    public $transporte_nombre_o_razon_social;
    public $conductor_tipo_documento;
    public $conductor_numero;
    public $vehiculo_placa;
    public $search_product;
    public $nombre;
    public $descripcion;
    public $quantity;
    public $quantity_document;
    public $direccion_desde;
    public $direccion_llegada;
    public $pier_id;

    public $transport_mode_types = [];
    public $transfer_reason_types = [];
    public $unit_types = [];
    public $countries = [];
    public $ubigeo = [];
    public $identity_document_types = [];
    public $piers = [];

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $this->f_transfer = Carbon::now()->format('d/m/Y');
        $this->f_issuance = Carbon::now()->format('d/m/Y');
        $this->transport_mode_types = TransportModeType::all();
        $this->transfer_reason_types = TransferReasonType::all();
        $this->identity_document_types = IdentityDocumentType::all();
        $this->unit_types = DB::table('unit_types')->where('id','=','M36')->get();
        $this->countries = DB::table('countries')->where('active',1)->get();
        $this->piers = Pier::all();

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

        $this->ubigeo = json_encode($departments);

        $measurements = UnitType::whereIn('id',['LBS','TNP'])->get();
        $brands = Brand::all();
        $items = Fishing::where('description','like','%'.$this->search_product.'%')
                ->orWhere('name','like','%'.$this->search_product.'%')
                ->paginate(5);
        return view('livewire.warehouse.fishing-create-form',['items'=>$items,'measurements'=>$measurements,'brands'=>$brands]);
    }

    public function newFishing(){
        $this->validate([
            'nombre' => 'required',
            'quantity' => 'required|numeric|between:0,99999999999.99',
            'descripcion' => 'required'
        ]);

        $fishing= Fishing::create([
            'name' => $this->nombre,
            'description' => $this->descripcion,
            'stock' => $this->quantity
        ]);

        $data = [
            'id' => $fishing->id,
            'name' => $fishing->name,
            'description' => $fishing->description,
            'quantity' => $this->quantity
        ];
        $this->clearFishing();
        array_push($this->fishing_items,$data);
    }

    public function clearFishing(){
        $this->nombre = null;
        $this->descripcion = null;
        $this->quantity = null;
    }

    public function removeItemFishing($key){
        unset($this->fishing_items[$key]);
    }

    public function addFishingBox($id,$name,$description){

        $data = [
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'quantity' => 1
        ];
        $key = array_search($id, array_column($this->fishing_items, 'id'));
        if($key === false){
            array_push($this->fishing_items,$data);
        }

    }

    public function saveDocumentFishing(){

        $this->validate([
            'serie' => 'required|max:4',
            'numero' => 'required|numeric',
            'f_issuance' => 'required',
            'f_transfer' => 'required',
            'customer_id' => 'required',
            'modo_traslado' => 'required',
            'motivo_traslado' => 'required',
            'descripcion_traslado' => 'required',
            'medida' => 'required',
            'peso' => 'required',
            'paquetes' => 'required',
            'observaciones' => 'required',
            'pier_id' => 'required',
            'pais_desde' => 'required',
            'ubigeo_desde' => 'required',
            'direccion_desde' => 'required',
            'pais_llegada' => 'required',
            'ubigeo_llegada' => 'required',
            'direccion_llegada' => 'required',
            'transporte_tipo_documento' => 'required',
            'transporte_numero' => 'required',
            'transporte_nombre_o_razon_social' => 'required',
            'conductor_tipo_documento' => 'required',
            'conductor_numero' => 'required',
            'vehiculo_placa' => 'required'
        ]);

        if($this->fishing_items){
            if($this->customer_id){

                list($d,$m,$y) = explode('/',$this->f_issuance);
                $date_of_issue = $y.'-'.$m.'-'.$d;
                list($fd,$fm,$fy) = explode('/',$this->f_transfer);
                $date_of_transfer = $fy.'-'.$fm.'-'.$fd;
                //dd($date_of_issue);
                $auto_item_code = strtoupper(Str::random(10));

                list($sdp,$spv,$sds) = explode('*',$this->ubigeo_desde);
                list($ldp,$lpv,$lds) = explode('*',$this->ubigeo_llegada);

                $document_fishing = DocumentFishing::create([
                    'user_id' => Auth::id(),
                    'code_id' => $auto_item_code,
                    'serie' => $this->serie,
                    'numero' => $this->numero,
                    'transfer_description' => $this->descripcion_traslado,
                    'observations' => $this->observaciones,
                    'departure_address' => $this->direccion_desde,
                    'arrival_address' => $this->direccion_llegada,
                    'company_number' => $this->transporte_numero,
                    'company_description' => $this->transporte_nombre_o_razon_social,
                    'driver_number' => $this->conductor_numero,
                    'driver_plaque' => $this->vehiculo_placa,
                    'warehouse_id' => 1,
                    'customer_id' => $this->customer_id,
                    'mode_of_travel' => $this->modo_traslado,
                    'reason_for_transfer' => $this->motivo_traslado,
                    'measure_id' => $this->medida,
                    'departure_country_id' => $this->pais_desde,
                    'departure_department_id' => $sdp,
                    'departure_province_id' => $spv,
                    'departure_district_id' => $sds,
                    'arrival_country_id' => $this->pais_llegada,
                    'arrival_department_id' => $ldp,
                    'arrival_province_id' => $lpv,
                    'arrival_district_id' => $lds,
                    'company_document_type_id' => $this->transporte_tipo_documento,
                    'driver_document_type_id' => $this->conductor_tipo_documento,
                    'weight' => $this->peso,
                    'packages' => $this->paquetes,
                    'date_of_issue' => $date_of_issue,
                    'date_of_transfer' => $date_of_transfer,
                    'pier_id' => $this->pier_id
                ]);

                foreach($this->fishing_items as $item){
                    $itemJson = Fishing::where('id',$item['id'])->first();
                    DocumentFishingDetail::create([
                        'quantity' => $item['quantity'],
                        'unit_type_id' => $this->medida,
                        'item' => $itemJson,
                        'fishing_id' => $item['id'],
                        'document_fishing_id' => $document_fishing->id
                    ]);

                    Fishing::where('id',$item['id'])->increment('stock', $item['quantity']);

                }
                $this->dispatchBrowserEvent('response_success_fishing', ['message' => Lang::get('messages.successfully_registered')]);
                $this->clearDocumentFishing();

            }else{
                $this->dispatchBrowserEvent('response_customer_id_error_empty', ['message' => Lang::get('messages.select_a_provider')]);
            }
        }else{
            $this->dispatchBrowserEvent('response_fishing_error_box_empty', ['message' => Lang::get('messages.add_products_to_tray')]);
        }
    }
    public function clearDocumentFishing(){
        $this->serie = null;
        $this->numero = null;
        $this->descripcion_traslado = null;
        $this->observaciones = null;
        $this->direccion_desde = null;
        $this->direccion_llegada = null;
        $this->transporte_numero = null;
        $this->transporte_nombre_o_razon_social = null;
        $this->conductor_numero = null;
        $this->vehiculo_placa = null;
        $this->customer_id = null;
        $this->modo_traslado = null;
        $this->motivo_traslado = null;
        $this->pais_desde = 'PE';
        $this->pais_llegada = 'PE';
        $this->transporte_tipo_documento = null;
        $this->conductor_tipo_documento = null;
        $this->peso = null;
        $this->paquetes = null;
        $this->pier_id = null;
        $this->f_transfer = Carbon::now()->format('d/m/Y');
        $this->f_issuance = Carbon::now()->format('d/m/Y');
        $this->fishing_items = [];
    }

    public function searchProduct(){
        $this->resetPage();
    }
}
