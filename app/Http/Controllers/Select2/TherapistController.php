<?php

namespace App\Http\Controllers\Select2;

use App\Http\Controllers\Controller;
use App\Models\Therapist;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
    public function __invoke(Request $request)
    {
        $therapists = Therapist::query();

        if ($request->q)
            $therapists->where('fullname', 'like', '%' . $request->q . '%');

        return $therapists->get(['id', 'fullname as text']);
    }
}
