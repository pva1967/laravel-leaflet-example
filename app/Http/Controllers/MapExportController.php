<?php

namespace App\Http\Controllers;

use App;
use App\Outlet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminDataController;

class MapExportController extends Controller
{
    /**
     * Show the outlet listing in LeafletJS map.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    protected $address_street, $address_city;
    public function index()
    {


        $outlets = DB::table('outlets')
            ->join('institutions', 'outlets.creator_id', '=', 'institutions.creator_id')
            ->join('instnames', 'instnames.id', '=', 'institutions.inst_name_id')
            ->select('outlets.latitude', 'outlets.longitude', 'outlets.name', 'instnames.name_ru')
            ->orderby('name_ru')
            ->get();

        foreach ($outlets as $outlet) {
            $this->address($outlet->latitude, $outlet->longitude, 'ru');
            $outlet->address_street = $this->address_street;
            $outlet->address_city = $this->address_city;
        }

        return view('outlets.map_export', compact('outlets'));

    }
    public function address($lat, $lon, $language)
    {
        $key = config('app.google_key');
        $url="https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lon}&key={$key}&language={$language}";
        // get the json response
        $resp_json = file_get_contents($url);
        // decode the json
        $res = json_decode($resp_json, true);
        $this->address_city = '';
        $this->address_street = '';
        $address_route =''; $address_number ='';

        if (isset($res['results'][0])) {


            foreach ($res['results'][0]['address_components'] as $addr) {
                switch ($addr['types'][0]) {
                    case 'street_number':
                        $address_number = $addr['long_name'];
                        break;
                    case 'route':
                        $address_route = $addr['long_name'];
                        break;
                    case 'locality' :
                        $this->address_city = $addr['long_name'];
                        break;
                }
            }
        }

        $this->address_street = "{$address_route}, {$address_number}";
    }
}
