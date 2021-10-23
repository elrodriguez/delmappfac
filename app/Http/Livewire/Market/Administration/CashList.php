<?php

namespace App\Http\Livewire\Market\Administration;

use App\Models\Master\Cash;
use App\Models\User;
use Livewire\Component;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class CashList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['listCashReset'];
    public $cash_id;

    public function mount(){
        $this->cash_id = null;
        $userActivity = new Activity;
        $userActivity->causedBy(Auth::user());
        $userActivity->routeOn(route('market_administration_cash'));
        $userActivity->componentOn('market.administration.cash-list');
        $userActivity->log('ingresó a la vista caja chica en market');
        $userActivity->save();
    }

    public function render()
    {
        return view('livewire.market.administration.cash-list',['collection'=>$this->listCash()]);
    }

    public function listCash(){
        $user = User::find(Auth::id());
        $role = $user->getRoleNames();
        $roles = array('Administrador','SuperAdmin');
        $bool = in_array($role, $roles);
        $user_id = $user ->id;

        return Cash::join('users','cashes.user_id','users.id')
            ->select(
                'cashes.id',
                'cashes.date_opening',
                'cashes.time_opening',
                'cashes.date_closed',
                'cashes.time_closed',
                'cashes.beginning_balance',
                'cashes.final_balance',
                'cashes.income',
                'cashes.state',
                'cashes.reference_number',
                'users.name'
            )
            ->when($bool == true, function ($query) use ($user_id){
                return $query->where('cashes.user_id', $user_id);
            })
            ->orderBy('cashes.id','DESC')
            ->paginate(10);
    }

    public function showEdit($cash_id){
        $this->cash_id = $cash_id;
        $this->emit('updateCash', $this->cash_id);
    }
    public function listCashReset()
    {
        $this->listCash();
    }
}
