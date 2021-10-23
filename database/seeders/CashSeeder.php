<?php

namespace Database\Seeders;

use App\Models\Master\Cash;
use App\Models\Master\CashTransaction;
use Illuminate\Database\Seeder;

class CashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cash = Cash::create([
            'user_id' => 1,
            'date_opening' => date('Y-m-d'),
            'time_opening' => date('H:i:s'),
            'beginning_balance' => 0,
            'final_balance' => 0,
            'income' => 0
        ]);

        CashTransaction::create([
            'cash_id' => $cash->id,
            'payment_method_type_id' => '01',
            'description' => 'Saldo inicial',
            'payment' => 0
        ]);
    }
}
