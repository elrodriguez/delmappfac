<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Catalogue\AffectationIgvType;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\ItemWarehouse;
use App\Models\Warehouse\Kardex;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ProductServiceCreateForm extends Component
{
    public $item_types = [];
    public $unit_types = [];
    public $item_type_id = '02';
    public $unit_type_id = 'ZZ';
    public $affectation_igv_types = [];
    public $affectation_igv_type_id = '10';
    public $description;
    public $price;
    public $stock;

    public function render()
    {
        $this->item_types = DB::table('item_types')->get();
        $this->unit_types = DB::table('unit_types')->where('active',1)->get();
        $this->affectation_igv_types = AffectationIgvType::where('active',1)->get();
        return view('livewire.academic.administration.product-service-create-form');
    }

    public function store(){
        $this->validate([
            'description' => 'required|min:3|max:255',
            'price' => 'required|numeric|between:0,99999999999.99',
            'stock' => ($this->item_type_id=='01')?'required|numeric|between:0,99999999999.99':''

        ]);
        $auto_item_code = strtoupper(Str::random(5));
        $item = Item::create([
            'description' => $this->description,
            'item_type_id' => $this->item_type_id,
            'item_code' => $auto_item_code,
            'unit_type_id' => $this->unit_type_id,
            'currency_type_id'  => 'PEN',
            'sale_unit_price' => $this->price,
            'purchase_unit_price' => 0,
            'percentage_isc' => 0,
            'suggested_price' => 0,
            'sale_affectation_igv_type_id' => $this->affectation_igv_type_id,
            'purchase_affectation_igv_type_id' => '10',
            'stock' => ($this->item_type_id == '01'?$this->stock:1),
            'stock_min' => 1,
            'module_type' => 'ACD'
        ]);

        if($this->item_type_id == '01'){
            ItemWarehouse:: create([
                'item_id' => $item->id,
                'warehouse_id' => 1,
                'stock'=> $this->stock
            ]);

            $inventory = Inventory::create([
                'type' => 1,
                'description' => 'Stock inicial',
                'item_id' => $item->id,
                'warehouse_id' => 1,
                'quantity' => $this->stock
            ]);

            Kardex::create([
                'date_of_issue'=> Carbon::now()->format('Y-m-d'),
                'item_id' => $item->id,
                'quantity' => $this->stock
            ]);

            InventoryKardex::create([
                'date_of_issue' => Carbon::now()->format('Y-m-d'),
                'item_id' => $item->id,
                'inventory_kardexable_id' => $inventory->id,
                'inventory_kardexable_type' => Inventory::class,
                'warehouse_id' => 1,
                'quantity' => $this->stock
            ]);
        }
        $this->dispatchBrowserEvent('response_success_product_service', ['message' => Lang::get('messages.successfully_registered')]);
        $this->clearForm();
    }

    public function clearForm(){
        $this->description = null;
        $this->price = null;
        $this->stock = null;
    }
}
