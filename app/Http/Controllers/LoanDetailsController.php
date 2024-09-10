<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Repositories\LoanDetailsRepository;
use App\Repositories\EmiDetailsRepository;

class LoanDetailsController extends Controller
{
    protected $LoanDetailsRepository;
    protected $EmiDetailsRepository;

    public function __construct(LoanDetailsRepository $LoanDetailsRepository, EmiDetailsRepository $EmiDetailsRepository)
    {
        $this->LoanDetailsRepository = $LoanDetailsRepository;
        $this->EmiDetailsRepository = $EmiDetailsRepository;
        $this->tableName = "emi_details";
    }

    public function index() {
        $loan_details = $this->LoanDetailsRepository->getAll();
        // dd($loan_details);
        return view('admin.loandetails.index', [
            'loandata' => $loan_details
        ]);
    }

    public function process() {
        DB::statement("DROP TABLE IF EXISTS emi_details");
        $loan_details = $this->LoanDetailsRepository->getAll();
        $col_names = [];
        $col_values = [];
        foreach($loan_details as $loan_detail) {
            $startDate = Carbon::parse($loan_detail['first_payment_date']); 
            $endDate = Carbon::parse($loan_detail['last_payment_date']);
            $emi = round($loan_detail['loan_amount']/$loan_detail['num_of_payments'], 0);
            while ($startDate->lte($endDate)) {
                $columnName = $startDate->format('Y').'_' . $startDate->format('F');
                $col_names[] = $columnName;
                $col_values[$loan_detail['clientid']][$columnName] = $emi;
                //$col_values['client_id'] = $loan_detail['clientid'];
                $startDate->addMonth();
            }
        }
        $col_names = array_unique($col_names);
        // dd($col_names);
        if (!Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) use ($col_names) {
                $table->id(); // Primary key
                $table->integer('client_id');
                // Step 2: Create dynamic columns based on the date range
                foreach ($col_names as $col_name) {
                    $table->string($col_name)->default(0);
                }
            });
            // Table successfully created
            $tableCreated = true;
        } else {
            $tableCreated = false; // Table already exists
        }
        $data = [];
        foreach ($col_values as $key => $value) {
           foreach($value as $inner_key => $inner_value) {
            $data['client_id'] = $key;
            $data[$inner_key] = $inner_value;
            // Insert the dynamic data into the table
        }
            DB::table($this->tableName)->insert($data);
        }
        return redirect(route('get_emi_details'))->with('success','Emi Data Processed Successfully.');;
    }

}
