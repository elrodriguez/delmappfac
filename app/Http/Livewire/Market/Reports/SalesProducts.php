<?php

namespace App\Http\Livewire\Market\Reports;

use App\Models\Master\Establishment;
use App\Models\Warehouse\Item;
use Carbon\Carbon;
use App\Models\Master\Parameter;
use Livewire\Component;
use Livewire\WithPagination;

class SalesProducts extends Component
{
    public $establishments;
    public $date_start;
    public $date_end;
    public $establishment_id;
    public $type = 'sale';
    public $PRT007PAG;
    public $alert = false;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->establishments = Establishment::all();
        $this->date_start = Carbon::now()->format('Y-m-d');
        $this->date_end = Carbon::now()->format('Y-m-d');
        $this->PRT007PAG = Parameter::where('id_parameter','PRT007PAG')->value('value_default');
    }

    public function render()
    {
        return view('livewire.market.reports.sales-products',['sales'=>$this->getDataProducts()]);
    }

    public function salesSearch()
    {
        $this->alert = true;
        $this->resetPage();
    }

    public function getDataProducts(){

        $type = $this->type;
        $date_start = $this->date_start;
        $date_end = $this->date_end;
        $establishment_id = $this->establishment_id;

        return Item::select(
                'items.description',
            )
            ->selectSub(function($query) use($date_start,$date_end,$establishment_id) {
                $query->from('document_items')
                    ->join('documents','document_items.document_id','documents.id')
                    ->selectRaw('SUM(document_items.quantity)')
                    ->whereColumn('document_items.item_id','items.id')
                    ->where('documents.establishment_id',$establishment_id)
                    ->where(function($query) use ($date_start,$date_end){
                        $query->whereRaw('DATE(document_items.created_at)>=? AND DATE(document_items.created_at)<=?',[$date_start,$date_end]);
                    });
            }, 'quantity')
            ->selectSub(function($query) use($date_start,$date_end,$establishment_id) {
                $query->from('document_items')
                    ->join('documents','document_items.document_id','documents.id')
                    ->selectRaw('SUM(document_items.total)')
                    ->whereColumn('document_items.item_id','items.id')
                    ->where('documents.establishment_id',$establishment_id)
                    ->where(function($query) use ($date_start,$date_end){
                        $query->whereRaw('DATE(document_items.created_at)>=? AND DATE(document_items.created_at)<=?',[$date_start,$date_end]);
                    });
            }, 'total')
            ->when($type == 'sale', function ($query) use($date_start,$date_end,$establishment_id) {
                return $query->whereRaw('(SELECT COUNT(item_id) FROM document_items INNER JOIN documents ON documents.id = document_items.document_id WHERE document_items.item_id=items.id AND documents.establishment_id = ? AND ((DATE(document_items.created_at)>=? AND DATE(document_items.created_at)<=?)) ) > 0',[$establishment_id,$date_start,$date_end]);
            }, function($query) use($date_start,$date_end,$establishment_id){
                return $query->whereRaw('(SELECT COUNT(item_id) FROM document_items INNER JOIN documents ON documents.id = document_items.document_id WHERE document_items.item_id=items.id AND documents.establishment_id = ? AND ((DATE(document_items.created_at)>=? AND DATE(document_items.created_at)<=?)) ) = 0',[$establishment_id,$date_start,$date_end]);
            })
            ->paginate($this->PRT007PAG);
    }
}
