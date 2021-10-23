<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CashProductExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function documents($documents) {
        $this->documents = $documents;

        return $this;
    }

    public function company($company) {
        $this->company = $company;

        return $this;
    }

    public function cash($cash) {
        $this->cash = $cash;

        return $this;
    }

    public function view(): View {
        return view('market.administration.cash_report_product_excel', [
            'documents'=> $this->documents,
            'company' => $this->company,
            'cash'=>$this->cash
        ]);
    }
}
