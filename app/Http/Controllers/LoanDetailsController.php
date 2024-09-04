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
        $loan_details = $this->LoanDetailsRepository->getAll()->toArray();
        return view('admin.loandetails.index', [
            'loandata' => $loan_details
        ]);
    }

    public function getbyclient($id) {
        DB::statement("DROP TABLE IF EXISTS emi_details");
        $loan_details = $this->LoanDetailsRepository->getById($id)->toArray();
        $startDate = Carbon::parse($loan_details['first_payment_date']); 
        $endDate = Carbon::parse($loan_details['last_payment_date']);
        if (!Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) use ($startDate, $endDate) {
                $table->id(); // Primary key
                $table->integer('client_id');
                // Step 2: Create dynamic columns based on the date range
                $currentDate = $startDate;
                
                while ($currentDate->lte($endDate)) {
                    $columnName = $currentDate->format('Y').'_' . $currentDate->format('F'); // Example: 'data_2024_01_01'
                    $table->string($columnName)->nullable();
                    $currentDate->addMonth();
                }

                // Optionally add standard fields like timestamps
                //$table->timestamps();
            });
            // Table successfully created
            $tableCreated = true;
        } else {
            $tableCreated = false; // Table already exists
        }

        // Step 3: Insert data into the dynamic table
        $data = [];
        $emi = $loan_details['loan_amount']/$loan_details['num_of_payments'];
        // Loop through the date range to create the data array dynamically
        $currentDate = Carbon::parse($loan_details['first_payment_date']);
        $endDate = Carbon::parse($loan_details['last_payment_date']);
        // dd($currentDate);
        while ($currentDate->lte($endDate)) {
            $columnName = $currentDate->format('Y').'_' . $currentDate->format('F'); // Example: 'data_2024_01_01'
            $data[$columnName] = $emi;
            $data['client_id'] = $loan_details['clientid'];
            $currentDate->addMonth();
        }

        // Insert the dynamic data into the table
        DB::table($this->tableName)->insert($data);
        return redirect(route('get_emi_details'))->with('success','Emi Data Processed Successfully.');;
    }

}
