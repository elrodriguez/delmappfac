<?php

namespace App\Imports;

use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use App\Models\Master\supplier;
use App\Models\RRHH\Administration\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    private $numRows = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $document_type_name = strtolower($row[0]);
        if($document_type_name=='pasaporte'){
            $document_type_id = 7;
        }else if($document_type_name=='dni'){
            $document_type_id = 1;
        }else{
            $document_type_id = 0;
        }
        $people = Person::where('number',$row[1])->first();

        if($people){
            $person = Person::where('id',$people->id)->update([
                'identity_document_type_id' => $document_type_id,
                'number' => $row[1],
                'name' => $row[2],
                'trade_name' => $row[2].' '.$row[3].' '.$row[4],
                'address' => $row[5],
                'email' => $row[6],
                'telephone' => ($row[7]?$row[7]:null),
                'last_paternal' => $row[3],
                'last_maternal' => $row[4],
                'sex' => $row[8]
            ]);
        }else{
            $person = Person::create([
                'type' => 'customers',
                'identity_document_type_id' => $document_type_id,
                'number' => $row[1],
                'name' => $row[2],
                'trade_name' => $row[2].' '.$row[3].' '.$row[4],
                'country_id' => 'PE',
                'address' => $row[5],
                'email' => $row[6],
                'telephone' => ($row[7]?$row[7]:null),
                'last_paternal' => $row[3],
                'last_maternal' => $row[4],
                'sex' => $row[8]
            ]);
            PersonTypeDetail::create([
                'person_id' => $person->id,
                'person_type_id' => 3
            ]);
            Employee::create([
                'person_id' => $person->id,
                'family_burden' =>'NO'
            ]);
        }
    }
    public function rules(): array
    {
        return [
            'documento_tipo' => 'required|max:45',
            'numero' => 'required|max:20',
            'nombre' => 'required|max:255',
            'paterno' => 'required|max:255',
            'materno' => 'required|max:255',
            'email' => 'required|email',
            'telefono' => 'nullable|max:15',
            'direccion' => 'nullable|max:255',
            'genero' => 'required|max:1',
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
