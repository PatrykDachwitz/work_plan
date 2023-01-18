<?php

namespace App\Repository\Eloquent;

use App\Models\Historie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HistoriesRepository implements \App\Repository\HistoriesRepository
{

    private $historie;

    public function __construct(Historie $historie) {
        $this->historie = $historie;
    }

    public function findOrCreate(array $filters)
    {
        try {
            return $this->findOrFail($filters);
        } catch (ModelNotFoundException) {

        }
    }

    public function create(array $data) {
        $this->historie->insert($data);
    }

    public function findOrFail(int $id = null, array $filters = null)
    {
        if(!is_null($id)) {
            return $this->historie->findOrFail($id);
        } else {
            $historie = $this->historie->newQuery();

            foreach ($filters as $column => $value) {
                $historie->where($column, $value);
            }

            $result = $historie->first();

            if (empty($result)) {
                throw new ModelNotFoundException();
            } else {
                return $result;
            }
        }
    }
}