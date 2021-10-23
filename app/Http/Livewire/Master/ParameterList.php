<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Master\Parameter;
use Illuminate\Support\Facades\Lang;

class ParameterList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $value_default = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        return view('livewire.master.parameter-list',['parameters'=> $this->list()]);
    }

    public function changeValueDefaultSave($idparamert,$key){
        Parameter::where('id',$idparamert)->update(['value_default'=>$this->value_default[$key]]);
        $this->dispatchBrowserEvent('response_parameter_value_default_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }

    public function list(){
        $data = Parameter::where('description', 'like', '%'.$this->search.'%')->paginate(10);
        foreach($data as $key => $item){
            if($item->type == 5){
                $this->value_default[$key] = (int) $item->value_default;
            }else{
                $this->value_default[$key] = $item->value_default;
            }
        }

        return $data;
    }
}
