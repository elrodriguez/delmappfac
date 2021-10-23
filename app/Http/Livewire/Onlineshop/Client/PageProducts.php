<?php

namespace App\Http\Livewire\Onlineshop\Client;

use App\Models\OnlineShop\ShoItem;
use Livewire\Component;
use Livewire\WithPagination;

class PageProducts extends Component
{
    public $search = '';

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function searchProducts()
    {
        $this->resetPage();
    }

    public function mount($search){
        $this->search = $search;
    }

    public function render()
    {
        return view('livewire.onlineshop.client.page-products',['products' => $this->getProducts($this->search)]);
    }

    public function getProducts($search){
        return ShoItem::join('items','sho_items.item_id','items.id')
                ->select(
                    'items.id',
                    'sho_items.title',
                    'sho_items.description',
                    'sho_items.color',
                    'sho_items.price',
                    'sho_items.stock', 
                    'sho_items.seo_url'
                )
                ->selectSub(function($query) {
                    $query->from('sho_item_galleries')->select('url')
                    ->whereColumn('sho_item_galleries.item_id','sho_items.item_id')
                    ->whereColumn('sho_item_galleries.shop_item_id','sho_items.id')
                    ->where('state',true)
                    ->where('principal',1)
                    ->orderBy('sho_item_galleries.id','DESC')
                    ->limit(1);
                }, 'image')
                ->where('sho_items.state',true)
                ->when($search, function ($query, $search) {
                    return $query->where('items.category_id', $search);
                })
                ->paginate(10);
    }
}
