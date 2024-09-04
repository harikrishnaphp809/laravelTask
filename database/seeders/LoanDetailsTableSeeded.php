<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class LoanDetailsTableSeeded extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            DB::table('loan_details')->delete();
        
            $loan_details = [
                ['clientid' => 1001, 'num_of_payments' => 12, 'first_payment_date' => '2018-06-29', 'last_payment_date' => '2019-05-29', 'loan_amount' => 1550.00],
                ['clientid' => 1003, 'num_of_payments' => 7, 'first_payment_date' => '2019-02-15', 'last_payment_date' => '2019-08-15', 'loan_amount' => 6851.94],
                ['clientid' => 1005, 'num_of_payments' => 17, 'first_payment_date' => '2017-11-09', 'last_payment_date' => '2019-03-09', 'loan_amount' => 1800.01]
            ];
        
            DB::table('loan_details')->insert($loan_details);
          }
    }
}
