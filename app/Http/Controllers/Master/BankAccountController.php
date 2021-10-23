<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Catalogue\BankAccount;
use App\Models\Master\GlobalPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;

class BankAccountController extends Controller
{
    public function list(){
        return datatables($this->bamkAccountJoin())
            ->addColumn('edit_url', function($row){
                return route('configurations_master_bank_account_edit', $row->id);
            })->addColumn('delete_url', function($row){
                return route('configurations_master_bank_account_delete', $row->id);
            })->make(true);
    }

    public function bamkAccountJoin(){
        return BankAccount::query()
            ->join('banks','bank_accounts.bank_id','banks.id')
            ->select(
                'bank_accounts.id',
                'banks.description AS bank_description',
                'bank_accounts.description',
                'bank_accounts.number',
                'bank_accounts.currency_type_id',
                'bank_accounts.cci',
                'bank_accounts.state',
                'bank_accounts.initial_balance'
            );

    }

    public function destroy($id){

        $exists = GlobalPayment::where('destination_id',$id)
            ->where('destination_type',BankAccount::class)
            ->exists();
        if(!$exists) {
            BankAccount::find($id)->delete();
            $tit = Lang::get('messages.removed');
            $msg = Lang::get('messages.was_successfully_removed');
            $ico = 'success';
        } else{
            $tit = Lang::get('messages.error');
            $msg = 'Registro relacionado, imposible de eliminar';
            $ico = 'error';
        }

        return response()->json(['success'=>true,'msg'=>$msg,'tit'=>$tit,'ico'=>$ico], 200);
    }
}
