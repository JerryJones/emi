<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('loan_details')->insert(
            [
                'clientid' => 1001,
                'num_of_payment' => 12,
                'first_payment_date' => '2018-06-29',
                'last_payment_date' => '2019-05-29',
                'loan_amount' => 1550,
            ],
            [
                'clientid' => 1003,
                'num_of_payment' => 7,
                'first_payment_date' => '2019-02-15',
                'last_payment_date' => '2019-08-15',
                'loan_amount' => 6851.94,
            ],
            [
                'clientid' => 1005,
                'num_of_payment' => 17,
                'first_payment_date' => '2017-11-09',
                'last_payment_date' => '2019-03-09',
                'loan_amount' => 1800.01,
            ],
        );
    }
}
