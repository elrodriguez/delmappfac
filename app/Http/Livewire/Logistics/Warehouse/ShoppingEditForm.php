<?php

namespace App\Http\Livewire\Logistics\Warehouse;

use Livewire\Component;
use App\Models\Catalogue\DocumentType;
use App\Models\Catalogue\UnitType;
use App\Models\Master\Person;
use App\Models\Warehouse\Item;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\Warehouse\Purchase;
use App\Models\Warehouse\PurchaseItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse\Brand;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\ItemBrand;
use App\Models\Warehouse\ItemWarehouse;
use App\Models\Warehouse\Kardex;

class ShoppingEditForm extends Component
{
    public $document_type = 'GU75';
    public $item_code = null;
    public $search_product;
    public $internal_id;
    public $description;
    public $stock;
    public $stock_min;
    public $purchase_items = [];
    public $checkmeout2 = 1;
    public $document_serie;
    public $document_number;
    public $f_issuance;
    public $f_expiration;
    public $supplier_id;
    public $quantity = 1;
    public $purchase_id;
    public $supplier_name;
    public $unit_type_id = 'LBS';
    public $id_brand = null;
    public $warehouse_id = 1;
    public $items = [];

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount($id_shopping){

        $this->purchase_id = $id_shopping;

        $purchase_items = PurchaseItem::join('purchases','purchase_items.purchase_id','purchases.id')
            ->where('purchases.id',$id_shopping)
            ->select(
                'purchase_items.item_id',
                'purchase_items.item',
                'purchase_items.quantity',
                'purchase_items.unit_value',
                'purchases.*',
                'purchases.supplier'
            )->get();
        $supplier_name = null;
        foreach($purchase_items as $key => $purchase_item){
            $this->purchase_items[$key] = [
                'id' => $purchase_item->item_id,
                'internal_id' => json_decode($purchase_item->item)->internal_id,
                'description' => json_decode($purchase_item->item)->description,
                'quantity' => $purchase_item->quantity,
                'purchase_unit_price' => $purchase_item->unit_value,
                'new_item' => 0
            ];
            $this->document_serie = $purchase_item->series;
            $this->document_number = $purchase_item->number;
            $this->supplier_id = $purchase_item->supplier_id;
            $this->f_issuance = Carbon::parse($purchase_item->date_of_issue)->format('d/m/Y');
            $this->f_expiration = Carbon::parse($purchase_item->date_of_issue)->format('d/m/Y');
            $this->supplier_name = json_decode($purchase_item->supplier)->trade_name;
        }
    }

    public function render()
    {
        $document_types = DocumentType::whereIn('id',['01','03','GU75','NE76'])->where('active',1)->get();

        $brands = Brand::all();
        $measurements = UnitType::where('active',1)->get();

        $search = $this->search_product;
        if($search){
            $this->items = Item::leftJoin('item_brands','item_brands.id_item','items.id')
                ->leftJoin('brands','item_brands.id_brand','brands.id')
                ->select(
                    'items.id',
                    'items.internal_id',
                    'items.description',
                    'brands.name',
                    'items.purchase_unit_price'
                )
                ->when($search, function ($query, $search) {
                    return $query->where(function($query) use($search){
                        $query->where('items.description','like','%'.$search.'%')
                        ->orWhere('items.internal_id','like','%'.$search.'%');
                    });
                })
                ->where('items.item_type_id','=','01')
                ->get();
            $this->search_product = null;
        }


        return view('livewire.logistics.warehouse.shopping-edit-form',['document_types'=>$document_types,'measurements'=>$measurements,'brands'=>$brands]);
    }
    public function searchProduct(){
        $this->resetPage();
    }

    public function newProduct(){

        $this->validate([
            'description' => 'required',
            'stock' => 'required|numeric|between:0,99999999999.99',
            'stock_min' => 'required|numeric|between:0,99999999999.99',
            'id_brand' => 'required',
            'unit_type_id' => 'required'
        ]);

        $auto_item_code = strtoupper(Str::random(5));

        $item = Item::create([
            'description' => $this->description,
            'item_type_id' => '01',
            //'item_code' => ($this->checkmeout2?$auto_item_code:$this->item_code),
            'unit_type_id' => 'NIU',
            'currency_type_id' => 'PEN',
            'sale_unit_price' => 0,
            'purchase_unit_price' => 0,
            'percentage_isc' => 0,
            'suggested_price' => 0,
            'sale_affectation_igv_type_id' => '10',
            'purchase_affectation_igv_type_id' => '10',
            'stock' => $this->stock,
            'stock_min' => $this->stock_min
        ]);

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

        ItemBrand::create([
            'id_brand' => $this->id_brand,
            'id_item' => $item->id
        ]);

        $data = [
            'id' => $item->id,
            'internal_id' => $item->internal_id,
            'description' => $item->description,
            'quantity' => $this->quantity
        ];

        $this->clearProducts();
        array_push($this->purchase_items,$data);
    }

