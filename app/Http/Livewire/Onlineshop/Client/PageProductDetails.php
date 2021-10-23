<?php

namespace App\Http\Livewire\Onlineshop\Client;

use App\Models\OnlineShop\ShoItem;
use Livewire\Component;

class PageProductDetails extends Component
{
    public $seourl;
    public $product;
    public $price_total;
    public $price;
    public $quantity = 1;

    public function mount($seourl){
        $this->seourl = $seourl;

        $this->product = ShoItem::where('seo_url',$seourl)
            ->select(
                'title',
                'description',
                'stock',
                'price'
            )
            ->selectSub(function($query) {
                $query->from('sho_item_galleries')->selectRaw('CONCAT("[",GROUP_CONCAT(JSON_OBJECT("url",url)),"]")')
                ->whereColumn('sho_item_galleries.item_id','sho_items.item_id')
                ->whereColumn('sho_item_galleries.shop_item_id','sho_items.id')
                ->where('state',true)
                ->orderBy('sho_item_galleries.id','DESC');
            }, 'images')
            ->first();

        $this->price = $this->product->price;

    }
    public function render()
    {
        $this->price_total = ($this->price * $this->quantity);
        return view('livewire.onlineshop.client.page-product-details');
    }
}
