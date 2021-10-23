<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportValuedKardexExport implements FromView, ShouldAutoSize
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
        return view('logistics.warehouse.report_kardex_valued_excel', [
            'items' => $this->items,
            'parameters' => $this->parameters
        ]);
    }
}
