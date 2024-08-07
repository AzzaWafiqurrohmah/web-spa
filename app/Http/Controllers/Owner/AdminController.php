<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\owner\AdminRequest;
use App\Http\Resources\owner\AdminResource;
use App\Models\Franchise;
use App\Models\Setting;
use App\Models\User;
use App\Repository\owner\AdminRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $franchises = Franchise::all();
        return view('pages.owner.admin.index', [
            'franchises' => $franchises
        ]);
    }

    public function create(){
        $franchises = Franchise::all();
        return view('pages.owner.admin.create', [
            'franchises' => $franchises
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        AdminRepository::save($request->validated());
        return to_route('admin.index')->with('alert_s', 'Berhasil menambahkan data admin');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->success(
            AdminResource::make($user),
            'Berhasil mengambil data'
        );
    }

    public function edit(User $user)
    {
        $franchises = Franchise::all();

        $data = Setting::where('user_id', $user->id)->get(['key', 'value']);
        $setting = $data->pluck(null, 'key')->map(function ($item) {
            return $item['value'];
        })->toArray();

        return view('pages.owner.admin.edit', [
            'user' => $user,
            'franchises' => $franchises,
            'setting' => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, User $user)
    {
        AdminRepository::update($user, $request->validated());

        return to_route('admin.index')->with('alert_s', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Setting::where('user_id', $user->id)->delete();
        $user->delete();
        return $this->success(
            message: 'Berhasil menghapus data Admin'
        );
    }

    public function datatables()
    {
        return datatables(User::role('admin'))
        ->addIndexColumn()
        -> addColumn('franchise_name', fn($user) => $user->franchise->name)
        ->addColumn('action', fn($user) => view('pages.owner.admin.action', compact('user')))
        ->toJson();
    }

    public function json()
    {
        $users = User::role('admin')->get();
        return $this->success([
            AdminResource::collection($users),
            'Berhasil mendapatkan semua user'
        ]);
    }
}
