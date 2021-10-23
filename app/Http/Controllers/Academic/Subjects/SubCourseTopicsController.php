<?php

namespace App\Http\Controllers\Academic\Subjects;

use App\Http\Controllers\Controller;
use App\Models\Academic\Subjects\ClassActivityComment;
use App\Models\Academic\Subjects\ClassActivityTestAnswer;
use App\Models\Academic\Subjects\CourseTopic;
use App\Models\Academic\Subjects\TopicClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubCourseTopicsController extends Controller
{
    public function update(Request $request){
        $title = $request->value;
        $id = $request->pk;
        CourseTopic::where('id',$id)->update(['title'=>$title]);
    }

    public function deleteTopic($id){
        CourseTopic::where('id',$id)->delete();
        return response()->json(['success'=>true], 200);
    }
    public function deleteClass($id){
        TopicClass::where('id',$id)->delete();
        return response()->json(['success'=>true], 200);
    }

    public function updateAnswers(Request $request){
        $title = $request->value;
        $id = $request->pk;
        ClassActivityTestAnswer::where('id',$id)->update(['answer_text'=>$title]);
    }
}
