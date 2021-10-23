<?php

namespace App\Http\Controllers\Academic\Subjects;

use App\Http\Controllers\Controller;
use App\Models\Academic\Subjects\ClassActivityHomework;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityHomeworkController extends Controller
{
    public function storeHomeworkStuden(Request $request){
        try {
            $file = $request->file('file');

            if($file){
                $filename = $file->getClientOriginalName();
                $foo = \File::extension($filename);
                if($foo == 'pdf'){
                    $route_file = 'homework'.DIRECTORY_SEPARATOR.Auth::user()->email.DIRECTORY_SEPARATOR.date('Ymdhmi').'.'.$foo;
                    Storage::disk('public')->put($route_file,\File::get($file));

                    ClassActivityHomework::where('class_activity_homework_id',$request->input('activity_homework'))->update(['state'=>'I']);

                    ClassActivityHomework::create([
                        'user_id' => Auth::id(),
                        'person_id' => Auth::user()->person_id,
                        'course_id' => $request->input('course_id'),
                        'class_activity_id' => $request->input('activity_id'),
                        'class_activity_homework_id' => $request->input('activity_homework'),
                        'description' => $route_file,
                        'file_name' => $filename,
                        'state' => 'A'
                    ]);

                    return response()->json('success', 200);

                }else{
                    return response()->json('error', 400);
                }
            }

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' =>  $e->getMessage()
            ], 400);
        }
    }

    public function homeworkUpdatePoints(Request $request){
        $quantity = $request->value;
        $id = $request->pk;
        $homework = ClassActivityHomework::where('id',$id);
        $homework->update([
            'points' => $quantity,
            'state' => 'C'
        ]);
    }
}
