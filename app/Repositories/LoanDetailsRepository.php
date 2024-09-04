<?php

namespace App\Repositories;

use App\Models\LoanDetail;

class LoanDetailsRepository
{
    protected $model;
    
    public function __construct(LoanDetail $model)
    {
        $this->LoanDetail = $model;
    }
    public function getById($id)
    {
        return $this->LoanDetail->findOrFail($id);
    }

    public function getAll()
    {
        return $this->LoanDetail->all();
    }

    public function create($data)
    {
        return $this->LoanDetail->create($data);
    }

    public function update($id, $data)
    {
        $LoanDetail = $this->LoanDetail->findOrFail($id);
        $LoanDetail->update($data);
        return $LoanDetail;
    }

    public function delete($id)
    {
        $LoanDetail = $this->LoanDetail->findOrFail($id);
        $LoanDetail->delete();
    }
}