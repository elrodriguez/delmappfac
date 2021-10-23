<?php

namespace App\Http\Livewire\Warehouse;

use Livewire\Component;
use App\Models\Catalogue\DocumentType;
use App\Models\Catalogue\UnitType;
use App\Models\Master\person;
use App\Models\Warehouse\Brand;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\ItemBrand;
use App\Models\Warehouse\ItemWarehouse;
use App\Models\Warehouse\Kardex;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\Warehouse\Purchase;
use App\Models\Warehouse\PurchaseItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class IncomeCreateForm extends Component
{
    public $document_type = 'GU75';
    public $search_product;
    public $item_code;
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
    public $unit_type_id = 'LBS';
    public $id_brand = null;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $document_types = DocumentType::whereIn('id',['GU75','NE76'])->where('active',1)->get();
        $brands = Brand::all();
        $measurements = UnitType::whereIn('id',['LBS','TNP'])->get();

        $items = Item::join('item_brands','item_brands.id_item','items.id')
                ->join('brands','item_brands.id_brand','brands.id')
                ->select(
                    'items.id',
                    'items.item_code',
                    'items.description',
                    'brands.name'
                )
                ->where('items.description','like','%'.$this->search_product.'%')
                ->orWhere('items.item_code','like','%'.$this->search_product.'%')
                ->orWhere('brands.name','like','%'.$this->search_product.'%')
                ->paginate(5);

        return view('livewire.warehouse.income-create-form',['document_types'=>$document_types,'items'=>$items,'measurements'=>$measurements,'brands'=>$brands]);
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
            'item_code' => ($this->checkmeout2?$auto_item_code:$this->item_code),
            'unit_type_id' => $this->unit_type_id,
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
            'item_code' => $item->item_code,
            'description' => $item->description,
            'quantity' => $this->quantity
        ];

        $this->clearProducts();
        array_push($this->purchase_items,$data);
    }

    public function addProductBox($id,$item_code,$description){

        $data = [
            'id' => $id,
            'item_code' => $item_code,
            'description' => $description,
            'quantity' => $this->quantity
        ];
        $key = array_search($id, array_column($this->purchase_items, 'id'));
        if($key === false){
            array_push($this->purchase_items,$data);
        }

    }

    public function removeItemProduct($key){
        unset($this->purchase_items[$key]);
    }

    public function saveDocument(){

        $this->validate([
            'document_serie' => 'required|max:4',
            'document_number' => 'required|numeric'
        ]);

        if($this->purchase_items){
            if($this->supplier_id){
                $supplier = Person::where('id',$this->supplier_id)->first();

                list($d,$m,$y) = explode('/',$this->f_issuance);
                $date_of_issue = $y.'-'.$m.'-'.$d;

                $purchase = Purchase::create([
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
                    'total' => 0
                ]);

                foreach($this->purchase_items as $item){
                    $itemJson = Item::where('id',$item['id'])->first();
                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'item_id' => $item['id'],
                        'item' => $itemJson,
                        'quantity' => $item['quantity'],
                        'unit_value' => 0,
                        'affectation_igv_type_id' => '10',
                        'total_base_igv' => 0,
                        'percentage_igv' => 0,
                        'total_igv' => 0,
                        'total_taxes' => 0,
                        'price_type_id' => '01',
                        'unit_price' => 0,
                        'total_value' => 0,
                        'total' => 0
                    ]);

                    Kardex::create([
                        'date_of_issue'=> Carbon::now()->format('Y-m-d'),
                        'type'=>'purchase',
                        'item_id' => $item['id'],
                        'purchase_id'=>$purchase->id,
                        'quantity'=>$item['quantity']
                    ]);

                    InventoryKardex::create([
                        'date_of_issue' => Carbon::now()->format('Y-m-d'),
                        'item_id' => $item['id'],
                        'inventory_kardexable_id' => $purchase->id,
                        'inventory_kardexable_type' => Purchase::class,
                        'warehouse_id' => 1,
                        'quantity'=>$item['quantity']
                    ]);

                    Item::where('id',$item['id'])->increment('stock', $item['quantity']);
                }
                $this->dispatchBrowserEvent('response_success_purchase', ['message' => Lang::get('messages.successfully_registered')]);
                $this->clearpurchase();

            }else{
                $this->dispatchBrowserEvent('response_supplier_id_error_empty', ['message' => Lang::get('messages.select_a_provider')]);
            }
        }else{
            $this->dispatchBrowserEvent('response_purchase_error_box_empty', ['message' => Lang::get('messages.add_products_to_tray')]);
        }
    }
    public function clearpurchase(){
        $this->document_serie = null;
        $this->document_number = null;
        $this->supplier_id = null;
        $this->purchase_items = [];
    }
    public function clearProducts(){
        $this->id_brand = null;
        $this->description = null;
        $this->item_code = null;
        $this->stock = null;
        $this->stock_min = null;
    }
}
