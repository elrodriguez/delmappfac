<?php

namespace App\Http\Livewire\Rrhh\Administration;

use Livewire\Component;

class EmployeesImportExcelFrom extends Component
{
    public function render()
    {
        return view('livewire.rrhh.administration.employees-import-excel-from');
    }
    public function exportExample()
    {
        $filePath = public_path("storage/rrhh/example/empleados.xlsx");
    	$headers = ['Content-Type: application/x-excel'];
    	$fileName = time().'empleados_ejemplo.xlsx';

    	return response()->download($filePath, $fileName, $headers);
    }
}
