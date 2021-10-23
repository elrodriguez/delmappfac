<?php

namespace App\Imports;

use App\Models\Master\ItemCategory;
use App\Models\Warehouse\Brand;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\ItemBrand;
use App\Models\Warehouse\ItemWarehouse;
use App\Models\Warehouse\Kardex;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class ItemsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $brand_id = Brand::where('name',$row[7])->value('id');
        $category_id = ItemCategory::where('name',$row[8])->value('id');

        $item_type_id = str_pad($row[0], 2, "0", STR_PAD_LEFT);

        if($brand_id == null){
            if($row[7]){
                $brand_id = Brand::create([
                        'name' => $row[7]
                    ])->id;
            }
        }

        if($category_id == null){
            if($row[8]){
                $category_id = ItemCategory::create([
                    'name' => $row[8],
                    'state' => true
                ])->id;
            }
        }

        $item = Item::create([
            'name' => $row[3],
            'description' => $row[4],
            //'second_name' => $row[12]?$row[12]:null,
            'item_type_id' => $item_type_id,
            'internal_id' => $row[1],
            'unit_type_id' => $row[2],
            'currency_type_id' => 'PEN',
            'sale_unit_price' => $row[10],
            'purchase_unit_price' => $row[9],
            'has_isc' => 0,
            'system_isc_type_id' => null,
            'percentage_isc' => 0,
            'suggested_price' => 0,
            'sale_affectation_igv_type_id' => '10',
            'purchase_affectation_igv_type_id' => '10',
            'stock' => ($item_type_id == '01'?$row[6]:0),
            'stock_min' => ($item_type_id == '01'?$row[5]:0),
            'module_type' => 'PAL',
            'has_plastic_bag_taxes' => false,
            'has_igv' => true,
            'brand_id' => $brand_id,
            'category_id' => $category_id,
            //'digemid' => $row[11]?$row[11]:null,
        ]);
        if($brand_id){
            ItemBrand::create([
                'id_brand' => $brand_id,
                'id_item' => $item->id
            ]);
        }

        if($item_type_id == '01'){
            ItemWarehouse::create([
                'item_id' => $item->id,
                'warehouse_id' => 1,
                'stock'=> $row[6]
            ]);

            $inventory = Inventory::create([
                'type' => 1,
                'description' => 'Stock inicial',
                'item_id' => $item->id,
                'warehouse_id' => 1,
                'quantity' => $row[6]
            ]);

            Kardex::create([
                'date_of_issue'=> Carbon::now()->format('Y-m-d'),
                'item_id' => $item->id,
                'quantity' => $row[6]
            ]);

            InventoryKardex::create([
                'date_of_issue' => Carbon::now()->format('Y-m-d'),
                'item_id' => $item->id,
                'inventory_kardexable_id' => $inventory->id,
                'inventory_kardexable_type' => Inventory::class,
                'warehouse_id' => 1,
                'quantity' => $row[6]
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'internal_id' => 'required|regex:/^[a-zA-Z0-9_-]*$/|unique:items,internal_id',
            'unit_type_id' => 'required',
            'item_type_id' => 'required',
            'price_purchase' => 'required|numeric|between:0,99999999999.99',
            'stock_min' => 'required|numeric|between:0,99999999999.99',
            'stock' => 'required|numeric|between:0,99999999999.99'
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
