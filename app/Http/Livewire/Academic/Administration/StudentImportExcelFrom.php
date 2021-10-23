<?php

namespace App\Http\Livewire\Academic\Administration;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class StudentImportExcelFrom extends Component
{
    public function render()
    {
        return view('livewire.academic.administration.student-import-excel-from');
    }

    public function exportExample()
    {
        $filePath = public_path("storage/rrhh/example/empleados.xlsx");
    	$headers = ['Content-Type: application/x-excel'];
    	$fileName = time().'_alumnos_ejemplo.xlsx';

    	return response()->download($filePath, $fileName, $headers);
    }
}
