<?php

namespace App\Http\Livewire\Master;

use App\Models\Catalogue\Bank;
use App\Models\Catalogue\CurrencyType;
use App\Models\Catalogue\BankAccount;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class BankAccountCreate extends Component
{
    public $bank_id;
    public $description;
    public $currency_type_id;
    public $initial_balance;
    public $cci;
    public $number;
    public $state = true;
    public $banks;
    public $currency_types;

    public function mount(){
        $this->banks = Bank::all();
        $this->currency_types = CurrencyType::all();
    }

    public function render()
    {
        return view('livewire.master.bank-account-create');
    }

    public function store(){

        $this->validate([
            'bank_id' => 'required',
            'description' => 'required|max:255',
            'currency_type_id' => 'required',
            'cci' => 'required',
            'number' => 'required'
        ]);

        $bank_account = BankAccount::create([
            'bank_id' => $this->bank_id,
            'description' => $this->description,
            'number' => $this->number,
            'currency_type_id' => $this->currency_type_id,
            'cci' => $this->cci,
            'state' => $this->state,
            'initial_balance' => ($this->initial_balance?$this->initial_balance:0) 
        ]);

        $userActivity = new Activity;
        $userActivity->causedBy(Auth::user());
        $userActivity->routeOn(route('configurations_master_bank_account_create'));
        $userActivity->componentOn('master.bank-account-create');
        $userActivity->log(Lang::get('messages.successfully_registered'));
        $userActivity->dataOld($bank_account);
        $userActivity->logType('create');
        $userActivity->modelOn(BankAccount::class,$bank_account->id);
        $userActivity->save();

        $this->clearForm();
        
        $this->dispatchBrowserEvent('response_bank_account_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function clearForm(){
        $this->bank_id = null;
        $this->description = null;
        $this->currency_type_id = null;
        $this->initial_balance = null;
        $this->cci = null;
        $this->number = null;
        $this->state = true;
    }
}
