<?php

namespace App\Http\Controllers\Academic\Subjects;

use App\Http\Controllers\Controller;
use App\Models\Academic\Subjects\ClassActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Vimeo\Laravel\Facades\Vimeo;

class VideoUploadController extends Controller
{
    public function vimeo(Request $request){

        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'video' => 'required'
        ]);

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();

        }

        $file = $request->file('video');
        $number_order = $request->input('number_order');
        $id = $request->input('video_id');
        $course_id = $request->input('course_id');
        $topic_id = $request->input('topic_id');

        $res = Vimeo::connection('main')->upload($file,[
            'name' => $request->input('title'),
            'description' => $request->input('description'),
            // 'privacy' => array(
            //     'view' => 'password'
            // ),
            // 'password' => '@12kdf@dkks'
        ]);

        ClassActivity::where('id',$id)->update([
            'description' => $request->input('title'),
            'body' => $request->input('description'),
            'state' => $request->input('state')?true:false,
            'url_file' => $res,
            //'number' => $number_order
        ]);
        return response()->json(['success' => 'File Uploaded Successfully']);
        //return redirect()->route('subjects_courses_topic_video_edit',[$course_id,$topic_id,$id]);
    }
}
