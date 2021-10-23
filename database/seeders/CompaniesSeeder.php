<?php

namespace Database\Seeders;

use App\Models\Master\Company;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'DELMAPP',
            'tradename' => 'DELMAPP',
            'id_management_type' => 'PRI',
            'identity_document_type_id' => '6',
            'number'=>'10123456781',
            'soap_type_id' => '01',
            'soap_send_id' => '01'
        ]);
    }
}
