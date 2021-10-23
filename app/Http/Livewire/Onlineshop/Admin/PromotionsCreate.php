<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Models\OnlineShop\ShoPromotion;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithFileUploads;

class PromotionsCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $photo;
    public $url_action;
    public $total_price;
    public $state = true;

    public function render()
    {
        return view('livewire.onlineshop.admin.promotions-create');
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|max:40',
            'description' => 'required|max:40',
            'photo' => 'required|file|mimes:jpg,png|max:10240'
        ]);

        $promotion = ShoPromotion::create([
            'title' => $this->title,
            'description' => $this->description,
            'url_action' => $this->url_action,
            'total_price' => $this->total_price,
            'state' => $this->state?$this->state:0
        ]);

        if($this->photo){
            $this->photo->storeAs('promotions/', $promotion->id.'.png','public');
            $promotion->update(['image' => 'promotions/'. $promotion->id.'.png']);
        }
       

        $userActivity = new Activity;
        $userActivity->causedBy(Auth::user());
        $userActivity->routeOn(route('onlineshop_administration_promotions_create'));
        $userActivity->componentOn('onlineshop.admin.promotions-create');
        $userActivity->log(Lang::get('messages.successfully_registered'));
        $userActivity->dataOld($promotion);
        $userActivity->logType('create');
        $userActivity->modelOn(ShoPromotion::class,$promotion->id);
        $userActivity->save();

        $this->title = null;
        $this->description = null;
        $this->photo = null;
        $this->url_action = null;
        $this->total_price = null;
        $this->state = true;
        
        $this->dispatchBrowserEvent('response_promotion_store', ['message' => Lang::get('messages.successfully_registered')]);
    }
}
