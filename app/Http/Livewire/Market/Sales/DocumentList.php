<?php

namespace App\Http\Livewire\Market\Sales;

use App\Models\Catalogue\BankAccount;
use App\Models\Master\Document;
use Livewire\WithPagination;
use App\Models\Catalogue\DocumentType;
use App\Models\Catalogue\StateType;
use App\Models\Master\Cash;
use App\Models\Master\DocumentPayment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\DB;

class DocumentList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $document_types;
    public $document_type_id;
    public $states;
    public $state_id;
    public $number;
    public $series;
    public $serie_id;
    public $user_id;
    public $users = [];
    public $start_date;
    public $date_end;
    public $payments = [];

    public function mount(){
        $userActivity = new Activity;
        $userActivity->causedBy(Auth::user());
        $userActivity->routeOn(route('market_sales_document_list'));
        $userActivity->componentOn('market.sales.document-list');
        $userActivity->log('ingresó a la vista lista de comprobantes en market');
        $userActivity->save();
    }

    public function render()
    {
        $user = User::find(Auth::id());

        $this->document_types = DocumentType::whereIn('id',['01','03','07','08'])->get();
        $this->states = StateType::all();
        if($user->hasRole(['SuperAdmin', 'Administrador'])){
            $this->listUsers();
        }else{
            $this->user_id = Auth::id();
        }
        return view('livewire.market.sales.document-list',['collection' => $this->list()]);
    }

    public function list(){
        $user_id = $this->user_id;
        $document_type_id = $this->document_type_id;
        $state_id = $this->state_id;
        $number = $this->number;
        $serie_id = $this->serie_id;
        $start_date = $this->start_date;
        $date_end = $this->date_end;


        return Document::join('state_types','documents.state_type_id','state_types.id')
            ->join('document_types','documents.document_type_id','document_types.id')
            ->select(
                'document_types.description AS document_type_description',
                'documents.id',
                'external_id',
                DB::raw('CONCAT(DATE_FORMAT(documents.date_of_issue,"%d/%m/%Y")," ",DATE_FORMAT(documents.created_at,"%H:%i:%s")) AS document_date'),
                'customer',
                'series',
                'number',
                'state_types.description',
                'state_type_id',
                'currency_type_id',
                'total_taxed',
                'total_igv',
                'total',
                'filename'
            )
            ->where('module','MAR')
            ->when($user_id, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })->when($document_type_id, function ($query) use ($document_type_id) {
                return $query->where('document_type_id', $document_type_id);
            })
            ->when($state_id, function ($query) use ($state_id) {
                return $query->where('state_type_id', $state_id);
            })
            ->when($number, function ($query) use ($number) {
                return $query->where('number', $number);
            })
            ->when($serie_id, function ($query) use ($serie_id) {
                return $query->where('series', $serie_id);
            })
            ->when($start_date, function ($query) use ($start_date,$date_end) {
                return $query->whereBetween('date_of_issue', [$start_date, $date_end]);
            })
            ->orderBy('documents.id','DESC')
            ->paginate(10);
    }

    public function searchDocument()
    {
        $userActivity = new Activity;
        $userActivity->causedBy(Auth::user());
        $userActivity->routeOn(route('market_sales_document_list'));
        $userActivity->componentOn('market.sales.document-list');
        $userActivity->dataOld(request()->all());
        $userActivity->log('realizó una búsqueda, en listado comprobantes');
        $userActivity->save();
        $this->resetPage();
    }

    public function listUsers(){
        $this->users = User::role(['SuperAdmin','Administrador','Vendedor'])->get();
    }

    public function paymentsByDocument($document_id){
        $userActivity = new Activity;
        $userActivity->causedBy(Auth::user());
        $userActivity->routeOn(route('market_sales_document_list'));
        $userActivity->componentOn('market.sales.document-list');
        $userActivity->dataOld(Document::find($document_id));
        $userActivity->log('visualizar los pagos del documento');
        $userActivity->save();

        $this->payments = DocumentPayment::join('cat_payment_method_types','document_payments.payment_method_type_id','cat_payment_method_types.id')
            ->join('global_payments',function($query){
                $query->on('global_payments.payment_id','document_payments.id')
                    ->where('global_payments.payment_type','=',DocumentPayment::class);
            })
            ->leftjoin('cashes',function($query){
                $query->on('global_payments.destination_id','cashes.id')
                    ->where('global_payments.destination_type','=',Cash::class);
            })
            ->leftjoin('bank_accounts',function($query){
                $query->on('global_payments.destination_id','bank_accounts.id')
                    ->where('global_payments.destination_type','=',BankAccount::class);
            })
            ->select(
                'cashes.user_id',
                'cashes.reference_number',
                DB::raw('(select description from banks where banks.id = bank_accounts.bank_id) AS bank_name'),
                DB::raw('CONCAT(bank_accounts.description," - ",bank_accounts.number," - ",bank_accounts.currency_type_id) AS back_account_description'),
                'cat_payment_method_types.description',
                'document_payments.date_of_payment',
                'document_payments.reference',
                'document_payments.payment'
            )
            ->where('document_id',$document_id)
            ->get();
    }


}
