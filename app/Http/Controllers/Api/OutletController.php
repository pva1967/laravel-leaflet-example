<?php

namespace App\Http\Controllers\Api;

use App\Outlet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Outlet as OutletResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{

    /**
     * Get outlet listing on Leaflet JS geoJSON data structure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
    {

        $user_id =  $_GET['user_id'];
        $outlets = Outlet::where('creator_id', $user_id )->get();

        /*$user=Auth::user();
         $outlets = DB::table('outlets')->get();
        $outlets = Outlet::all();
        $outletQuery = Outlet::query();
        $outlets = Outlet::where('creator_id', $user->id)->get();*/
        $geoJSONdata = $outlets->map(function ($outlet) {
            return [
                'type'       => 'Feature',
                'auth_userid' => $outlet->creator_id,
                'properties' => new OutletResource($outlet),
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [
                        $outlet->longitude,
                        $outlet->latitude,
                    ],
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'auth_userid' => $user_id,
            'features' => $geoJSONdata,
        ]);
    }
}
