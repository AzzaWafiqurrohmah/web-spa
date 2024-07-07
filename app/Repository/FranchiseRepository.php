<?php

namespace App\Repository;

use App\Models\Franchise;

class FranchiseRepository
{
    public function store(array $data): Franchise
    {
        return Franchise::create($this->parseData($data));
    }

    public function update(Franchise $franchise, array $data): Franchise
    {
        $franchise->update($this->parseData($data));
        return $franchise;
    }

    private function parseData(array $data): array
    {
        return [
            'raw_id' => $data['regency'],
            'name' => $data['name'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ];
    }
}
