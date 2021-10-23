<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Models\OnlineShop\ShoItem;
use App\Models\OnlineShop\ShoItemsPromotions;
use App\Models\OnlineShop\ShoPromotion;
use Livewire\Component;

class PromotionsItems extends Component
{
    public $promotion_id;
    public $item_id;
    public $price;
    public $items;
    public $total;

    public function mount($promotion_id){
        $this->promotion_id = $promotion_id;
    }

    public function render()
    {
        $this->total = ShoPromotion::findOrFail($this->promotion_id)->total_price;
        $this->getItems();
        return view('livewire.onlineshop.admin.promotions-items');
    }
    public function selectPrice($id){
        $this->price = ShoItem::where('item_id',$id)->value('price');
    }
    public function addItem(){

        $this->validate([
            'item_id' => 'required',
            'price' => 'required|numeric|between:0,99999999999.99'
        ]);

        ShoItemsPromotions::create([
            'promotion_id' => $this->promotion_id,
            'item_id' => $this->item_id,
            'price' => $this->price
        ]);

        ShoPromotion::find($this->promotion_id)->increment('total_price',$this->price);

        $this->item_id = null;
        $this->price = null;
    }

    public function getItems(){
        $this->items = ShoItemsPromotions::join('items','sho_items_promotions.item_id','items.id')
            ->select(
                'sho_items_promotions.id',
                'items.description',
                'sho_items_promotions.price'
            )
            ->where('promotion_id',$this->promotion_id)
            ->get();
    }

    public function destroy($id){
        $data = ShoItemsPromotions::find($id);
        ShoPromotion::find($this->promotion_id)->decrement('total_price',$data->price);
        $data->delete();
        $this->dispatchBrowserEvent('item_promotion_delete');
    }
}
