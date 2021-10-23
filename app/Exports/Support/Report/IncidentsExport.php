<?php

namespace App\Exports\Support\Report;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncidentsExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function items($items) {
        $this->items = $items;

        return $this;
    }

    public function parameters($data) {
        $this->parameters = $data;

        return $this;
    }

    public function view(): View
    {
        return view('support.reports.ticket_reports_incidents_excel', [
            'items' => $this->items,
            'parameters' => $this->parameters
        ]);
    }
}
