<?php

namespace App\Http\Livewire\Warehouse;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Warehouse\InventoryKardex;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\Purchase;
use App\Models\Warehouse\Brand;
use App\Models\Warehouse\ItemBrand;
use Illuminate\Support\Carbon;

class MaterialsList extends Component
{
    public $brands;
    public $items = [];
    public $warehouse_id = 1;
    public $item_id;
    public $date_start;
    public $date_end;
    public $materials = [];

    public function mount(){
        $this->date_start = Carbon::now()->format('d/m/Y');
        $this->date_end = Carbon::now()->format('d/m/Y');
        $this->brands = Brand::all();

        $this->materialslist();
    }

    public function render()
    {
        if(!empty($this->warehouse_id)) {
            $this->items = ItemBrand::join('items','item_brands.id_item','items.id')
            ->select('items.id','items.item_code','items.description')
            ->where('item_brands.id_brand',$this->warehouse_id)->get();
        }
        return view('livewire.warehouse.materials-list');
    }

    public function materialslist(){
        $item_id = $this->item_id;
        $warehouse_id = $this->warehouse_id;

        $this->materials = ItemBrand::join('items','item_brands.id_item','items.id')
            ->join('brands','item_brands.id_brand','brands.id')
            ->select(
                'items.id',
                'items.item_code',
                'brands.name',
                'items.description',
                'items.stock'
            )
            ->where('brands.id',$warehouse_id)
            ->when($item_id, function ($query,$item_id) {
                return $query->where('items.id', $item_id);
            })->get();
    }
    public function materialslistChangeSelect(){
        $this->item_id = null;
        $warehouse_id = $this->warehouse_id;

        $this->materials = ItemBrand::join('items','item_brands.id_item','items.id')
            ->join('brands','item_brands.id_brand','brands.id')
            ->select(
                'items.item_code',
                'brands.name',
                'items.description',
                'items.stock'
            )
            ->where('brands.id',$warehouse_id)
            ->when($this->item_id, function ($query,$item_id) {
                return $query->where('items.id', $item_id);
            })->get();
    }
}
