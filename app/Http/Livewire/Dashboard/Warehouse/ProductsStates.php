<?php

namespace App\Http\Livewire\Dashboard\Warehouse;

use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Item;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProductsStates extends Component
{
    public $products;
    public $stock_total;
    public $item_id;

    public function mount(){
        $this->item_id = Item::where('item_type_id','01')
                ->where('stock', DB::raw("(select max(stock) from items)"))
                ->limit(1)
                ->value('id');
        //dd($this->item_id);
        $this->productsStock();

    }

    public function render()
    {
        return view('livewire.dashboard.warehouse.products-states');
    }

    public function productsStock(){
        $this->products = Inventory::leftJoin('inventory_transactions','inventories.inventory_transaction_id','inventory_transactions.id')
                            ->select(
                                'inventory_transactions.description',
                                DB::raw('sum(inventories.quantity) AS total')
                            )
                            ->where('inventories.item_id',$this->item_id)
                            ->groupBY('inventory_transactions.description')
                            ->get();

        $this->stock_total = InventoryKardex::where('item_id',$this->item_id)
                    ->sum('quantity');
    }
}
