<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Http\Resources\Therapist\PresenceResource;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presence;

class PresenceController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.therapist.presence.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $therapist = Auth::user();
        $presence = Presence::query()
            ->where('therapist_id', $therapist->id)
            ->get();

        return $this->success(
            PresenceResource::collection($presence),
            'Berhasil mendapatka data'
        );
    }

}
