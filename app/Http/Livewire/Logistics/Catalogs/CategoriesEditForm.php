<?php

namespace App\Http\Livewire\Logistics\Catalogs;

use App\Models\Master\ItemCategory;
use Illuminate\Support\Facades\Lang;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CategoriesEditForm extends Component
{
    public $name;
    public $categories = [];
    public $item_category_id;
    public $state;
    public $category_id;

    public function mount($category_id){
        $this->category_id = $category_id;
        $category = ItemCategory::find($this->category_id);
        $this->item_category_id = $category->item_category_id;
        $this->name = $category->name;
        $this->state = $category->state;
    }
    public function render()
    {
        $this->categories = ItemCategory::where('state',true)
            ->whereNull('item_category_id')
            ->get();

        return view('livewire.logistics.catalogs.categories-edit-form');
    }

    public function update(){
        $this->validate([
            'name' => 'required'
        ]);
        $category = ItemCategory::find($this->category_id);

        ItemCategory::where('id',$this->category_id)->update([
            'name' => $this->name,
            'state' => ($this->state?$this->state:false),
            'item_category_id' => ($this->item_category_id?$this->item_category_id:null)
        ]);

        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(ItemCategory::class,$this->category_id);
        $activity->causedBy($user);
        $activity->routeOn(route('logistics_catalogs_categories_edit',$this->category_id));
        $activity->componentOn('logistics.catalogs.categories-edit-form');
        $activity->dataOld($category);
        $activity->logType('update');
        $activity->dataUpdated(ItemCategory::find($this->category_id));
        $activity->log(Lang::get('messages.was_successfully_updated'));
        $activity->save();

        $this->dispatchBrowserEvent('response_categories_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
