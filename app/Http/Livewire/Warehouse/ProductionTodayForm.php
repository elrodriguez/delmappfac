<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Warehouse\Brand;
use App\Models\Warehouse\DocumentProduction;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\ItemBrand;
use App\Models\Warehouse\Kardex;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProductionTodayForm extends Component
{
    public $brands;
    public $items = [];
    public $empresa;
    public $producto;
    public $fecha;
    public $pallets = 0;
    public $filas = 0;
    public $canastillas = 0;
    public $cubetas = 0;
    public $cajas = 0;
    public $unidades = 0;
    public $total;

    protected $rules = [
        'empresa' => 'required',
        'producto' => 'required',
        'fecha' => 'required',
        'pallets' => 'required|numeric',
        'filas' => 'required|numeric',
        'canastillas' => 'required|numeric',
        'cajas' => 'required|numeric',
        'unidades' => 'required|numeric',
        'total' => 'required'
    ];

    public function mount(){
        $this->brands = Brand::all();
        $this->fecha = Carbon::now()->format('d/m/Y');
    }

    public function render()
    {
        if(!empty($this->empresa)) {
            $this->items = ItemBrand::join('items','item_brands.id_item','items.id')
            ->select('items.id','items.item_code','items.description')
            ->where('item_brands.id_brand',$this->empresa)->get();
        }
        return view('livewire.warehouse.production-today-form');
    }

    public function calculateTotal(){
        if($this->producto){
            $item = ItemBrand::where('id_item',$this->producto)->where('id_brand',$this->empresa)->first();
            $pallets = ($this->pallets*$item->pallet_multiplo);
            $filas = ($this->filas*$item->fila_multiplo);
            $canastillas = ($this->canastillas*$item->canastilla_multiplo);
            $cubetas = ($this->cubetas*$item->cubeta_multiplo);
            $cajas = ($this->cajas*$item->caja_multiplo);
            $unidades = ($this->unidades*$item->unidad_multiplo);
            $this->total = ($pallets+$filas+$canastillas+$cubetas+$cajas+$unidades);
        }else{
            $this->dispatchBrowserEvent('response_calculate_total', ['message' => Lang::get('messages.select_container')]);
        }

    }

    public function storeProduction(){

        $this->validate();

        $item = ItemBrand::join('items','item_brands.id_item','items.id')
            ->select(
                'items.stock',
                'item_brands.value_dividend',
                'item_brands.pallet_multiplo'
            )
            ->where('id_item',$this->producto)
            ->where('id_brand',$this->empresa)
            ->first();

        if($this->total <= $item->stock){
            $auto_code_id = strtoupper(Str::random(10));
            $quantity_production = ($item->stock - $this->total);
            //dd($quantity_production);
            $quantity_boxes = ($quantity_production/$item->value_dividend);
            list($d,$m,$y) = explode('/',$this->fecha);
            $date = $y.'-'.$m.'-'.$d;

            $document_production = DocumentProduction::create([
                'code_id' => $auto_code_id,
                'item_id' => $this->producto,
                'brand_id' => $this->empresa,
                'warehouse_id' => 1,
                'quantity' => $quantity_production,
                'date_of_issue' => $date,
                'quantity_boxes' => $quantity_boxes,
                'pallets' => $this->pallets,
                'filas' => $this->filas,
                'canastillas' => $this->canastillas,
                'cajas' => $this->cajas,
                'unidades' => $this->unidades,
                'cubetas' => $this->cubetas
            ]);

            Item::where('id',$this->producto)->decrement('stock', $quantity_production);

            Kardex::create([
                'date_of_issue'=> Carbon::now()->format('Y-m-d'),
                'type'=> 'sale',
                'item_id' => $this->producto,
                'document_production_id'=>$document_production->id,
                'quantity' => $quantity_production
            ]);

            InventoryKardex::create([
                'date_of_issue' => Carbon::now()->format('Y-m-d'),
                'item_id' => $this->producto,
                'inventory_kardexable_id' => $document_production->id,
                'inventory_kardexable_type' => DocumentProduction::class,
                'warehouse_id' => 1,
                'quantity'=> $quantity_production
            ]);

            $this->dispatchBrowserEvent('response_save_document_production', ['message' => Lang::get('messages.successfully_registered')]);
            $this->clearForm();
        }else{
            $this->dispatchBrowserEvent('response_validate_total_stock', ['message' => Lang::get('messages.does_not_have_enough_units')]);
        }

    }

    public function clearForm(){
        $this->empresa = null;
        $this->producto = null;
        $this->fecha = Carbon::now()->format('d/m/Y');
        $this->pallets = 0;
        $this->filas = 0;
        $this->canastillas = 0;
        $this->cubetas = 0;
        $this->cajas = 0;
        $this->unidades = 0;
        $this->total =  null;
    }
}
