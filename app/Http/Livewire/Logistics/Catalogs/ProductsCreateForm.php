<?php

namespace App\Http\Livewire\Logistics\Catalogs;

use App\Models\Catalogue\UnitType;
use App\Models\Master\ItemCategory;
use App\Models\Warehouse\Brand;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\ItemBrand;
use App\Models\Warehouse\ItemWarehouse;
use App\Models\Warehouse\Kardex;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithFileUploads;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;

class ProductsCreateForm extends Component
{
    public $description;
    public $internal_id;
    public $stock_min;
    public $stock;
    public $unit_types;
    public $unit_type_id;
    public $item_types;
    public $item_type_id;
    public $price_purchase;
    public $price_sale;
    public $module_type = 'PUC';
    public $brands = [];
    public $brand_id;
    public $file_image;
    public $has_icbper;
    public $categories = [];
    public $category_id;

    use WithFileUploads;


    public function render()
    {
        $this->unit_types = UnitType::where('active',1)->get();
        $this->item_types = DB::table('item_types')->get();
        $this->brands = Brand::all();
        $this->categories = ItemCategory::where('state',true)
            ->whereNotNull('item_category_id')
            ->get();
        return view('livewire.logistics.catalogs.products-create-form');
    }

    public function store(){
        $this->validate([
            'description' => 'required',
            'internal_id' => 'required|regex:/^[a-zA-Z0-9_-]*$/|unique:items,internal_id',
            'unit_type_id' => 'required',
            'item_type_id' => 'required',
            'module_type' => 'required',
            'price_purchase' => 'required|numeric|between:0,99999999999.99',
            'file_image' => 'file|mimes:jpg,png|max:10240',
            'category_id' => 'required'
        ]);

        if($this->item_type_id == '01'){
            $this->validate([
                'stock_min' => 'required|numeric|between:0,99999999999.99',
                'stock' => 'required|numeric|between:0,99999999999.99'
            ]);
        }

        $item = Item::create([
            'description' => $this->description,
            'item_type_id' => $this->item_type_id,
            'internal_id' => $this->internal_id,
            'unit_type_id' => $this->unit_type_id,
            'currency_type_id' => 'PEN',
            'sale_unit_price' => $this->price_sale,
            'purchase_unit_price' => $this->price_purchase,
            'has_isc' => 0,
            'system_isc_type_id' => null,
            'percentage_isc' => 0,
            'suggested_price' => 0,
            'sale_affectation_igv_type_id' => '10',
            'purchase_affectation_igv_type_id' => '10',
            'stock' => ($this->item_type_id == '01'?$this->stock:0),
            'stock_min' => ($this->item_type_id == '01'?$this->stock_min:0),
            'module_type' => $this->module_type,
            'has_plastic_bag_taxes' => ($this->has_icbper?$this->has_icbper:0),
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id
        ]);

        if($this->file_image){
            $this->file_image->storeAs('items/', $item->id.'.jpg','public');
        }

        if($this->brand_id){
            ItemBrand::create([
                'id_brand' => $this->brand_id,
                'id_item' => $item->id
            ]);
        }
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

        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(Establishment::class,$item->id);
        $activity->causedBy($user);
        $activity->routeOn(route('establishments_create'));
        $activity->componentOn('master.establishment-create-form');
        $activity->dataOld($item);
        $activity->logType('create');
        $activity->log(Lang::get('messages.successfully_registered'));
        $activity->save();

        $this->clearForm();
        $this->dispatchBrowserEvent('response_products_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    private function clearForm(){
        $this->description = null;
        $this->item_type_id = null;
        $this->internal_id = null;
        $this->unit_type_id = null;
        $this->price_sale = null;
        $this->price_purchase = null;
        $this->stock = null;
        $this->stock_min = null;
        $this->module_type = 'PUC';
        $this->has_icbper = null;
        $this->category_id = null;
    }
}