    public function addProductBox($id,$internal_id,$description,$purchase_unit_price){

        $data = [
            'id' => $id,
            'internal_id' => $internal_id,
            'description' => $description,
            'quantity' => $this->quantity,
            'purchase_unit_price' => $purchase_unit_price,
            'new_item' => 1
        ];
        $key = array_search($id, array_column($this->purchase_items, 'id'));
        if($key === false){
            array_push($this->purchase_items,$data);
        }

    }

    public function removeItemProduct($key){
        unset($this->purchase_items[$key]);
    }

    public function updateDocument(){

        $this->validate([
            'document_serie' => 'required|max:4',
            'document_number' => 'required|numeric'
        ]);
        if ($this->purchase_items > 0) {
            foreach($this->purchase_items as $key => $val)
            {
                $this->validate([
                    'purchase_items.'.$key.'.quantity' => 'required|numeric|between:0,99999999999.99',
                    'purchase_items.'.$key.'.purchase_unit_price' => 'required|numeric|between:0,99999999999.99'
                ]);
            }
        }

        if($this->purchase_items){
            if($this->supplier_id){
                $supplier = Person::where('id',$this->supplier_id)->first();

                list($d,$m,$y) = explode('/',$this->f_issuance);
                $date_of_issue = $y.'-'.$m.'-'.$d;
                $total_Documento = 0;
                foreach($this->purchase_items as $item){
                    $total_Documento += (int) $item['quantity']*(int) $item['purchase_unit_price'];
                }

                Purchase::where('id',$this->purchase_id)->update([
                    'user_id' => Auth::id(),
                    'establishment_id' => 1,
                    'document_type_id'=> $this->document_type,
                    'series' => $this->document_serie,
                    'number' => $this->document_number,
                    'date_of_issue' => $date_of_issue,
                    'time_of_issue' => date('H:i:s'),
                    'supplier_id' => $this->supplier_id,
                    'supplier' => $supplier,
                    'currency_type_id'=>'PEN',
                    'exchange_rate_sale' => 0,
                    'total' => $total_Documento
                ]);

                $purchase_items = PurchaseItem::where('purchase_id',$this->purchase_id)->get();

                foreach($purchase_items as $purchase_item){
                    Item::where('id',$purchase_item->item_id)->decrement('stock', $purchase_item->quantity);
                    ItemWarehouse::where('item_id',$purchase_item->item_id)->where('warehouse_id',$this->warehouse_id)->increment('stock', $purchase_item->quantity);
                    InventoryKardex::create([
                        'date_of_issue' => Carbon::now()->format('Y-m-d'),
                        'item_id' => $purchase_item->item_id,
                        'inventory_kardexable_id' => $this->purchase_id,
                        'inventory_kardexable_type' => Purchase::class,
                        'warehouse_id' => $this->warehouse_id,
                        'quantity'=>(-$purchase_item->quantity)
                    ]);
                    //dd($itemTempJson);
                }

                PurchaseItem::where('purchase_id',$this->purchase_id)->delete();
                //Kardex::where('purchase_id',$this->purchase_id)->delete();


                foreach($this->purchase_items as $item){

                    $itemJson = Item::where('id',$item['id'])->first();

                    PurchaseItem::create([
                        'purchase_id' => $this->purchase_id,
                        'item_id' => $item['id'],
                        'item' => $itemJson,
                        'quantity' => $item['quantity'],
                        'unit_value' => $item['purchase_unit_price'],
                        'affectation_igv_type_id' => '10',
                        'total_base_igv' => 0,
                        'percentage_igv' => 0,
                        'total_igv' => 0,
                        'total_taxes' => 0,
                        'price_type_id' => '01',
                        'unit_price' => 0,
                        'total_value' => 0,
                        'total' => (int) $item['quantity']* (int) $item['purchase_unit_price']
                    ]);

                    ItemWarehouse::where('item_id',$item['id'])->where('warehouse_id',$this->warehouse_id)->increment('stock', $item['quantity']);

                    Kardex::create([
                        'date_of_issue'=> Carbon::now()->format('Y-m-d'),
                        'type'=>'purchase',
                        'item_id' => $item['id'],
                        'purchase_id'=>$this->purchase_id,
                        'quantity'=>$item['quantity']
                    ]);

                    InventoryKardex::create([
                        'date_of_issue' => Carbon::now()->format('Y-m-d'),
                        'item_id' => $item['id'],
                        'inventory_kardexable_id' => $this->purchase_id,
                        'inventory_kardexable_type' => Purchase::class,
                        'warehouse_id' => $this->warehouse_id,
                        'quantity'=>$item['quantity']
                    ]);

                    Item::where('id',$item['id'])->increment('stock', $item['quantity']);
                }
                $this->dispatchBrowserEvent('response_success_purchase', ['message' => Lang::get('messages.successfully_registered')]);
            }else{
                $this->dispatchBrowserEvent('response_supplier_id_error_empty', ['message' => Lang::get('messages.select_a_provider')]);
            }
        }else{
            $this->dispatchBrowserEvent('response_purchase_error_box_empty', ['message' => Lang::get('messages.add_products_to_tray')]);
        }
    }

    public function clearProducts(){
        $this->id_brand = null;
        $this->description = null;
        $this->internal_id = null;
        $this->stock = null;
        $this->stock_min = null;
    }
}

