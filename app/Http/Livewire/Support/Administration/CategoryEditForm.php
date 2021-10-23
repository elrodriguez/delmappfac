<?php

namespace App\Http\Livewire\Support\Administration;

use App\Models\Support\Administration\SupCategory;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CategoryEditForm extends Component
{
    public $name;
    public $description;
    public $category_id;
    public $state = true;
    public $categories;
    public $category;
    public $days;
    public $hours;
    public $minutes = 30;

    public function mount($category_id){
        $this->categories = SupCategory::where('state',1)->whereNull('sup_category_id')->get();
        $this->category = SupCategory::find($category_id);
        $this->name = $this->category->short_description;
        $this->description = $this->category->detailed_description;
        $this->category_id = $this->category->sup_category_id;
        $this->state = $this->category->state;
    }

    public function render()
    {
        return view('livewire.support.administration.category-edit-form');
    }

    public function update(){
        $this->validate([
            'name' => 'required|max:255',
            'description' => 'max:255'
        ]);

        SupCategory::find($this->category->id)->update([
            'short_description' => $this->name,
            'detailed_description' => $this->description,
            'state' => ($this->state?$this->state:false),
            'sup_category_id' => ($this->category_id?$this->category_id:null),
            'days' => ($this->days?$this->days:0),
            'hours' => ($this->hours?$this->hours:0),
            'minutes' => $this->minutes
        ]);

        $category = SupCategory::find($this->category->id);
        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(SupCategory::class,$this->category->id);
        $activity->causedBy($user);
        $activity->routeOn(route('support_administration_category_create'));
        $activity->componentOn('support.administration.category-create-form');
        $activity->dataOld($this->category);
        $activity->dataUpdated($category);
        $activity->logType('create');
        $activity->log('Registro nueva categoria');
        $activity->save();

        $this->dispatchBrowserEvent('response_success_supcategory_update', ['message' => Lang::get('messages.was_successfully_updated')]);

    }
}
