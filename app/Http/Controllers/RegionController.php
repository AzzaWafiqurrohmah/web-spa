<?php

namespace App\Http\Controllers;

use App\Exceptions\RegionException;
use App\Models\Region;
use App\Repository\RegionRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    use ApiResponser;

    private RegionRepository $repo;

    public function __construct()
    {
        $this->repo = new RegionRepository;
    }

    public function show(Region $region)
    {
        try {
            $data = $this->repo->getLatLong($region->name);

            return $this->success([
                'name' => $region->name,
                'code' => $region->code,
                'lat' => $data->lat,
                'long' => $data->lon,
            ]);
        } catch (RegionException $e) {
            return $this->error($e->getMessage());
        }
    }

    public function regency(Request $request)
    {
        $regencies = Region::where('parent', $request->prov_code)
            ->where('name', 'LIKE', "%{$request->q}%")
            ->get();

        return $this->success($regencies->map(fn ($reg) => [
            'id' => $reg->code,
            'text' => $reg->name,
        ]));
    }
}
