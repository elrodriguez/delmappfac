<?php

namespace App\Http\Livewire\Master;

use App\Models\Master\Parameter;
use Livewire\Component;

class ParameterCreateModal extends Component
{
    public $types;
    public $id_type;
    public $id_parameter;
    public $value_default;
    public $code_sql;
    public $description;
    public $display;

    public function mount(){
        $this->types = [
            ['id' => 1,'name' => 'Input'],
            ['id' => 2,'name' => 'Select Array'],
            ['id' => 3,'name' => 'Select Tabla'],
            ['id' => 4,'name' => 'Radio'],
            ['id' => 5,'name' => 'Chekbox'],
            ['id' => 6,'name' => 'Chekbox Multipe Array'],
            ['id' => 7,'name' => 'Chekbox Multipe Tabla'],
            ['id' => 8,'name' => 'Textarea']
        ];
    }

    public function render()
    {
        return view('livewire.master.parameter-create-modal');
    }


    public function store(){
        $this->validate([
            'id_type' => 'required',
            'id_parameter' => 'required|min:8|unique:parameters',
            'value_default' => 'required|max:255',
            'description' => 'required|max:500'
        ]);

        Parameter::create([
            'type' => $this->id_type,
            'code_sql' =>  $this->code_sql,
            'id_parameter' => strtoupper($this->id_parameter),
            'description' => $this->description,
            'value_default' => $this->value_default
        ]);

        $this->clearInput();
        $this->dispatchBrowserEvent('message-confir-modal-paramter',['valor' => true]);
    }

    public function clearInput(){
        $this->id_type = null;
        $this->code_sql = null;
        $this->id_parameter = null;
        $this->description = null;
        $this->value_default = null;
    }

    public function changeType(){
        if($this->id_type == '1' || $this->id_type == '7' || $this->id_type == '8'){
            $this->display = false;
        }else{
            $this->display = true;
        }
    }
}
