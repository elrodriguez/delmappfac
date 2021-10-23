<?php

namespace App\Http\Controllers\Support\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\Support\Helpdesk\SupTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TicketController extends Controller
{
    public function versionSicmactUpdate(Request $request){

        $value = $request->value;
        $id = $request->pk;

        $msg = Lang::get('messages.was_successfully_updated');
        $tit = Lang::get('messages.congratulations');
        $ico = 'success';

        SupTicket::find($id)->update(['version_sicmact'=>$value]);

        return response()->json(['success'=>true,'data'=>[
            'msg' => $msg,
            'tit' => $tit,
            'ico' => $ico
        ]], 200);
    }

}
