<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\Career;
use Livewire\Component;
use App\Models\Academic\Administration\Resolution;
use App\Models\Academic\Administration\TrainingLevel;
use App\Models\Master\Establishment;
use Illuminate\Support\Facades\DB;

class PostulantCreateForm extends Component
{

    public function render()
    {

        $resolutions = Resolution::all();
        $establishments = Establishment::where('state',1)->get();
        $careers = Career::all();
        $traininglevels = TrainingLevel::all();
        $departments = DB::table('departments')->get();

        return view('livewire.academic.administration.postulant-create-form',[
            'resolutions'=>$resolutions,
            'establishments'=>$establishments,
            'careers' => $careers,
            'traininglevels' => $traininglevels,
            'departments' => $departments
        ]);
    }
}
