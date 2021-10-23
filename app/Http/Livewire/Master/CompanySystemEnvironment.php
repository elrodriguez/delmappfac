<?php

namespace App\Http\Livewire\Master;

use App\Models\Master\Company;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CompanySystemEnvironment extends Component
{
    public $soap_types;
    public $company;

    public function render()
    {
        $this->soap_types = DB::table('soap_types')->get();
        $this->company = Company::first();
        return view('livewire.master.company-system-environment');
    }

    public function destroy()
    {
        $company = Company::first();

        $company->update([
            'certificate' => null
        ]);
    }
}
