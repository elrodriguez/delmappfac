<?php

namespace App\Http\Controllers\Academic\Subjects;

use App\Http\Controllers\Controller;
use App\Models\Academic\Subjects\StudentTest;
use App\Models\Academic\Subjects\StudentTestAnswers;
use Illuminate\Http\Request;
use Livewire\Commands\StubParser;

class SubStudentTestController extends Controller
{
    public function update(Request $request){
        $score = $request->value;
        $id = $request->pk;

        if($score >= 11){
            $state = 'aprobado';
        }else{
            $state = 'desaprobado';
        }

        StudentTest::where('id',$id)->update([
            'score'=>$score,
            'state'=>$state
        ]);

        //return response()->json('success', 200);
    }
    public function updateAnswer(Request $request){
        $point = $request->value;
        $id = $request->pk;

        $studenttestanswers = StudentTestAnswers::find($id);
        $studenttestanswers->update([
            'point'=>$point
        ]);

        $score = StudentTestAnswers::where('student_test_id',$studenttestanswers->student_test_id)->sum('point');

        if($score >= 11){
            $state = 'aprobado';
        }else{
            $state = 'desaprobado';
        }

        StudentTest::where('id',$studenttestanswers->student_test_id)->update([
            'score'=>$score,
            'state'=>$state
        ]);
    }
}
