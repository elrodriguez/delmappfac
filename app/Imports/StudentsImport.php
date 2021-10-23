<?php

namespace App\Imports;

use App\Models\Academic\Administration\Student;
use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $numRows = 0;

    public function model(array $row)
    {
        $document_type_name = strtolower($row[0]);
        $sex = '';
        if($document_type_name=='pasaporte'){
            $document_type_id = 7;
        }else if($document_type_name=='dni'){
            $document_type_id = 1;
        }else{
            $document_type_id = 0;
        }

        if($row[8]=='1'){
            $sex = 'm';
        }else if($row[8]=='0'){
            $sex = 'f';
        }else{
            $sex = $row[8];
        }

        $people = Person::where('number',$row[1])->where('identity_document_type_id',$document_type_id)->first();

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
                'sex' => $sex,
                'birth_date' => $this->transformDate($row[9])
            ]);
        }else{
            //dd($this->transformDate($row[9]));
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
                'sex' => $sex,
                'birth_date' => $this->transformDate($row[9])
            ]);

            PersonTypeDetail::create([
                'person_id' => $person->id,
                'person_type_id' => 5
            ]);

            Student::create([
                'student_code' => codeStudents($person->id),
                'country_id' => 'PE',
                'id_person' => $person->id,
                'number_dni' => $person->number
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
    public function transformDate($value, $format = 'Y-m-d'){
        if($value != '0000-00-00'){
            if($value){
                try {
                    return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
                } catch (\ErrorException $e) {
                    return \Carbon\Carbon::createFromFormat($format, $value);
                }
            }
        }
    }
}
