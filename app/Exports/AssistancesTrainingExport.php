<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AssistancesTrainingExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function assistances($assistances) {
        $this->assistances = $assistances;

        return $this;
    }

    public function view(): View
    {
        return view('academic.subjects.courses_training_students_assistance_export_excel', [
            'assistances' => $this->assistances
        ]);
    }

}
