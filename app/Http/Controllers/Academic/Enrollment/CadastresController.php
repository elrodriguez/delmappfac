<?php

namespace App\Http\Controllers\Academic\Enrollment;

use App\Http\Controllers\Controller;
use App\Models\Academic\Administration\AcademicSeason;
use App\Models\Master\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CadastresController extends Controller
{
    public function list(){
        return datatables($this->queryJoin())
            ->editColumn('birth_date', function($row){
                return Carbon::parse($row->birth_date)->format('d/m/Y');
            })
            ->addColumn('student_representative', function($row){
                return $this->searchRepresentative($row->person_id);
            })
            ->make(true);
    }
    public function queryJoin() {
        $season = AcademicSeason::where('state',1)->first();
        return Person::query()->select([
                    'people.id AS person_id',
                    'people.trade_name',
                    'people.number',
                    'people.address',
                    'people.sex',
                    'people.email',
                    'people.birth_date',
                    'academic_levels.description AS level_description',
                    'academic_sections.description AS section_description',
                    'academic_years.description AS year_description',
                    'cadastre_situations.description AS situation_description'
                ])
                ->join('students','people.id','students.id_person')
                ->join('cadastres','people.id','cadastres.person_id')
                ->join('academic_levels','cadastres.academic_level_id','academic_levels.id')
                ->join('academic_sections','cadastres.academic_section_id','academic_sections.id')
                ->join('academic_years','cadastres.academic_year_id','academic_years.id')
                ->join('cadastre_situations','cadastres.cadastre_situation_id','cadastre_situations.id')
                ->where('cadastres.academic_season_id',$season->id)
                ->orderBy('year','DESC');

    }
    public function searchRepresentative($id){
        $represantatives = Person::join('student_representatives','people.id','student_representatives.representative_id')
            ->select(
                'people.id',
                'people.trade_name',
                'people.number',
                'people.address',
                'people.sex',
                'people.email',
                'people.birth_date',
                'people.telephone',
                'student_representatives.live_with_the_student',
                'student_representatives.relationship'
            )
            ->where('student_representatives.person_student_id',$id)
            ->get();
        $data = [];
        foreach($represantatives as $key => $represantative){
            $data[$key] = [
                'id' => $represantative->id,
                'trade_name' => $represantative->trade_name,
                'number' => $represantative->number,
                'address' => $represantative->address,
                'sex' => $represantative->sex,
                'email' => $represantative->email,
                'birth_date' => $represantative->birth_date,
                'telephone' => $represantative->telephone,
                'live_with_the_student' => $represantative->live_with_the_student,
                'relationship' => $represantative->relationship
            ];
        }

        return $data;
    }

    public function listCadastresCourses(){
        return datatables($this->queryJoinCadastresCourses())
            ->editColumn('birth_date', function($row){
                return Carbon::parse($row->birth_date)->format('d/m/Y');
            })
            ->addColumn('student_representative', function($row){
                return $this->searchRepresentative($row->person_id);
            })
            ->make(true);
    }
    public function queryJoinCadastresCourses() {
        return Person::query()->select([
                    'people.id AS person_id',
                    'people.trade_name',
                    'people.number',
                    'people.address',
                    'people.sex',
                    'people.email',
                    'people.birth_date',
                    'academic_levels.description AS level_description',
                    'academic_years.description AS year_description'
                ])
                ->join('students','people.id','students.id_person')
                ->join('cadastres','people.id','cadastres.person_id')
                ->join('academic_levels','cadastres.academic_level_id','academic_levels.id')
                ->join('academic_years','cadastres.academic_year_id','academic_years.id')
                ->orderBy('year','DESC');

    }
}
