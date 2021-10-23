<?php

namespace App\Http\Controllers\Academic\Subjects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Academic\Subjects\ClassActivity;
use Spatie\Dropbox\Client;
use Illuminate\Support\Facades\Validator;

class FileDropBoxController extends Controller
{
    public $dropbox;

    public function __construct()
    {

        $this->dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();  

    }

    public function index()
    {
        // Obtenemos todos los registros de la tabla files
        // y retornamos la vista files con los datos.
        //$files = File::orderBy('created_at', 'desc')->get();
        
        //return view('files', compact('files'));
    }

    public function upload(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'file' => 'required'
        ]);

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();

        }

        $id = $request->input('video_id');

        $name = 'A_'.$id.'.'.$request->file('file')->getClientOriginalExtension();
        Storage::disk('public')->putFileAs(
            'academic/subjects/',
            $request->file('file'), 
            $name
        );
        // Creamos el enlace publico en dropbox utilizando la propiedad dropbox
        // definida en el constructor de la clase y almacenamos la respuesta.
        // $response = $this->dropbox->createSharedLinkWithSettings(
        //     $request->file('file')->getClientOriginalName(), 
        //     ["requested_visibility" => "public"]
        // );

        ClassActivity::where('id',$id)->update([
            'description' => $request->input('title'),
            'body' => $request->input('description'),
            'state' => $request->input('state')?true:false,
            'url_file' => 'academic/subjects/'.$name,
            'name_file' => $request->file('file')->getClientOriginalName(),
            'extension' => $request->file('file')->getClientOriginalExtension(),
            'size' => null
        ]);
        return response()->json(['success' => 'File Uploaded Successfully']);
    }

    public function download(int $id)
    {
        $activity = ClassActivity::where('id',$id)->first();
        $path = public_path('storage/'.$activity->url_file);
        return response()->download($path,$activity->name_file);
    }
    public function destroy(ClassActivity $classActivity)
    {
        // Eliminamos el archivo en dropbox llamando a la clase
        // instanciada en la propiedad dropbox.
        //$this->dropbox->delete($file->name);
        // Eliminamos el registro de nuestra tabla.
        //$file->delete();
        return back();
    }
}
