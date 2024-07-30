<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $settings = Setting::where('user_id', $user->id)->get();
        return view('pages.admin.setting.index', [
            'settings' => $settings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingRequest $request)
    {
        $user = Auth::user();

        array_map(function ($key, $value) use ($user){
            Setting::query()
                ->where('user_id',$user->id)
                ->where('key', $key)
                ->update(['value' => $value]);
        }, array_keys($request->setting), array_values($request->setting));
        return back()->with('alert_s', 'Berhasil mengubah pengaturan');
    }

}
