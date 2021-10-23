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

class ProductServiceEditForm extends Component
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
    public $item_id;

    public function mount($item_id){
        $this->item_id = $item_id;
        $item = Item::find($this->item_id);
        $this->item_type_id = $item->item_type_id;
        $this->unit_type_id = $item->unit_type_id;
        $this->affectation_igv_type_id = $item->affectation_igv_type_id;
        $this->description = $item->description;
        $this->price = $item->sale_unit_price;
        $this->stock = $item->stock;
    }

    public function render()
    {
        $this->item_types = DB::table('item_types')->get();
        $this->unit_types = DB::table('unit_types')->where('active',1)->get();
        $this->affectation_igv_types = AffectationIgvType::where('active',1)->get();
        return view('livewire.academic.administration.product-service-edit-form');
    }

    public function update(){
        $this->validate([
            'description' => 'required|min:3|max:255',
            'price' => 'required|numeric|between:0,99999999999.99',
            'stock' => ($this->item_type_id=='01')?'required|numeric|between:0,99999999999.99':''

        ]);
        $item = Item::where('id',$this->item_id)->update([
            'description' => $this->description,
            'item_type_id' => $this->item_type_id,
            'unit_type_id' => $this->unit_type_id,
            'sale_unit_price' => $this->price,
            'sale_affectation_igv_type_id' => $this->affectation_igv_type_id
        ]);
        $this->dispatchBrowserEvent('response_success_product_service_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
