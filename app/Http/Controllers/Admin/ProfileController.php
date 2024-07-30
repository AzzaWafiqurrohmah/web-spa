<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\TherapistRequest;
use App\Http\Requests\Therapist\PasswordRequest;
use App\Http\Requests\Therapist\ProfileRequest;
use App\Models\Therapist;
use App\Repository\Therapist\ProfileRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('pages.therapist.profile.index', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'hai';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request)
    {
        ProfileRepository::save($request->validated());
        return back()->with('alert_s', 'Berhasil mengubah data');
    }

    public function updatePassword(PasswordRequest $request){
        ProfileRepository::updatePassword($request->validated());
        return $this->success(
            message: 'Berhasil mengubah Password'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
