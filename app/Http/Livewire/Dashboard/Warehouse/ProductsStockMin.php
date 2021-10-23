<?php

namespace App\Http\Livewire\Dashboard\Warehouse;

use App\Models\Warehouse\Item;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsStockMin extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.dashboard.warehouse.products-stock-min', [
            'products' => $this->productosStockMin(),
        ]);
    }

    public function productosStockMin(){
        return Item::leftJoin('item_brands','item_brands.id_item','items.id')
                    ->leftJoin('brands','item_brands.id_brand','brands.id')
                    ->where('item_type_id','01')
                    ->where('stock_min','>=',DB::raw('(SELECT SUM(quantity) FROM inventory_kardex WHERE inventory_kardex.item_id=items.id)'))
                    ->select(
                        'items.id',
                        'items.internal_id',
                        'items.stock_min',
                        DB::raw('CONCAT(brands.name," - ",items.description) AS description'),
                        DB::raw('(SELECT SUM(quantity) FROM inventory_kardex WHERE inventory_kardex.item_id=items.id) AS stock')
                    )
                    ->paginate(8);
    }
}
