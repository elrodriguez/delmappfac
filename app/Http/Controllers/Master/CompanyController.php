<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CoreBilling\Helpers\Certificate\GenerateCertificate;
use App\Models\Master\Company;
use App\Models\Master\Parameter;
use Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{

    public function uploadFile(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'soap_password' => 'required',
            'certificate' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        try {
            $company = Company::first();
            $soap_type_id = $request->input('soap_type_id');
            $soap_send_id = $request->input('soap_send_id');
            $password = $request->input('soap_password');
            $file = $request->file('certificate');
            $pfx = file_get_contents($file);
            $pem = GenerateCertificate::typePEM($pfx, $password);
            $name = 'certificate_'.$company->number.'.pem';
            if(!file_exists(storage_path('app'.DIRECTORY_SEPARATOR.'certificates'))) {
                mkdir(storage_path('app'.DIRECTORY_SEPARATOR.'certificates'));
            }
            file_put_contents(storage_path('app'.DIRECTORY_SEPARATOR.'certificates'.DIRECTORY_SEPARATOR.$name), $pem);
            $company->soap_type_id = $soap_type_id;
            $company->soap_send_id = $soap_send_id;
            $company->soap_password = $password;
            $company->certificate = $name;
            $company->save();

            return response()->json(['success' => Lang::get('messages.was_successfully_updated')]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }

}
