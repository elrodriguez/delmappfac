<?php

namespace App\Http\Livewire\Master;

use App\Models\Master\Parameter;
use Livewire\Component;

class ParameterEditModal extends Component
{
    public $types;
    public $id_type;
    public $id_parameter;
    public $value_default;
    public $code_sql;
    public $description;
    public $display;
    public $parameter;
    public $parameter_id;

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
        return view('livewire.master.parameter-edit-modal');
    }

    public function update(){
        $this->validate([
            'id_type' => 'required',
            'id_parameter' => 'required|min:8|unique:parameters,id_parameter,'.$this->parameter_id,
            'value_default' => 'required|max:255',
            'description' => 'required|max:500'
        ]);

        Parameter::find($this->parameter_id)->update([
            'type' => $this->id_type,
            'code_sql' =>  $this->code_sql,
            'id_parameter' => strtoupper($this->id_parameter),
            'description' => $this->description,
            'value_default' => $this->value_default
        ]);

        $this->dispatchBrowserEvent('message-confir-modal-paramter-update',['valor' => true]);
    }

    public function changeType(){
        if($this->id_type == '1' || $this->id_type == '7' || $this->id_type == '8'){
            $this->display = false;
        }else{
            $this->display = true;
        }
    }

    public function loadParameter(){
        $this->parameter = Parameter::find($this->parameter_id);

        $this->id_type = $this->parameter->type;
        $this->code_sql = $this->parameter->code_sql;
        $this->id_parameter = $this->parameter->id_parameter;
        $this->description = $this->parameter->description;
        $this->value_default = $this->parameter->value_default;

        $this->changeType();
    }
}
