<?php

namespace App\Http\Livewire\Onlineshop\Client;

use App\Models\OnlineShop\ShoPromotion;
use Livewire\Component;

class CarouselPromotions extends Component
{
    public $promotions;

    public function mount(){
        $this->promotions = ShoPromotion::where('state',true)->get();
    }

    public function render()
    {
        return view('livewire.onlineshop.client.carousel-promotions');
    }
}
