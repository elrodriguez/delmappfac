<?php

namespace App\Http\Livewire\Logistics\Catalogs;

use App\Models\Master\ItemCategory;
use Livewire\Component;
use Illuminate\Support\Facades\Lang;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;

class CategoriesCreateForm extends Component
{
    public $name;
    public $categories = [];
    public $category_id;
    public $state = true;

    public function render()
    {
        $this->categories = ItemCategory::where('state',true)
            ->whereNull('item_category_id')
            ->get();
        return view('livewire.logistics.catalogs.categories-create-form');
    }

    public function store(){
        $this->validate([
            'name' => 'required'
        ]);

        $category = ItemCategory::create([
            'name' => $this->name,
            'state' => ($this->state?$this->state:false),
            'item_category_id' => ($this->category_id?$this->category_id:null)
        ]);

        $this->name = null;
        $this->state = true;
        $this->category_id = null;

        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(ItemCategory::class,$category->id);
        $activity->causedBy($user);
        $activity->routeOn(route('logistics_catalogs_categories_create'));
        $activity->componentOn('logistics.catalogs.categories-create-form');
        $activity->dataOld($category);
        $activity->logType('create');
        $activity->log(Lang::get('messages.successfully_registered'));
        $activity->save();

        $this->dispatchBrowserEvent('response_categories_store', ['message' => Lang::get('messages.successfully_registered')]);
    }
}
