<?php

namespace App\Http\Livewire\Market\Reports;

use App\Models\Master\Document;
use App\Models\Master\Establishment;
use Carbon\Carbon;
use Livewire\Component;

class SalesSeller extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $establishments;
    public $date_start;
    public $date_end;
    public $establishment_id;
    public $sales = [];

    public function mount(){
        $this->establishments = Establishment::all();

        $this->date_start = Carbon::now()->format('Y-m-d');
        $this->date_end = Carbon::now()->format('Y-m-d');

    }

    public function render()
    {
        return view('livewire.market.reports.sales-seller');
    }

    public function salesSeller(){
        $establishment_id = $this->establishment_id;
        $this->sales = Document::join('users','documents.user_id','users.id')
            ->whereBetween('date_of_issue', [$this->date_start, $this->date_end])
            ->when($establishment_id, function ($query, $establishment_id) {
                return $query->where('documents.establishment_id', $establishment_id);
            })
            ->selectRaw('sum(documents.total) as sum,users.name')
            ->groupBy('users.name')
            ->get();

        $total = $this->sales->sum('sum');
        $sum = [];
        $name = [];

        foreach($this->sales as $key => $item){
            $sum[$key] = number_format((($item->sum/$total)*100), 2, ".", "");
            $name[$key] = $item->name;
        }

        $graph = ['sum' => $sum,'name' => $name];
        $this->dispatchBrowserEvent('response_report_graph_sale', ['graph' => $graph]);
    }
}
