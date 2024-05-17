<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.auth.login');
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
    public function store(AuthRequest $request)
    {
        if (Auth::guard('web')->attempt($request->validated()))
        {
            return response()->json([
                'status' => 'success',
                'redirect' => 'dashboard'
            ]);
        }

        if (Auth::guard('therapist')->attempt($request->validated()))
        {
            return response()->json([
                'status' => 'success',
                'redirect' => 'therapist.dashboard'
            ]);
        }

        return response()->json([
            'status' => 'false',
            'redirect' => 'login',
            'password' => 'invalid Password'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
