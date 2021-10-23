<?php

namespace App\Http\Livewire\Logistics\Production;

use App\Models\Logistics\Production\Project;
use App\Models\Logistics\Production\Stage;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ProjectStagesForm extends Component
{
    public $description;
    public $stages = [];
    public $project_id;
    public $project_description;

    public function mount($project_id){
        $this->project_id = $project_id;
        $project = Project::find($project_id);
        $this->project_description = $project->description;
    }

    public function render()
    {
        $this->stages = Stage::where('project_id',$this->project_id)->orderBy('number_order')->get();
        return view('livewire.logistics.production.project-stages-form');
    }

    public function store(){
        $this->validate([
            'description' => 'required|max:255'
        ]);
        $number_order = Stage::where('project_id',$this->project_id)->max('number_order');
        Stage::create([
            'description' => $this->description,
            'number_order' => ($number_order==null?1:$number_order+1),
            'project_id' => $this->project_id
        ]);
        $this->description = null;
        $this->dispatchBrowserEvent('response_projects_stages', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function changeordernumber($direction,$id,$number,$index){
        if($direction == 1){
            $move = Stage::where('id',$id);
            $change_array = $this->stages[$index-1];
            $change = Stage::where('id',$change_array['id']);

            $move->update([
                'number_order' => $number-1
            ]);

            $change->update([
                'number_order' => $number
            ]);
        }else if($direction == 0){
            $move = Stage::where('id',$id);
            $change_array = $this->stages[$index+1];
            $change = Stage::where('id',$change_array['id']);

            $move->update([
                'number_order' => $number+1
            ]);

            $change->update([
                'number_order' => $number
            ]);
        }
    }

    public function deleteItem($id,$number){
        $max = Stage::where('project_id',$this->project_id)->max('number_order');
        //$exists = Stage::where('package_item_detail_id',$id)->first();

        // if($exists){
        //     $this->dispatchBrowserEvent('response_success_delete_items', ['message' => Lang::get('messages.msg_notdelete_pid')]);
        // }else{
            Stage::where('id',$id)->delete();
            $this->stages = [];
            for($c = $number;$c <=$max; $c++){
                Stage::where('project_id',$this->project_id)
                        ->where('number_order',$c)
                        ->update([
                            'number_order' => $c - 1
                        ]);
            }

        //}

    }
}
