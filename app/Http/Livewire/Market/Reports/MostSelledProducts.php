<?php

namespace App\Http\Livewire\Market\Reports;

use App\Models\Master\Document;
use App\Models\Master\DocumentItem;
use App\Models\Master\Establishment;
use Carbon\Carbon;
use Livewire\Component;

class MostSelledProducts extends Component
{
    public $establishments;
    public $date_start;
    public $date_end;
    public $establishment_id;
    public $products = [];
    public $graphlist = [];

    public function mount(){
        $this->establishments = Establishment::all();

        $this->date_start = Carbon::now()->format('Y-m-d');
        $this->date_end = Carbon::now()->format('Y-m-d');

    }

    public function render()
    {
        return view('livewire.market.reports.most-selled-products');
    }

    public function productSalesTop(){
        $establishment_id = $this->establishment_id;

        $this->products = DocumentItem::join('documents','document_items.document_id','documents.id')
            ->whereBetween('documents.date_of_issue', [$this->date_start, $this->date_end])
            ->when($establishment_id, function ($query, $establishment_id) {
                return $query->where('documents.establishment_id', $establishment_id);
            })
            ->selectRaw('sum(document_items.total) as amount,sum(document_items.quantity) as quantity,document_items.item')
            ->groupBy('document_items.item')
            ->orderBy('amount','DESC')
            ->limit(20)
            ->get();

        $amount_total = $this->products->sum('amount');
        $quantity_total = $this->products->sum('quantity');

        $this->graphlist = [
            'amount_total' => $amount_total,
            'quantity_total' => $quantity_total,
        ];
    }
}
