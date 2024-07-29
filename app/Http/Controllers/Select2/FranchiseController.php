<?php

namespace App\Http\Controllers\Select2;

use App\Models\Franchise;
use App\Models\Therapist;
use Illuminate\Http\Request;

class FranchiseController
{
    public function __invoke(Request $request)
    {
        $franchise = Franchise::query();

        if ($request->q)
            $franchise->where('name', 'like', '%' . $request->q . '%');

        return $franchise->get(['id', 'name as text']);
    }
}
