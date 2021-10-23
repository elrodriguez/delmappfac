<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Models\OnlineShop\ShoPromotion;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithFileUploads;

class PromotionsEdit extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $photo;
    public $image;
    public $url_action;
    public $total_price;
    public $state = true;
    public $promotion;
    public $promotion_id;

    public function mount($promotion_id){
        $this->promotion_id = $promotion_id;
    }

    public function render()
    {
        $this->promotion = ShoPromotion::find($this->promotion_id);
        $this->title = $this->promotion->title;
        $this->description = $this->promotion->description;
        $this->image = $this->promotion->image;
        $this->url_action = $this->promotion->url_action;
        $this->total_price = $this->promotion->total_price;
        $this->state = $this->promotion->state;
        return view('livewire.onlineshop.admin.promotions-edit');
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|max:40',
            'description' => 'required|max:40'
        ]);

        $userActivity = new Activity;
        $userActivity->dataOld(ShoPromotion::find($this->promotion->id));


        $this->promotion->update([
            'title' => $this->title,
            'description' => $this->description,
            'url_action' => $this->url_action,
            'total_price' => $this->total_price,
            'state' => $this->state?$this->state:0
        ]);

        if($this->photo){
            $this->photo->storeAs('promotions/', $this->promotion->id.'.png','public');
            $this->promotion->update(['image' => 'promotions/'. $this->promotion->id.'.png']);
        }

        $userActivity->causedBy(Auth::user());
        $userActivity->routeOn(route('onlineshop_administration_promotions_edit'));
        $userActivity->componentOn('onlineshop.admin.promotions-edit');
        $userActivity->log(Lang::get('messages.was_successfully_updated'));
        $userActivity->dataUpdated($this->promotion);
        $userActivity->logType('update');
        $userActivity->modelOn(ShoPromotion::class,$this->promotion->id);
        $userActivity->save();

        $this->dispatchBrowserEvent('response_promotion_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
