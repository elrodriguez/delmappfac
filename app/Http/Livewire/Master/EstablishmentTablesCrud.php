<?php

namespace App\Http\Livewire\Master;

use App\Models\Master\Board;
use Livewire\Component;

class EstablishmentTablesCrud extends Component
{
    public $tables;
    public $table_name;
    public $table_level;
    public $table_id_establishment;

    protected $rules = [
        'table_name' => 'required|min:1',
        'table_level' => 'required'
    ];

    public function mount($id_establishment){
        $this->table_id_establishment = $id_establishment;
        $this->list();
    }

    public function render()
    {
        return view('livewire.master.establishment-tables-crud');
    }
    public function addTable(){

        $this->validate();

        Board::create([
            'name' => $this->table_name,
            'id_establishment' => $this->table_id_establishment,
            'state' => true,
            'level' => $this->table_level
        ]);
        $this->list();
    }

    public function destroy($id_board){
        Board::where('id',$id_board)->delete();
        $this->list();
    }

    public function list(){
        $data = Board::orderBy('level')->orderBy('name')->get();
        $this->tables = $data;
    }
}
