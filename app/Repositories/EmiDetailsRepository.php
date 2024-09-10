<?php

namespace App\Repositories;

use App\Models\EmiDetail;

class EmiDetailsRepository
{
    protected $model;
    
    public function __construct(EmiDetail $model)
    {
        $this->EmiDetail = $model;
    }
    public function getById($id)
    {
        return $this->EmiDetail->findOrFail($id);
    }

    public function getAll()
    {
        return $this->EmiDetail->all()->toArray();
    }

    public function create($data)
    {
        return $this->EmiDetail->create($data);
    }

    public function update($id, $data)
    {
        $EmiDetail = $this->EmiDetail->findOrFail($id);
        $EmiDetail->update($data);
        return $EmiDetail;
    }

    public function delete($id)
    {
        $EmiDetail = $this->EmiDetail->findOrFail($id);
        $EmiDetail->delete();
    }
}