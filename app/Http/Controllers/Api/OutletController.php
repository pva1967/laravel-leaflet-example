<?php

namespace App\Http\Controllers\Api;

use App\Outlet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Outlet as OutletResource;

class OutletController extends Controller
{

    /**
     * Get outlet listing on Leaflet JS geoJSON data structure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */

    public function index()
    {

        $user_id =  $_GET['user_id'];
        $isAdmin =  $_GET['isAdmin'];

        if ($isAdmin){
            $outlets = Outlet::all();
        }
        else {
            $outlets = Outlet::where('creator_id', $user_id)->get();
        }

        $geoJSONdata = $outlets->map(function ($outlet) {
            return [
                'type'       => 'Feature',
               // 'auth_userid' => $outlet->creator_id,
                'properties' => new OutletResource($outlet),
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [
                        $outlet->longitude?? '30',
                        $outlet->latitude ?? '60',
                    ],
                ],
            ];
        });
        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $geoJSONdata,
        ]);
    }
}
