<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
                'redirect' => 'dashboard'
            ]);
        }

        return response()->json([
            'status' => 'false',
            'redirect' => 'login',
            'password' => 'invalid Password'
        ]);
    }

    public function signOut()
    {
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();

        return response()->json([
            'message' => 'Anda Berhasil Keluar'
        ]);
    }
}
