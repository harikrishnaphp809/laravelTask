<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EmiDetailsRepository;

class EmiDetailsController extends Controller
{
    protected $EmiDetailsRepository;

    public function __construct(EmiDetailsRepository $EmiDetailsRepository)
    {
        $this->EmiDetailsRepository = $EmiDetailsRepository;
    }

    public function index() {
        $emi_details = [];
        $emi_details = $this->EmiDetailsRepository->getAll()->toArray();
        // dd($emi_details);
        return view('admin.emidetails.index', [
            'emi_details' => $emi_details
        ]);
    }
}
