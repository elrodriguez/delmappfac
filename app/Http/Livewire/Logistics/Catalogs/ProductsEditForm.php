<?php

namespace App\Http\Livewire\Logistics\Catalogs;

use App\Models\Catalogue\UnitType;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\ItemBrand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Models\Warehouse\Brand;
use App\Models\Master\ItemCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductsEditForm extends Component
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
    public $product_id;
    public $brands = [];
    public $brand_id;
    public $file_image= null;
    public $has_icbper;
    public $categories = [];
    public $category_id;

    use WithFileUploads;

    public function mount($product_id){
        $this->product_id = $product_id;

        $product = Item::where('id',$this->product_id)->first();

        $this->description  = $product->description;
        $this->internal_id  = $product->internal_id;
        $this->stock_min  = $product->stock_min;
        $this->stock  = $product->stock;
        $this->unit_type_id  = $product->unit_type_id;
        $this->item_type_id  = $product->item_type_id;
        $this->price_purchase  = $product->purchase_unit_price;
        $this->price_sale  = $product->sale_unit_price;
        $this->module_type  = $product->module_type;
        $this->has_icbper  = $product->has_plastic_bag_taxes;
        $this->brand_id =  $product->brand_id;
        $this->category_id =  $product->category_id;
    }

    public function render()
    {
        $this->unit_types = UnitType::where('active',1)->get();
        $this->item_types = DB::table('item_types')->get();
        $this->brands = Brand::all();
        $this->categories = ItemCategory::where('state',true)
            ->whereNull('item_category_id')
            ->get();

        return view('livewire.logistics.catalogs.products-edit-form');
    }

    public function update(){
        $this->validate([
            'description' => 'required',
            'internal_id' => 'required|regex:/^[a-zA-Z0-9_-]*$/|unique:items,internal_id,'.$this->product_id,
            'unit_type_id' => 'required',
            'item_type_id' => 'required',
            'module_type' => 'required',
            'price_purchase' => 'required|numeric|between:0,99999999999.99',
            'price_sale' => 'required|numeric|between:0,99999999999.99',
            'file_image' => 'max:10240'
        ]);

        if($this->item_type_id == '01'){
            $this->validate([
                'stock_min' => 'required|numeric|between:0,99999999999.99'
            ]);
        }

        Item::where('id',$this->product_id)->update([
            'description' => $this->description,
            'item_type_id' => $this->item_type_id,
            'internal_id' => $this->internal_id,
            'unit_type_id' => $this->unit_type_id,
            'sale_unit_price' => $this->price_sale,
            'purchase_unit_price' => $this->price_purchase,
            'stock_min' => ($this->item_type_id == '01'?$this->stock_min:0),
            'module_type' => $this->module_type,
            'has_plastic_bag_taxes' => ($this->has_icbper?$this->has_icbper:0),
            'brand_id' => ($this->brand_id?$this->brand_id:null),
            'category_id' => $this->category_id
        ]);

        if(isset($this->file_image)){
            $this->file_image->storeAs('items/', $this->product_id.'.jpg','public');
        }

        //,.jpeg,.png,.gif,.bmp,.tiff

        if($this->item_type_id == '01'){
            if($this->brand_id){
                ItemBrand::where('id_item',$this->product_id)->delete();
                ItemBrand::create([
                    'id_brand' => $this->brand_id,
                    'id_item' => $this->product_id
                ]);
            }
        }
        $this->dispatchBrowserEvent('response_products_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
