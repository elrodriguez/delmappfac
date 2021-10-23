<?php

namespace App\Http\Livewire\Logistics\Warehouse;


use Livewire\Component;


class ReportKardex extends Component
{
    public $item_id;
    public $date_start;
    public $date_end;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        return view('livewire.logistics.warehouse.report-kardex');
    }


}
