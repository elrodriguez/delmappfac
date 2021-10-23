<?php

namespace App\Http\Livewire\Support\Administration;

use App\Models\Support\Administration\SupCategory;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CategoryCreateForm extends Component
{
    public $name;
    public $description;
    public $category_id;
    public $state = true;
    public $categories;
    public $days;
    public $hours;
    public $minutes = 30;

    public function mount(){

    }
    public function render()
    {
        $this->categories = SupCategory::where('state',1)->whereNull('sup_category_id')->get();
        return view('livewire.support.administration.category-create-form');
    }

    public function store(){
        $this->validate([
            'name' => 'required|max:255',
            'description' => 'max:255'
        ]);

        $category = SupCategory::create([
            'short_description' => $this->name,
            'detailed_description' => $this->description,
            'state' => ($this->state?$this->state:false),
            'sup_category_id' => ($this->category_id?$this->category_id:null),
            'days' => ($this->days?$this->days:0),
            'hours' => ($this->hours?$this->hours:0),
            'minutes' => $this->minutes
        ]);

        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(SupCategory::class,$category->id);
        $activity->causedBy($user);
        $activity->routeOn(route('support_administration_category_create'));
        $activity->componentOn('support.administration.category-create-form');
        $activity->dataOld($category);
        $activity->logType('create');
        $activity->log('Registro nueva categoria');
        $activity->save();

        $this->clearForm();
        $this->dispatchBrowserEvent('response_success_supcategory_store', ['message' => Lang::get('messages.successfully_registered')]);

    }

    public function clearForm(){
        $this->name = null;
        $this->description = null;
        $this->state = true;
        $this->category_id = null;
    }
}
